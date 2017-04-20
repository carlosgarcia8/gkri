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
}
