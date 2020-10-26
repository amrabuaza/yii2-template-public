<?php

namespace common\helper;

use common\components\GeoHelper;
use kartik\ipinfo\IpInfo;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use Yii;
use yii\httpclient\Exception;
use yii\web\NotFoundHttpException;

abstract class HelperMethods
{

    public static function convertStringToUrlString($string)
    {
        return urlencode(strtolower($string));
    }

    public static function getLanguageFromSessionOrSetIfNotExists()
    {
        $session = Yii::$app->session;

        if ($session->get(Constants::USER_LANGUAGE_KEY) == null) {
            try {
//                if (!YII_ENV_DEV) {
//                    $ip = new IpInfo();
//                    $ip->ip = Yii::$app->request->getUserIP();
//                    $fields = $ip->fetchIPDetails();
//                    $lang = self::getLanguageFormCountryCode($fields['countryCode']);
//                    $session->set(Constants::USER_LANGUAGE_KEY, $lang);
//                    return $lang;
//                }
                $session->set(Constants::USER_LANGUAGE_KEY, Constants::DEFAULT_LANGUAGE);
                return Constants::DEFAULT_LANGUAGE;
            } catch (Exception $e) {
                $session->set(
                    Constants::USER_LANGUAGE_KEY,
                    Constants::DEFAULT_LANGUAGE
                );
                return Constants::DEFAULT_LANGUAGE;
            }
        } else {
            return $session->get(Constants::USER_LANGUAGE_KEY);
        }
    }

    public static function setLanguageIntoSession($language)
    {
        $session = Yii::$app->session;
        if ($session->get(Constants::USER_LANGUAGE_KEY) != null) {
            $session->remove(Constants::USER_LANGUAGE_KEY);
        }
        $session->set(Constants::USER_LANGUAGE_KEY, $language);
    }

    public static function checkIsValidLanguage($language)
    {
        $languages = Yii::$app->params[Constants::LANGUAGES];
        foreach ($languages as $key => $value) {
            if ($key == $language) {
                return;
            }
        }
        throw new NotFoundHttpException(
            'We Are Not Supportive This Language !!'
        );
    }

    public static function formatMobileNumber($phone, $country_code = null)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $mobileNumber = preg_replace(array('/[^0-9]/', '/^0*/'), '', $phone);
            if (!empty($country_code)) {
                $cleanCountryCode = preg_replace(array('/[^0-9]/', '/^0*/'), '', $country_code);
                $mobileNumber = $cleanCountryCode . $mobileNumber;
            }
            $parsedPhone = $phoneUtil->parse('+' . $mobileNumber);
            $isValid = $phoneUtil->isValidNumber($parsedPhone);
            if ($isValid) {
                return  $parsedPhone->getCountryCode() . $parsedPhone->getNationalNumber();
            }

        } catch (NumberParseException $e) {

        }

        return false;
    }
}