<?php

namespace frontend\models;

use borales\extensions\phoneInput\PhoneInputValidator;
use codeonyii\yii2validators\AtLeastValidator;
use common\helper\Constants;
use common\models\user\Customer;
use common\models\user\User;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $phone_number;
    public $type;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\user\User', 'message' => Yii::t(Constants::APP, 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\user\User', 'message' => Yii::t(Constants::APP, 'This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 8],

            ['phone_number', 'number'],
            ['phone_number', 'unique', 'targetClass' => '\common\models\user\User', 'message' => Yii::t(Constants::APP, 'site.signup.phone_number_taken')],
            ['phone_number', 'required'],
            [['email', 'phone_number'], AtLeastValidator::className(), 'in' => ['email', 'phone_number']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t(Constants::APP, 'username'),
            'password' => Yii::t(Constants::APP, 'password'),
            'rememberMe' => Yii::t(Constants::APP, 'remember me'),
            'email' => Yii::t(Constants::APP, 'email'),
            'phone_number' => Yii::t("app", 'phone number'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->phone_number = $this->phone_number;
        $user->setPassword($this->password);
//        $user->generateAuthKey();
        $user->generateAccessToken();
        if ($user->save()) {
            $customer = new Customer();
            $customer->target_id = $user->id;
            $customer->target = Customer::TARGET_USER;
            return $customer->save();
        }
        return false;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
