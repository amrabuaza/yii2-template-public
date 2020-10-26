<?php

namespace backend\modules\privateApi\controllers;

use common\behaviors\ApiResponseBehavior;
use common\helper\ApiHelper;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\RateLimiter;
use yii\rest\Controller as BaseController;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * Class SiteController
 * @method sendSuccessResponse($data = false, $additional_info = false, $code = 200, $header_status = 200)
 * @method sendFailedResponse($message, $errorMask = NULL, $name = '', $code = 400, $header_status = 200)
 */
class Controller extends BaseController
{

    public function behaviors()
    {

        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                ],
                'languages' => [
                    'en',
                    'ar',
                ],
            ],
            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => $this->verbs(),
            ],
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'authMethods' => [
                    HttpBasicAuth::className(),
                    HttpBearerAuth::className(),
                    QueryParamAuth::className(),
                ],
                'optional' => $this->authOptional(),
                'except' => $this->authExcept(),
            ],
            'rateLimiter' => [
                'class' => RateLimiter::className(),
            ],
            'apiResponse' => [
                'class' => ApiResponseBehavior::className(),
            ],
            'corsFilter' => [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                ],
            ]
        ];

    }

    protected function authOptional()
    {
        return [];
    }

    protected function authExcept()
    {
        return ['options'];
    }

    protected final function getUser()
    {
        return ApiHelper::getUserFromRequest(Yii::$app->request);
    }


}
