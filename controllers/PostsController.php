<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ServerErrorHttpException;
use yii2mod\moderation\enums\Status;
use app\models\Categoria;

/**
 * PostsController implements the CRUD actions for Post model.
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
                'only' => ['update', 'delete', 'moderar', 'aceptar', 'rechazar', 'view', 'upload'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['moderar', 'update', 'delete', 'aceptar', 'rechazar', 'view', 'upload'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['upload'],
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex($categoria = null)
    {
        $categoria = Categoria::findOne(['nombre_c' => $categoria]);

        if ($categoria != null) {
            $dataProvider = new ActiveDataProvider([
                'query' => $categoria->getPosts()->approved()->orderBy(['fecha_publicacion' => SORT_DESC]),
                'pagination' => [
                    'pageSize' => 10,
                ]
            ]);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => Post::find()->approved()->orderBy(['fecha_publicacion' => SORT_DESC]),
                'pagination' => [
                    'pageSize' => 10,
                ]
            ]);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
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

        return $this->render('view', [
            'model' => $model,
            'esAdmin' => $esAdmin,
            'esAutor' => $esAutor,
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
                $model->markPending();

                if ($model->save() && $model->upload()) {
                    \Yii::$app->getSession()->setFlash('upload', 'Gracias por su aportación. En breve un moderador lo evaluara.');
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
     * @param integer $id
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
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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

    public function actionAceptar($id)
    {
        $post = $this->findModel($id);

        $post->scenario = Post::SCENARIO_MODERAR;
        date_default_timezone_set('Europe/Madrid');
        $post->fecha_confirmacion = date('Y-m-d H:i:s');
        $post->markApproved();

        return $this->redirect(['/moderar']);
    }

    public function actionRechazar($id)
    {
        $post = $this->findModel($id);

        $post->scenario = Post::SCENARIO_MODERAR;
        $post->markRejected();

        return $this->redirect(['/moderar']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
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
