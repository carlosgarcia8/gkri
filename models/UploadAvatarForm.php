<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;
use yii\imagine\Image;

class UploadAvatarForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'extensions' => ['jpg', 'png'], 'maxSize' => 1024*1024*1],
        ];
    }

    /**
     * Se realiza la subida de la imagen haciendose una miniatura de 225x225
     * @return bool true en caso de subida compledada y false en caso contrario
     */
    public function upload()
    {
        if ($this->validate()) {
            $nombre = Yii::getAlias('@avatar/')
                . \Yii::$app->user->id . '.' . $this->imageFile->extension;
            $userId = \Yii::$app->user->id;
            $result = glob(Yii::getAlias('@avatar/') . "$userId.*");

            $s3 = Yii::$app->get('s3');

            foreach ($result as $r) {
                unlink($r);
                if ($s3->exist($r)) {
                    $s3->delete($r);
                }
            }
            $this->imageFile->saveAs($nombre);
            Image::thumbnail($nombre, 225, 225)
                ->save($nombre, ['quality' => 80]);
            $s3 = Yii::$app->get('s3');
            $nombreS3 = Yii::getAlias('@avatar/') . \Yii::$app->user->id . '.' . $this->imageFile->extension;
            $s3->upload($nombreS3, $nombre);

            return true;
        } else {
            return false;
        }
    }
}
