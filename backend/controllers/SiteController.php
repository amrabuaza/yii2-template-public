<?php

namespace backend\controllers;

use common\controllers\Controller;
use common\models\user\User;
use Yii;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{

    protected function userActions()
    {
        return ['logout', 'index'];
    }

    protected function guestActions()
    {
        return ['login'];
    }

    protected function verbs()
    {
        return [
            'logout' => ['post'],
        ];
    }

    public function actionError()
    {
        return $this->render('error');
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //Yii::$app->notification->sendNotification("test","test",2);
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $model->type = [User::TYPE_ADMIN, User::TYPE_ROOT];
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
