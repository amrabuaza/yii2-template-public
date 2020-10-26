<?php

namespace common\components;

use common\models\user\Auth;
use common\models\user\User;
use Yii;
use yii\authclient\clients\Facebook;
use yii\helpers\ArrayHelper;

class AuthHandler
{
    /**
     * @var Facebook
     */
    private $client;

    public function __construct(Facebook $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $attributes = array_merge($this->client->getUserAttributes(), $this->client->api("me?fields=first_name,last_name"));
        $email = ArrayHelper::getValue($attributes, 'email');
        $id = ArrayHelper::getValue($attributes, 'id');
        $first_name = ArrayHelper::getValue($attributes, 'first_name');
        $last_name = ArrayHelper::getValue($attributes, 'last_name');
        $username = $first_name . "-" . $last_name;


        if (empty($email)) {
            Yii::$app->getSession()->setFlash('error', [
                Yii::t('app', "your {client} account does not have email address please try login with other account.", ['client' => $this->client->getTitle()]),
            ]);
            return false;
        }

        /* @var Auth $auth */
        $auth = Auth::find()->where([
            'source' => $this->client->getId(),
            'source_id' => $id,
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                $user = $auth->user;
                Yii::$app->user->login($user, 3600);
            } else { // signup
                if (User::find()->where(['email' => $email])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $this->client->getTitle()]),
                    ]);
                    return false;
                }
                $password = Yii::$app->security->generateRandomString(8);

                $user = new User([
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'verified' => 1,
                    'user_type' => User::TYPE_CUSTOMER
                ]);
                $user->generateAuthKey();
                $user->generateAccessToken();

                $transaction = User::getDb()->beginTransaction();

                if ($user->isNewRecord ? $user->save() : true) {
                    $auth = new Auth([
                        'user_id' => $user->id,
                        'source' => $this->client->getId(),
                        'source_id' => (string)$id,
                    ]);


                    if ($auth->save()) {
                        $transaction->commit();
                        Yii::$app->user->login($user, 3600);
                    } else {
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', 'Unable to save {client} account: {errors}', [
                                'client' => $this->client->getTitle(),
                                'errors' => json_encode($auth->getErrors()),
                            ]),
                        ]);
                    }
                } else {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', 'Unable to save user: {errors}', [
                            'client' => $this->client->getTitle(),
                            'errors' => json_encode($user->getErrors()),
                        ]),
                    ]);
                }
            }
        }
    }
}