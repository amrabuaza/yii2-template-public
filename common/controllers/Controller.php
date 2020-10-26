<?php

namespace common\controllers;

use common\helper\Constants;
use common\helper\HelperMethods;
use Yii;
use yii\filters\AccessControl;
use yii\filters\Cors;
use yii\filters\VerbFilter;

class Controller extends \yii\web\Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => $this->getRules(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => $this->verbs()
            ],
            'corsFilter' => [
                'class' => Cors::className(),
                'cors' => $this->cors(),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action))
            return false;

        if (Yii::$app->id == 'app-frontend') {
            $language = HelperMethods::getLanguageFromSessionOrSetIfNotExists();
            Yii::$app->language = $language;
            Yii::$app->sourceLanguage = $language;

            if ($this->enableMobileLayout() && Yii::$app->mobileDetect->isMobile) {
                if ($language == Constants::ARABIC_LANGUAGE) {
                    $this->layout = $this->mobileArLayout();
                } else {
                    $this->layout = $this->mobileDefaultLayout();
                }
            } else {
                if ($language == Constants::ARABIC_LANGUAGE) {
                    $this->layout = $this->arLayout();
                } else {
                    $this->layout = $this->defaultLayout();
                }
            }
        }


        return true;
    }

    protected function rules()
    {
        return [];
    }

    protected function commonActions()
    {
        return [];
    }

    protected function userActions()
    {
        return [];
    }

    protected function guestActions()
    {
        return [];
    }

    protected function defaultLayout()
    {
        return "main";
    }

    protected function arLayout()
    {
        return "main-ar";
    }

    protected function enableMobileLayout()
    {
        return false;
    }

    protected function mobileDefaultLayout()
    {
        return "appMobileLayout";
    }

    protected function mobileArLayout()
    {
        return "appMobileArLayout";
    }

    protected function verbs()
    {
        return [
            'delete' => ['post']
        ];
    }

    protected function cors()
    {
        return [
            'Origin' => ['*'],
            'Access-Control-Request-Headers' => ['*'],
        ];
    }

    private function getRules()
    {
        if (count($this->rules())) {
            return $this->rules();
        }

        if (count(($this->commonActions())) || count($this->guestActions())) {
            return [
                [
                    'actions' => array_merge($this->commonActions(), $this->guestActions()),
                    'allow' => true,
                ],
                [
                    'actions' => array_merge($this->commonActions(), $this->userActions()),
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ];
        }
        return [
            [
                'actions' => array_merge($this->commonActions(), $this->userActions()),
                'allow' => true,
                'roles' => ['@'],
            ],
        ];
    }

}