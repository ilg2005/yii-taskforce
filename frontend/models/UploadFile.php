<?php


namespace frontend\models;


use yii\base\Model;

class UploadFile extends Model
{
    public $avatar;

    public function rules()
    {
        return [
            [['avatar'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->avatar->saveAs('uploads/' . $this->avatar->baseName . '.' . $this->avatar->extension);
            return true;
        }
        return false;
    }
}
