<?php

namespace app\models;

use Imagine\Image\Box;
use Imagine\Image\Point;
use phpDocumentor\Reflection\Types\Boolean;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;
use yii\imagine\Image;

class UploadPostForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * @var
     */
    public $titulo;

    public function rules()
    {
        return [
            [['titulo', 'imageFile'],'required'],
            [['titulo'], 'string', 'max' => 100],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * Se realiza la subida de la imagen haciendose una miniatura de 225x225
     * @return boolean true en caso de subida compledada y false en caso contrario
     */
    public function upload($id)
    {
        if ($this->validate()) {
            $extension = $this->imageFile->extension;
            $ruta = Yii::getAlias('@posts/') . $id . '.' . $extension;

            if ($extension === 'gif') {
                return true;
            }

            $this->imageFile->saveAs(Yii::getAlias('@posts/') . $id . '.' . $extension);
            $imagen = Image::getImagine()
                ->open(Yii::getAlias('@posts/') . $id . '.' . $extension);
            $imagen->thumbnail(new Box(455, $imagen->getSize()->getHeight()))
                    ->save(Yii::getAlias('@posts/') . $id . '.' . $extension, ['quality' => 90]);
            // if ($this->longpost) {
            //     $imagen->crop(new Point(0, 0), new Box(500, 260));
            //     $imagen->save(Yii::getAlias('@posts/') . $id . '-longpost.' . $this->extension, ['quality' => 90]);
            // }
            $s3 = Yii::$app->get('s3');
            $nombreS3 = Yii::getAlias('@posts/') . $id . '.' . $extension;
            $s3->upload($nombreS3, $ruta);
            return true;
        } else {
            return false;
        }
    }
}
