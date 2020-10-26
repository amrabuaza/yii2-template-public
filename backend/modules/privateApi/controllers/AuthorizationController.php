<?php

namespace backend\modules\privateApi\controllers;

use backend\modules\privateApi\models\authorization\LoginForm;
use backend\modules\privateApi\models\authorization\SignupForm;
use common\models\user\User;
use Yii;

class AuthorizationController extends Controller
{
    protected function authOptional()
    {
        return ["login", "signup"];
    }

    protected function verbs()
    {
        return [
            'login' => ['POST'],
            'signup' => ['POST']
        ];
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        $model->type = User::TYPE_CUSTOMER;

        if ($model->load(Yii::$app->request->post(), '')) {
            if ($model->login()) {
                $res = ['access_token' => $model->accessToken];
                return $this->sendSuccessResponse($res);
            }
            return $this->sendFailedResponse($model->errors, null, "login", 400, 400);
        }
        $model->validate();
        return $this->sendFailedResponse($model->errors, null, "login", 422, 422);
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->signup()) {
            $user = User::findOne(["username" => $model->username]);
            $res = ['access_token' => $user->accessToken, 'username' => $user->username];
            return $this->sendSuccessResponse($res);
        } else {
            $model->validate();
            return $this->sendFailedResponse($model->errors, null, "Signup", 422, 422);
        }
    }

}