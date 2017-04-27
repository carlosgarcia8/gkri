<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii2mod\moderation\ModerationQuery;
use yii2mod\moderation\ModerationBehavior;
use yii2mod\moderation\enums\Status;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $titulo
 * @property string $extension
 * @property integer $usuario_id
 * @property string $fecha_publicacion
 * @property boolean $longpost
 * @property integer $status_id
 * @property integer $moderated_by
 *
 * @property Downvotes[] $downvotes
 * @property User[] $usuarios
 * @property User $usuario
 * @property User $moderatedBy
 * @property Upvotes[] $upvotes
 * @property User[] $usuarios0
 */
class Post extends \yii\db\ActiveRecord
{
    public $imageFile;

    const SCENARIO_UPLOAD = 'upload';
    const SCENARIO_MODERAR = 'moderar';
    const SCENARIO_UPDATE = 'update';

    /**
     * Los distintos escenarios de este modelo
     * @return mixed
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_UPLOAD => [
                'titulo',
                'usuario_id',
                'status_id',
                'fecha_publicacion',
                'longpost',
                'imageFile',
                'moderated_by',
                'categoria_id',
            ],
            self::SCENARIO_MODERAR => [
                'titulo',
                'usuario_id',
                'status_id',
                'fecha_publicacion',
                'longpost',
                'moderated_by',
                'categoria_id',
            ],
            self::SCENARIO_UPDATE => [
                'titulo',
                'usuario_id',
                'status_id',
                'fecha_publicacion',
                'longpost',
                'moderated_by',
                'categoria_id',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo', 'categoria_id'], 'required'],
            [['usuario_id', 'status_id', 'moderated_by'], 'integer'],
            [['fecha_publicacion'], 'safe'],
            [['longpost'], 'boolean'],
            [['titulo'], 'string', 'max' => 100],
            ['imageFile', 'image', 'skipOnEmpty' => false,
                'extensions' => 'png, jpg, gif',
                'minWidth' => 450, 'maxWidth' => 2000,
                'minHeight' => 300, 'maxHeight' => 20000,
            ],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['moderated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['moderated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => ModerationBehavior::class,
                'statusAttribute' => 'status_id',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Título',
            'extension' => 'Extension',
            'usuario_id' => 'Usuario ID',
            'fecha_publicacion' => 'Fecha Publicacion',
            'longpost' => 'Longpost',
            'status_id' => 'Status ID',
            'moderated_by' => 'Moderated By',
        ];
    }

    public static function find()
    {
        return new ModerationQuery(get_called_class());
    }

    /**
     * Realiza la subida de la imagen del post
     * @return bool
     */
    public function upload()
    {
        $model = new UploadPostForm;

        if (Yii::$app->request->isPost) {
            $model->imageFile = $this->imageFile;
            $model->titulo = $this->titulo;
            if ($model->upload($this->id)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Obtiene la ruta de la imagen del post
     * @return string ruta hacia la imagen
     */
    public function getRuta()
    {
        $uploadsPosts = Yii::getAlias('@posts');
        $uploadsAvatar = Yii::getAlias('@avatar');
        // TODO esta puesto un default de avatar para los posts, wtf
        // TODO solo puede ser jpg, habria que cambiarlo
        $fichero = "{$this->id}.jpg";
        $ruta = "$uploadsPosts/{$fichero}";

        $s3 = Yii::$app->get('s3');

        if (file_exists($ruta)) {
            return "/$ruta";
        } elseif ($s3->exist($ruta)) {
            $s3->commands()->get($ruta)->saveAs($ruta)->execute();
            return "/$ruta";
        } else {
            return "/$uploadsAvatar/default.jpg";
        }
        // TODO que hacer si no existe ni localmente ni remotamente
    }

    /**
     * Obtiene los votos del post
     * @return \yii\db\ActiveQuery
     */
    public function getVotos()
    {
        return $this->hasMany(Voto::className(), ['post_id' => 'id'])->inverseOf('post');
    }

    /**
     * Saber si el post esta votado positivo por el usuario logeado
     * @return bool
     */
    public function estaUpvoteado()
    {
        return $this->getVotos()->where(['usuario_id' => Yii::$app->user->id, 'positivo' => true])->one() !== null;
    }

    /**
     * Saber si el post esta votado negativo por el usuario logeado
     * @return bool
     */
    public function estaDownvoteado()
    {
        return $this->getVotos()->where(['usuario_id' => Yii::$app->user->id, 'positivo' => false])->one() !== null;
    }

    /**
     * Obtiene los votos positivos del post
     * @return \yii\db\ActiveQuery
     */
    public function getVotosPositivos()
    {
        return $this->getVotos()->where(['positivo' => true]);
    }

    /**
     * Obtiene los votos negativos del post
     * @return \yii\db\ActiveQuery
     */
    public function getVotosNegativos()
    {
        return $this->getVotos()->where(['positivo' => false]);
    }

    /**
     * Obtiene la resta entre los votos positivos y negativos
     * @return integer
     */
    public function getVotosTotal()
    {
        return $this->getVotosPositivos()->count() - $this->getVotosNegativos()->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getUsuarios()
    // {
    //     return $this->hasMany(User::className(), ['id' => 'usuario_id'])->viaTable('downvotes', ['post_id' => 'id']);
    // }

    /**
     * Obtiene el usuario que ha creado este post
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_id'])->inverseOf('posts');
    }

    /**
     * Obtiene la categoria de este post
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'categoria_id'])->inverseOf('posts');
    }

    /**
     * Obtiene el usuario que ha moderado este post
     * @return \yii\db\ActiveQuery
     */
    public function getModeradoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'moderated_by'])->inverseOf('moderaciones');
    }

    /**
     * Obtiene los comentarios de este post
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return \app\models\CommentModel::find()->where(['entityId' => $this->id]);
    }

    /**
     * Obtiene el numero de comentarios
     * @return integer
     */
    public function getNumeroComentarios()
    {
        return $this->getComentarios()->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getUpvotes()
    // {
    //     return $this->hasMany(Upvotes::className(), ['post_id' => 'id'])->inverseOf('post');
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getUsuarios0()
    // {
    //     return $this->hasMany(User::className(), ['id' => 'usuario_id'])->viaTable('upvotes', ['post_id' => 'id']);
    // }
}
