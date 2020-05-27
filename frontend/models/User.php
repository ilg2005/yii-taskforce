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
            [['name', 'town', 'email', 'password', 'registration_date', 'profile_id', 'role', 'latest_activity_time', 'is_favorite', 'rating'], 'safe'],
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
        return $this->hasOne(Profile::class, ['id' => 'profile_id']);
    }


    public function getPortfolio()
    {
        return $this->hasMany(Portfolio::class, ['user_id' => 'id']);
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
