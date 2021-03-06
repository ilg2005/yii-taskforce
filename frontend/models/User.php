<?php


namespace frontend\models;


use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{

    public function rules()
    {
        return [
            [['name', 'town', 'email', 'password', 'registration_date', 'role', 'latest_activity_time', 'is_favorite'], 'safe'],
            ['email', 'email'],
            ['email', 'unique'],
        ];
    }

    public function getTasks()
    {
        return $this->hasMany(Task::class, ['worker_id' => 'id']);
    }


    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])
            ->viaTable('users_categories', ['user_id' => 'id']);
    }


    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id']);
    }

    public function getAvatar()
    {
        return $this->profile->avatar_file ?? 'no-image-available.jpg';
    }


    public function getPortfolio() {
        return $this->hasMany(File::class, ['id' => 'file_id'])
            ->viaTable('users_portfolio', ['user_id' => 'id']);
    }


    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::class, ['worker_id' => 'id']);
    }

    public function getViews()
    {
        return $this->hasMany(ProfileView::class, ['viewed_user_id' => 'id']);

    }

    public function getSettings()
    {
        return $this->hasOne(Setting::class, ['user_id' => 'id']);
    }

    public function getRating()
    {
        $defaultRating = 0;

        $totalRate =  Feedback::find()->where(['worker_id' => $this->id])->sum('rate');
        $taskCount =  Feedback::find()->where(['worker_id' => $this->id])->count('task_id');

        return $taskCount ? round(($totalRate / $taskCount), 1) : $defaultRating;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }


    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritDoc
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritDoc
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}
