<?php


namespace frontend\models;


use yii\base\Model;
use yii\helpers\FileHelper;

class UploadFiles extends Model
{
    public static function upload($uploadedFileData)
    {
        $dir = './uploads';
        if (!is_dir($dir)) {
            FileHelper::createDirectory($dir, 0755, true);
        }
        if (!is_array($uploadedFileData)) {
            $uploadedFileData->saveAs("{$dir}/{$uploadedFileData->baseName}_" . date('Y-m-d') . ".{$uploadedFileData->extension}");
        } else {
            foreach ($uploadedFileData as $file) {
                $file->saveAs("{$dir}/{$file->baseName}_" . date('Y-m-d') . '.' . $file->extension);
            }
        }

    }
}
