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
            ],
            self::SCENARIO_MODERAR => [
                'titulo',
                'usuario_id',
                'status_id',
                'fecha_publicacion',
                'longpost',
                'moderated_by',
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
            [['titulo'], 'required'],
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
            'titulo' => 'Titulo',
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

    public function getRuta()
    {
        $uploadsPosts = Yii::getAlias('@posts');
        $fichero = "{$this->id}.jpg";
        $ruta = "$uploadsPosts/{$fichero}";

        // $s3 = Yii::$app->get('s3');
        if (file_exists($ruta)) {
            return "/$ruta";
        } else {
            return false;
        }

        // if (file_exists($ruta)) {
        //     return "/$ruta";
        // } elseif ($s3->exist($ruta)) {
        //     $s3->commands()->get($ruta)->saveAs($ruta)->execute();
        //     return "/$ruta";
        // } else {
        //     return "/$uploadsAvatar/default.jpg";
        // }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getDownvotes()
    // {
    //     return $this->hasMany(Downvotes::className(), ['post_id' => 'id'])->inverseOf('post');
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getUsuarios()
    // {
    //     return $this->hasMany(User::className(), ['id' => 'usuario_id'])->viaTable('downvotes', ['post_id' => 'id']);
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_id'])->inverseOf('posts');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModeradoPor()
    {
        return $this->hasOne(User::className(), ['id' => 'moderated_by'])->inverseOf('moderaciones');
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
