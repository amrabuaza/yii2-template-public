<?php

namespace common\helper;

use common\models\user\User;
use Yii;

abstract class ApiHelper
{
    public static function getLanguageFromHeaders($request)
    {
        if (isset($request->headers['Accept-Language'])) {
            return $request->headers['Accept-Language'];
        }
        return Yii::$app->language;
    }

    public static function getAccessTokenFromHeaders($request)
    {
        $authorization = $request->headers['authorization'];
        $authorization = explode(" ", $authorization);
        return $authorization[1];
    }

    public static function getUserFromRequest($request)
    {
        return User::findIdentityByAccessToken(self::getAccessTokenFromHeaders($request));
    }
}