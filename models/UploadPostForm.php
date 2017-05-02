<?php

namespace app\models;

use Imagine\Image\Box;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;
use yii\imagine\Image;
use \CloudConvert\Api;

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
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => ['png', 'jpg', 'gif'],'maxSize' => 1024*1024*3],
        ];
    }

    /**
     * Se realiza la subida de la imagen haciendose una miniatura de 225x225
     * @param int $id el id del post que cogera el nombre el archivo
     * @return bool true en caso de subida compledada y false en caso contrario
     */
    public function upload($id)
    {
        if ($this->validate()) {
            $extension = $this->imageFile->extension;
            $ruta = Yii::getAlias('@posts/') . $id . '.' . $extension;

            if ($extension === 'gif') {
                // TODO revisar si me quedan minutos en cloudconvert, sino dar error
                $this->imageFile->saveAs(Yii::getAlias('@posts/') . $id . '.' . $extension);
                $imagen = Image::getImagine()
                    ->open(Yii::getAlias('@posts/') . $id . '.' . $extension);

                shell_exec('convert ' . Yii::getAlias('@posts/') . $id . '.' . $extension . ' -resize 455x' . $imagen->getSize()->getHeight() . ' '
                    . Yii::getAlias('@posts/') . $id . '-resized.' . $extension);

                unlink(Yii::getAlias('@posts/') . $id . '.gif');

                $api = new Api(getenv('CC_KEY'));
                $api->convert([
                    'inputformat' => 'gif',
                    'outputformat' => 'mp4',
                    'input' => 'upload',
                    'file' => fopen(Yii::getAlias('@posts/') . $id . '-resized.gif', 'r'),
                ])
                ->wait()
                ->download(Yii::getAlias('@posts/') . $id . '.mp4');

                unlink(Yii::getAlias('@posts/') . $id . '-resized.gif');

                $rutamp4 = Yii::getAlias('@posts/') . $id . '.mp4';
                $s3 = Yii::$app->get('s3');
                $s3->upload($rutamp4, $rutamp4);

                return true;
            }

            $this->imageFile->saveAs(Yii::getAlias('@posts/') . $id . '.' . $extension);
            $imagen = Image::getImagine()
                ->open(Yii::getAlias('@posts/') . $id . '.' . $extension);
            $imagen->thumbnail(new Box(455, $imagen->getSize()->getHeight()))
                    ->save(Yii::getAlias('@posts/') . $id . '.' . $extension, ['quality' => 90]);

            $s3 = Yii::$app->get('s3');
            $nombreS3 = Yii::getAlias('@posts/') . $id . '.' . $extension;
            $s3->upload($ruta, $ruta);
            return true;
        } else {
            return false;
        }
    }
}
