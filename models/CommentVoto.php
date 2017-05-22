<?php

namespace app\models;

use app\models\CommentModel;

/**
 * Este es el modelo para la tabla "votos_c" que aun asi usa una vista para su fin.
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
