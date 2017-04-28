<?php

namespace app\models;

use app\models\CommentModel;

/**
 * This is the model class for table "comment_votos".
 *
 * @property integer $id
 * @property string $entity
 * @property integer $entityId
 * @property string $content
 * @property integer $parentId
 * @property integer $level
 * @property integer $createdBy
 * @property integer $updatedBy
 * @property integer $status
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property string $relatedTo
 * @property string $url
 * @property integer $comentario_id
 * @property integer $votos
 */
class CommentVoto extends CommentModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_comment_votos';
    }
}
