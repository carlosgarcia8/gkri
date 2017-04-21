<?php

namespace app\models;

use yii2mod\comments\models\CommentModel as BaseCommentModel;
use Yii;

class CommentModel extends BaseCommentModel
{
    public function isChild()
    {
        return $this->parentId != null;
    }

    /**
     * @return bool
     */
    public function tieneHijos()
    {
        return !empty(CommentModel::find()
            ->where(['parentId' => $this->id])
            ->all());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotos()
    {
        return $this->hasMany(VotoComentario::className(), ['comentario_id' => 'id'])->inverseOf('comentario');
    }

    /**
     * @return bool
     */
    public function estaUpvoteado()
    {
        return $this->getVotos()->where(['usuario_id' => Yii::$app->user->id, 'positivo' => true])->one() !== null;
    }

    /**
     * @return bool
     */
    public function estaDownvoteado()
    {
        return $this->getVotos()->where(['usuario_id' => Yii::$app->user->id, 'positivo' => false])->one() !== null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotosPositivos()
    {
        return $this->getVotos()->where(['positivo' => true]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotosNegativos()
    {
        return $this->getVotos()->where(['positivo' => false]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotosTotal()
    {
        return $this->getVotosPositivos()->count() - $this->getVotosNegativos()->count();
    }
}
