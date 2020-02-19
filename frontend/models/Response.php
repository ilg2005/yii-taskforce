<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class Response extends ActiveRecord
{
    public function rules()
    {
        return [
            [['task_id', 'worker_id', 'worker_price', 'worker_comment'], 'safe'],
        ];
    }

    public static function getTaskIDs()
    {
        $arrayFromDB = array_values(self::find()->select('task_id')->asArray()->all());
        $res = [];
        foreach ($arrayFromDB as $value) {
            $res[] = (int)$value['task_id'];
        }
        return $res;
    }

    public static function tableName()
    {
        return 'tasks_responses';
    }
}
