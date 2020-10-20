<?php
namespace taskforce\constants;



class TaskStrategy
{
    private $workerId;
    private $customerId;
    private $deadline;
    private $activeStatus;

    public function getTaskStatuses()
    {
        return [
            TaskStatuses::NEW => 'Новое',
            TaskStatuses::CANCELED => 'Отменено',
            TaskStatuses::ACTIVE => 'В работе',
            TaskStatuses::COMPLETED => 'Выполнено',
            TaskStatuses::FAILED => 'Провалено'
        ];
    }

    public function getUserRoles() {
        return [
            UserRoles::CUSTOMER => 'Заказчик',
            UserRoles::WORKER => 'Исполнитель'
        ];
    }

    public function getUserActions() {
        return [
            UserActions::CREATE => 'Создать',
            UserActions::CANCEL => 'Отменить',
            UserActions::START => 'Начать',
            UserActions::COMPLETE => 'Завершить',
            UserActions::RESPOND => 'Ответить',
            UserActions::ABANDON => 'Отказаться'
        ];
    }

    public function getWorkerCategories() {
        return [
            WorkerCategories::TRANSLATION => 'Переводы',
            WorkerCategories::CLEAN => 'Уборка',
            WorkerCategories::CARGO => 'Грузоперевозки',
            WorkerCategories::NEO => 'Компьютерная помощь',
            WorkerCategories::FLAT => 'Ремонт квартирный',
            WorkerCategories::BEAUTY => 'Красота',
            WorkerCategories::REPAIR => 'Ремонт техники',
            WorkerCategories::PHOTO => 'Фото',
            WorkerCategories::DELIVERY => 'Курьерские услуги'
        ];
    }

    public function getStatusAfterAction($action)
    {
        switch ($action) {
            case UserActions::CREATE:
                $status = TaskStatuses::NEW;
                break;
            case UserActions::CANCEL:
                $status = TaskStatuses::CANCELED;
                break;
            case UserActions::START:
                $status = TaskStatuses::ACTIVE;
                break;
            case UserActions::COMPLETE:
                $status = TaskStatuses::COMPLETED;
                break;
            case UserActions::ABANDON:
                $status = TaskStatuses::FAILED;
                break;
            default:
                $status = false;
                break;
        }
        return $status;
    }

    public static function checkAccess($user, $action) {
        switch ($action) {
            case UserActions::CREATE:
                $access = ($user->role === UserRoles::CUSTOMER);
                break;
            default:
                $access = false;
                break;
        }
        return $access;
    }


}
