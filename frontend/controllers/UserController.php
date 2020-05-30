<?php


namespace frontend\controllers;


use TaskForce\constants\TaskStatuses;
use TaskForce\constants\UserRoles;
use frontend\models\AccountForm;
use frontend\models\Category;
use frontend\models\Feedback;
use frontend\models\Portfolio;
use frontend\models\Profile;
use frontend\models\ProfileView;
use frontend\models\Setting;
use frontend\models\SignupForm;
use frontend\models\UploadFiles;
use frontend\models\User;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

class UserController extends SecureController
{

    public function actionSignup()
    {
        $model = new SignupForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $user = new User();
            $profile = new Profile();
            $settings = new Setting();

            $user->email = $model->email;
            $user->name = $model->name;
            $user->town = $model->town[0];
            $user->setPassword($model->password);
            $user->save();
            $user->link('profile', $profile);
            $user->link('settings', $settings);


            Yii::$app->session->setFlash('success', 'Регистрация успешна!');
            return $this->goHome();
        }

        return $this->render('signup', ['model' => $model,]);

    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionAccount()
    {
        $user = Yii::$app->user->identity;
        $allCategories = Category::find()->all();

        $model = new AccountForm();

        if ($model->validate() && $model->load(Yii::$app->request->post()))
        {
            $model->avatar = UploadedFile::getInstanceByName('avatar');

            if ($model->avatar) {
                UploadFiles::upload($model->avatar);
                $avatar_filename = "{$model->avatar->baseName}_" . date('Y-m-d') . ".{$model->avatar->extension}";
                $user->profile->avatar_file = $avatar_filename;
            }
            $user->name = $model->name;
            $user->email = $model->email;
            $user->town = $model->town[0];

            if ($model->birthday) {
                $user->profile->birthday = $model->birthday;
            }

            $user->profile->about = strip_tags($model->about);

            if ($model->password && $model->password_repeat) {
                $user->password = Yii::$app->security->generatePasswordHash($model->password);
            }

            $model->imageFiles = UploadedFile::getInstancesByName('imageFiles');

            if ($model->imageFiles) {
                UploadFiles::upload($model->imageFiles);
                $user->unlinkAll('portfolio', true);
                foreach ($model->imageFiles as $file) {
                    $portfolio = new Portfolio();
                    $portfolio->user_id = $user->id;
                    $portfolio->filename = "{$file->baseName}_" . date('Y-m-d') . '.' . $file->extension;
                    $user->link('portfolio', $portfolio);
                }
            }


            $user->profile->phone = preg_replace('/\D/', '', $model->phone);
            $user->profile->skype = $model->skype;
            $user->profile->messenger = htmlspecialchars($model->telegram);
            $user->profile->save();

            $user->settings->new_message = $model->new_message;
            $user->settings->actions_on_task = $model->actions_on_task;
            $user->settings->new_feedback = $model->new_feedback;
            $user->settings->show_to_customer = $model->show_to_customer;
            $user->settings->hide_user_profile = $model->hide_user_profile;

            $user->settings->save();

            if ($user->categories) {
                (new Query())
                    ->createCommand()
                    ->delete(
                        'users_categories',
                        ['and', ['user_id' => $user->id], ['not in', 'category_id', $model->categories]]
                    )
                    ->execute();
            }

            /*if ($user->categories) {
                foreach ($user->categories as $category) {
                    $user->unlink('categories', $category, $delete = true);
                }
            }*/

            $selectedCategories = Category::find()->where(['in', 'id',  $model->categories])->all();
            if ($selectedCategories) {
                foreach ($selectedCategories as $category) {
                    $user->link('categories', $category);
                }
            }
            $user->role = $selectedCategories ? UserRoles::WORKER : UserRoles::CUSTOMER;

            $user->settings->new_message = $model->new_message;
            $user->settings->actions_on_task = $model->actions_on_task;
            $user->settings->new_feedback = $model->new_feedback;
            $user->settings->show_to_customer = $model->show_to_customer;
            $user->settings->hide_user_profile = $model->hide_user_profile;

            $user->save();
            $this->refresh();
        }

        return $this->render('account', compact('user', 'allCategories', 'model'));
    }

    public function actionProfile()
    {
        $user = User::find()
            ->where(['users.id' => Yii::$app->request->get('user_id')])
            ->orWhere(['users.id' => Yii::$app->user->id])
            ->one();

        if (!$user->role) {
            throw new NotFoundHttpException('Такая страница не существует');
        }

        if (Yii::$app->user->id !== $user->id) {
            $recentViews = ProfileView::find()
                ->where(['current_user_id' => Yii::$app->user->id])
                ->andWhere(['viewed_user_id' => $user->id])
                ->andWhere(['>', 'viewing_time', date('Y-m-d H:i:s', strtotime('-1 hour'))])
                ->all();

            if (count($recentViews) === 0) {
                $newView = new ProfileView();
                $newView->current_user_id = Yii::$app->user->id;
                $newView->viewed_user_id = $user->id;
                $newView->save();
            }
        }

        $tasksCount = count($user->tasks);

        $feedbacks = Feedback::find()
            ->where(['worker_id' => Yii::$app->request->get('user_id')])
            ->with(['customer', 'avatar', 'task']);

        $feedbacksCount = count($user->feedbacks);
        $feedbacksCountPerPage = 3;
        $pages = new Pagination([
            'totalCount' => $feedbacksCount,
            'pageSize' => $feedbacksCountPerPage,
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);
        $feedbacks = $feedbacks->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        if (Yii::$app->request->get('is_favorite') !== null) {
            $user->is_favorite = Yii::$app->request->get('is_favorite');
            $user->save();
        }

        return $this->render('profile', compact('user', 'feedbacks', 'pages', 'tasksCount', 'feedbacksCount'));
    }

    public function actionUsers()
    {
        $users = User::find()
            ->where(['role' => UserRoles::WORKER])
            ->orderBy(['registration_date' => SORT_DESC])
            ->with(['profile', 'categories', 'tasks', 'feedbacks'])
            ->joinWith('settings')
            ->andWhere(['users_settings.hide_user_profile' => 0])
            ->groupBy(['id']);


        if (Yii::$app->request->get('rating')) {
            $users->orderBy(['rating' => SORT_DESC]);
        }

        if (Yii::$app->request->get('tasks')) {
            $users->joinWith('tasks')->
            orderBy(['count(tasks.id)' => SORT_DESC]);
        }

        if (Yii::$app->request->get('views')) {
            $users->joinWith('views')->
            orderBy(['count(profile_views.id)' => SORT_DESC]);
        }

        if (Yii::$app->request->get('category')) {
            $users->joinWith('categories')
                ->andWhere(['users_categories.category_id' => Yii::$app->request->get('category')]);
        }

        if (Yii::$app->request->get('free')) {
            $users->joinWith('tasks')
                ->andWhere(['not in', 'status', TaskStatuses::ACTIVE]);
        }

        if (Yii::$app->request->get('online')) {
            $users->andWhere(['>=', 'latest_activity_time', date('Y-m-d H:i:s', strtotime('-30 minutes'))]);
        }

        if (Yii::$app->request->get('feedbacks')) {
            $users->andWhere(['>', 'feedbacks_count', 0]);
        }

        if (Yii::$app->request->get('favorite')) {
            $users->andWhere(['is_favorite' => 1]);
        }

        $searchByName = Yii::$app->request->get('name');
        if (!empty($searchByName)) {
            $users->where(['like', 'name', $searchByName]);
        }

        $usersCountPerPage = 5;
        $pages = new Pagination([
            'totalCount' => $users->count(),
            'pageSize' => $usersCountPerPage,
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);
        $users = $users->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $categories = Category::find()->all();

        return $this->render('users', compact('users', 'pages', 'categories'));
    }


}
