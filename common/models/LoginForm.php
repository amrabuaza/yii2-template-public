<?php

namespace common\models;

use Baha2Odeh\RecaptchaV3\RecaptchaV3Validator;
use common\helper\Constants;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $phoneNumber;
    public $password;
    public $username;
    public $rememberMe = true;
    public $loginType;
    private $_user;
    public $type = false;
    public $code;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t(Constants::APP, 'Username'),
            'password' => Yii::t(Constants::APP, 'Password'),
            'email' => Yii::t(Constants::APP, 'Email'),
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
            if (!$user || !$user->validatePassword($this->password)) {
                if (isset($this->loginType) && $this->loginType == "email") {
                    $this->addError("password", Yii::t(Constants::APP, 'site.view.login_form_email_error'));
                } else {
                    $this->addError("password", Yii::t(Constants::APP, 'site.view.login_form_phone_error'));
                }
            }
        }
    }

    private function validateType()
    {
        $user = $this->getUser();
        if ($this->type) {
            $isValid = false;
            if (is_array($this->type)) {
                foreach ($this->type as $tempType) {
                    if ($tempType == $user->user_type) {
                        $isValid = true;
                        break;
                    }
                }
            } else if ($this->type == $user->user_type) {
                $isValid = true;
            }

            if (!$isValid) {
                if (isset($this->loginType) && $this->loginType == "email") {
                    $this->addError("password", Yii::t(Constants::APP, 'site.view.login_form_email_error'));
                } else {
                    $this->addError("password", Yii::t(Constants::APP, 'site.view.login_form_phone_error'));
                }
                return false;
            }

        }
        return true;
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate() && $this->validateType()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return \common\models\user\User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = \common\models\user\User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
