<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Voto;
use app\models\Post;
use app\models\Notificacion;
use app\models\enums\NotificationType;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ServerErrorHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii2mod\moderation\enums\Status;
use app\models\Categoria;
use yii\helpers\Json;
use linslin\yii2\curl;

/**
 * Clase PostsController
 */
class PostsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['update', 'delete', 'moderar', 'aceptar', 'rechazar', 'view', 'upload', 'generador', 'generador-crear'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['moderar', 'update', 'delete', 'aceptar', 'rechazar', 'view', 'upload', 'generador', 'generador-crear'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['upload', 'generador', 'generador-crear'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Post::findOne(Yii::$app->request->get('id'))->usuario_id == Yii::$app->user->id;
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['@', '?'],
                        'matchCallback' => function ($rule, $action) {
                            $post = Post::findOne(Yii::$app->request->get('id'));
                            if ($post != null) {
                                if ($post->status_id == Status::APPROVED) {
                                    return true;
                                } else {
                                    throw new NotFoundHttpException('La página que esta buscando no existe.');
                                }
                            } else {
                                throw new NotFoundHttpException('La página que esta buscando no existe.');
                            }
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * List all Post models
     * @param  string $categoria categoria a buscar
     * @return mixed
     */
    public function actionIndex($categoria = null)
    {
        $categoriaModel = Categoria::findOne(['nombre_c' => $categoria]);
        $existeCategoria = $categoriaModel !== null;

        $diezMejores = Post::find()
            ->select('posts.id, titulo, extension')
            ->join('left join', '(select * from votos where positivo = true) as v', 'posts.id=v.post_id')
            ->where(['not like', 'extension', 'gif'])
            ->groupBy('id')
            ->orderBy('count(positivo) desc')
            ->limit(10)
            ->approved()
            ->all();

        if ($existeCategoria) {
            $dataProvider = new ActiveDataProvider([
                'query' => $categoriaModel->getPosts()->approved()->orderBy(['fecha_publicacion' => SORT_DESC]),
                'pagination' => [
                    'pageSize' => 8,
                    'defaultPageSize' => 8
                ]
            ]);
            $categoria = $categoriaModel->nombre;
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => Post::find()->approved()->orderBy(['fecha_publicacion' => SORT_DESC]),
                'pagination' => [
                    'pageSize' => 8,
                    'defaultPageSize' => 8
                ]
            ]);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'existeCategoria' => $existeCategoria,
            'categoria' => $categoria,
            'diezMejores' => $diezMejores,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param int $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->isGuest) {
            $esAdmin = false;
            $esAutor = false;
        } else {
            $esAdmin = Yii::$app->user->identity->isAdmin;
            $esAutor = $model->usuario_id === Yii::$app->user->identity->id;
        }

        $autor = $model->getUsuario()->one();

        return $this->render('view', [
            'model' => $model,
            'esAdmin' => $esAdmin,
            'esAutor' => $esAutor,
            'autor' => $autor,
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpload()
    {
        if (!empty(Yii::$app->user->identity->getPostPendiente())) {
            \Yii::$app->getSession()->setFlash('upload', 'Aun se está evaluando su anterior Post. Espere a que se evalúe y podrá volver a enviar otro. Gracias por su paciencia :D.');
            return $this->redirect(['/']);
        }

        $model = new Post(['scenario' => Post::SCENARIO_UPLOAD]);
        $categorias = Categoria::find()->select('nombre')->indexBy('id')->column();

        if ($model->load(Yii::$app->request->post())) {
            $imagen = UploadedFile::getInstance($model, 'imageFile');
            $model->usuario_id = Yii::$app->user->id;

            if ($imagen !== null) {
                $model->imageFile = $imagen;
                $model->extension = $imagen->extension;

                if ($model->extension == 'gif') {
                    $curl = new curl\Curl;
                    $response = $curl->setGetParams([
                        'apikey' => getenv('CC_KEY')
                    ])
                    ->get('https://api.cloudconvert.com/user');
                    $respuesta = json_decode($response);

                    if ($respuesta->minutes == 0) {
                        \Yii::$app->getSession()->setFlash('error', 'En estos momentos los Gifs no se pueden subir a la plataforma :(. Pruébelo de nuevo más tarde. Gracias por su paciencia :D.');
                        return $this->redirect(['/upload']);
                    }
                }

                if (Yii::$app->user->identity->isAdmin) {
                    $model->markApproved();

                    date_default_timezone_set('Europe/Madrid');
                    $model->fecha_confirmacion = date('Y-m-d H:i:s');

                    $user = User::findOne(['id' => $model->usuario_id]);

                    $seguidores = $user->getSeguidoresUser()->all();

                    foreach ($seguidores as $seguidor) {
                        $notificacion = new Notificacion();

                        $notificacion->type = NotificationType::POST_NUEVO;
                        $notificacion->user_id = $seguidor->id;
                        $notificacion->post_id = $model->id;
                        $notificacion->user_related_id = $model->usuario_id;

                        $notificacion->save();
                    }
                } else {
                    $model->markPending();
                }

                if ($model->save() && $model->upload()) {
                    if (!Yii::$app->user->identity->isAdmin) {
                        \Yii::$app->getSession()->setFlash('upload', 'Gracias por su aportación. En breve un moderador lo evaluará.');
                    }
                    return $this->redirect(['/']);
                } else {
                    $model->delete();
                    \Yii::$app->getSession()->setFlash('error', 'Ha habido un problema en la subida del archivo. Esperamos poder resolverlo pronto. Gracias por su paciencia.');
                    return $this->redirect(['/']);
                }
            } else {
                throw new ServerErrorHttpException('Error Interno');
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'categorias' => $categorias,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Post::SCENARIO_UPDATE;

        $categorias = Categoria::find()->select('nombre')->indexBy('id')->column();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categorias' => $categorias,
            ]);
        }
    }

    /**
     * Acción para el generador de posts el cual obtiene la ruta de todas las imagenes
     * y se las manda a la vista
     * @return mixed
     */
    public function actionGenerador()
    {
        $ficheros = FileHelper::findFiles(Yii::getAlias('@generador'));

        $nombres = [];

        foreach ($ficheros as $fichero) {
            array_push($nombres, explode('/', $fichero)[2]);
        }

        return $this->render('generador', [
            'ficheros' => $nombres,
        ]);
    }

    /**
     * Cuando se selecciona una imagen con la que generar un meme se le pasara dicho fichero
     * a la vista generador-crear
     * @param  string $fichero nombre del fichero
     * @return mixed
     */
    public function actionGeneradorCrear($fichero)
    {
        $ruta = Yii::getAlias('@generador') . "/$fichero";

        return $this->render('generador-crear', [
            'fichero' => $ruta,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        $fichero = glob(Yii::getAlias('@posts/') . $id . '.*');

        if (!empty($fichero)) {
            unlink($fichero[0]);
        }

        $s3 = Yii::$app->get('s3');
        $ficheroS3 = $fichero[0];

        if ($s3->exist($ficheroS3)) {
            $s3->delete($ficheroS3);
        }

        return $this->redirect(['index']);
    }

    /**
     * Lists all Post models that need moderation.
     * @return mixed
     */
    public function actionModerar()
    {
        $post = Post::find()->pending()->orderBy(['fecha_publicacion' => SORT_ASC])->one();

        return $this->render('moderar', [
            'post' => $post,
        ]);
    }

    /**
     * Acepta aquellos posts que estan en moderación
     * @param  int $id id del post a aceptar
     * @return mixed
     */
    public function actionAceptar($id)
    {
        $post = $this->findModel($id);

        $post->scenario = Post::SCENARIO_MODERAR;
        date_default_timezone_set('Europe/Madrid');
        $post->fecha_confirmacion = date('Y-m-d H:i:s');
        $post->markApproved();

        $user = User::findOne(['id' => $post->usuario_id]);

        $seguidores = $user->getSeguidoresUser()->all();

        $notificacion = new Notificacion();

        $notificacion->type = NotificationType::POST_ACEPTADO;
        $notificacion->user_id = $post->usuario_id;
        $notificacion->post_id = $post->id;

        $notificacion->save();

        foreach ($seguidores as $seguidor) {
            $notificacion = new Notificacion();

            $notificacion->type = NotificationType::POST_NUEVO;
            $notificacion->user_id = $seguidor->id;
            $notificacion->post_id = $post->id;
            $notificacion->user_related_id = $post->usuario_id;

            $notificacion->save();
        }

        return $this->redirect(['/moderar']);
    }

    /**
     * Rechaza aquellos posts que estan en moderación
     * @param  int $id id del post a aceptar
     * @return mixed
     */
    public function actionRechazar($id)
    {
        $post = $this->findModel($id);

        $post->delete();

        $fichero = glob(Yii::getAlias('@posts/') . $id . '.*');

        if (!empty($fichero)) {
            unlink($fichero[0]);
        }

        $s3 = Yii::$app->get('s3');
        $ficheroS3 = $fichero[0];

        if ($s3->exist($ficheroS3)) {
            $s3->delete($ficheroS3);
        }

        return $this->redirect(['/moderar']);
    }

    /**
     * Realiza la votación de un post
     * @param  int $id       id del post
     * @param  bool    $positivo si es o no positivo
     * @return int           numero total de votos (resta positivos - negativos)
     */
    public function actionVotar($id, $positivo)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(Url::toRoute(['/user/login']));
        }

        $positivo = $positivo === 'true';
        $post = $this->findModel($id);
        $voto = new Voto();
        $usuarioId = Yii::$app->user->id;

        $votoGuardadoB = Voto::findOne(['usuario_id' => $usuarioId, 'post_id' => $id, 'positivo' => $positivo]);

        if ($votoGuardadoB) {
            $votoGuardadoB->delete();
            Notificacion::deleteAll(['type' => 1, 'user_id' =>  $post->usuario_id]);
            return $post->getVotosTotal();
        }

        $votoGuardado = Voto::findOne(['usuario_id' => $usuarioId, 'post_id' => $id]);

        if ($votoGuardado) {
            $votoGuardado->delete();
        }

        $voto->usuario_id = $usuarioId;
        $voto->post_id = $id;
        $voto->positivo = $positivo;

        if ($usuarioId !== $post->usuario_id && Notificacion::findOne(['type' => 1, 'user_id' =>  $post->usuario_id]) == null) {
            $notificacion = new Notificacion;

            $notificacion->type = NotificationType::VOTADO;
            $notificacion->user_id = $post->usuario_id;
            $notificacion->post_id = $post->id;

            $notificacion->save();
        }


        $voto->save();
        return $post->getVotosTotal();
    }

    /**
     * Realiza la busqueda por titulo de los Posts
     * @param  string $q la cadena que correspondera con la busqueda del titulo
     * @return mixed
     */
    public function actionSearch($q = null)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()
                ->approved()
                ->where(['ilike', 'titulo', "$q%", false])
                ->orderBy(['fecha_publicacion' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 8,
                'defaultPageSize' => 8,
            ]
        ]);

        $diezMejores = Post::find()
            ->select('posts.id, titulo, extension')
            ->join('left join', '(select * from votos where positivo = true) as v', 'posts.id=v.post_id')
            ->where(['not like', 'extension', 'gif'])
            ->groupBy('id')
            ->orderBy('count(positivo) desc')
            ->limit(10)
            ->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'titulo' => $q,
            'diezMejores' => $diezMejores,
        ]);
    }

    /**
     * Acción que lleva a cabo la busqueda del post por titulo mediante ajax
     * @param  string $q cadena a buscar titulo
     * @return mixed
     */
    public function actionSearchAjax($q = null)
    {
        if (!Yii::$app->request->isAjax) {
            throw new MethodNotAllowedHttpException('Method Not Allowed. This url can only handle the following request methods: AJAX');
        }

        $posts = [];
        if ($q != null || $q != '') {
            $posts = Post::find()
            ->select(new Expression('distinct left(titulo,20)'))
            ->where(['ilike', 'titulo', "$q%", false])
            ->column();
        }
        return Json::encode($posts);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
