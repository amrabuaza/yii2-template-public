<?php

namespace frontend\models;

use borales\extensions\phoneInput\PhoneInputValidator;
use codeonyii\yii2validators\AtLeastValidator;
use common\helper\Constants;
use common\models\user\User;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $email;
    public $phone_number;
    public $password;
    public $username;
    public $rememberMe = true;
    public $loginType;
    private $_user;

    public $type = false;
    const TYPE_PHONE_NUMBER = "phone";
    const TYPE_EMAIL = "email";

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            [['loginType', 'phone_number', 'email'], 'string'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            [['phone_number'], PhoneInputValidator::className()],
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
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if ($user && !$user->is_verified) {
                $this->addError("password", Yii::t(Constants::APP, 'site.email_not_verified'));
            }
            if (!$user) {
                if ($this->loginType == "email") {
                    $this->addError($attribute, Yii::t(Constants::APP, 'site.view.login_form_email_error'));

                } else {
                    $this->addError($attribute, Yii::t(Constants::APP, 'site.view.login_form_phone_error'));
                }
            }
        }
    }


    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = $this->findAndValidateByEmail($this->email, $this->password, $this->type);

        }
        if ($this->_user === null) {
            $this->_user = $this->findAndValidateByPhoneNumber($this->phone_number, $this->password, $this->type);
        }
        return $this->_user;
    }

    private function findAndValidateByEmail($email, $password, $user_type = null)
    {
        $user = User::findByEmail($email, $user_type);

        if (empty($user)) {
            return null;
        }
        $validatePassword = $user->validatePassword($password);
        if (!$validatePassword) {
            return null;
        }
        return $user;
    }

    private function findAndValidateByPhoneNumber($phone_number, $password, $user_type = null)
    {
        $user = User::findByPhoneNumber($phone_number, $user_type);
        if (empty($user)) {
            return null;
        }
        $validatePassword = $user->validatePassword($password);
        if (!$validatePassword) {
            return null;
        }
        return $user;
    }


    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $isLogin = Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
            if ($isLogin) {
                $this->getUser()->generateAccessToken();
            }
            return $isLogin;
        }
        return false;
    }

}