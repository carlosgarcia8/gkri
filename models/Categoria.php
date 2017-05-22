<?php

namespace app\models;

use Yii;

/**
 * Este es el modelo para la tabla "categorias".
 *
 * @property integer $id
 * @property string $nombre Nombre a mostrar
 * @property string $nombre_c Nombre para la url
 *
 * @property Posts[] $posts
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categorias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'nombre_c'], 'required'],
            [['nombre', 'nombre_c'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nombre' => Yii::t('app', 'Nombre'),
        ];
    }

    /**
     * Obtiene los posts que tienen la categoria seleccionada
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['categoria_id' => 'id'])->inverseOf('categoria');
    }
}
