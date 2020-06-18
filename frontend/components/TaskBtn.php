<?php


namespace frontend\components;


use frontend\models\User;
use taskforce\constants\TaskStatuses;
use taskforce\constants\UserRoles;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class TaskBtn extends Widget
{
    public $task;
    public $currentUserId;

    public function run()
    {
        $user = User::findOne($this->currentUserId);

        if ($user->role === UserRoles::WORKER && $this->task->status === TaskStatuses::NEW && !in_array($this->currentUserId,
                ArrayHelper::getColumn($this->task->responses, 'applicant_id'), true)) {
            $dataAttr = 'response';
            $btnClass = 'response';
            $btnName = 'Откликнуться';
        }

        if ($this->currentUserId === $this->task->worker_id && $this->task->status === TaskStatuses::ACTIVE) {
            $dataAttr = 'refuse';
            $btnClass = 'refusal';
            $btnName = 'Отказаться';
        }

        if ($this->currentUserId === $this->task->customer_id && $this->task->status === TaskStatuses::ACTIVE) {
            $dataAttr = 'complete';
            $btnClass = 'request';
            $btnName = 'Завершить';
        }

        return $this->render('taskbtn', compact('dataAttr', 'btnClass', 'btnName'));
    }
}
