<?php

namespace app\models;

use yii2mod\comments\models\CommentModel as BaseCommentModel;
use Yii;

class CommentModel extends BaseCommentModel
{
    /**
     * Saber si el comentario es hijo de otro comentario
     * @return boolean
     */
    public function isChild()
    {
        return $this->parentId != null;
    }

    /**
     * Saber si el comentario tiene hijos
     * @return bool
     */
    public function tieneHijos()
    {
        return !empty(CommentModel::find()
            ->where(['parentId' => $this->id])
            ->all());
    }

    /**
     * Get comments tree.
     *
     * @param string $entity
     * @param string $entityId
     * @param null $maxLevel
     *
     * @return array|ActiveRecord[]
     */
    public static function getTree($entity, $entityId, $maxLevel = null)
    {
        $query = CommentVoto::find()
            ->alias('c')
            ->approved()
            ->andWhere([
                'c.entityId' => $entityId,
                'c.entity' => $entity,
            ])
            ->with(['author']);

        if ($maxLevel > 0) {
            $query->andWhere(['<=', 'c.level', $maxLevel]);
        }
        // $connection = Yii::$app->getDb();
        // $command = $connection->createCommand(`
        //     SELECT * from comment_votos c where status=1
        //     and c."entityId" = $entityId and c."entity" = "$entity"
        //     `);
        //
        // var_dump($connection->createCommand(`
        //     SELECT * from comment_votos c where status=1
        //     and c."entityId" = $entityId and c."entity" = "$entity"
        //     `));
        // $result = $command->queryAll();
        // var_dump($result);


        $models = $query->all();
        // var_dump($models);
        // die();

        if (!empty($models)) {
            $models = static::buildTree($models);
        }

        return $models;
    }

    /**
     * Poder obtener los votos del comentario seleccionado
     * @return \yii\db\ActiveQuery
     */
    public function getVotos()
    {
        return $this->hasMany(VotoComentario::className(), ['comentario_id' => 'id'])->inverseOf('comentario');
    }

    /**
     * Saber si el comentario esta votado positivo por el usuario logeado
     * @return bool
     */
    public function estaUpvoteado()
    {
        return $this->getVotos()->where(['usuario_id' => Yii::$app->user->id, 'positivo' => true])->one() !== null;
    }

    /**
     * Saber si el comentario esta votado negativo por el usuario logeado
     * @return bool
     */
    public function estaDownvoteado()
    {
        return $this->getVotos()->where(['usuario_id' => Yii::$app->user->id, 'positivo' => false])->one() !== null;
    }

    /**
     * Obtener los votos positivos de este comentario
     * @return \yii\db\ActiveQuery
     */
    public function getVotosPositivos()
    {
        return $this->getVotos()->where(['positivo' => true]);
    }

    /**
     * Obtener los votos negativos de este comentario
     * @return \yii\db\ActiveQuery
     */
    public function getVotosNegativos()
    {
        return $this->getVotos()->where(['positivo' => false]);
    }

    /**
     * Obtener la resta entre los votos positivos y los votos negativos
     * @return \yii\db\ActiveQuery
     */
    public function getVotosTotal()
    {
        return $this->getVotosPositivos()->count() - $this->getVotosNegativos()->count();
    }
}
