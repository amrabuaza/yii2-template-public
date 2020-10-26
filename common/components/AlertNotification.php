<?php

namespace common\components;

use kartik\growl\Growl;
use Yii;
use yii\base\Component;

class AlertNotification extends Component
{

    public static function sendNotification($title, $message, $type = null, $delay = 500)
    {
        $align = Yii::$app->language == "ar" ? "left" : "right";
        echo Growl::widget([
            'type' => self::getType($type),
            'icon' => self::getIcon($type),
            'title' => $title,
            'showSeparator' => true,
            'body' => $message,
            'pluginOptions' => [
                'showProgressbar' => true,
                'placement' => [
                    'from' => 'top',
                    'align' => $align,
                ]
            ],
            'delay' => $delay,
        ]);
    }

    private static function getType($type)
    {
        if (!isset($type)) {
            return Growl::TYPE_SUCCESS;
        }
        switch ($type) {
            case 1:
                return Growl::TYPE_DANGER;
            case 2:
                return Growl::TYPE_INFO;
            case 3:
                return Growl::TYPE_MINIMALIST;
            case 4:
                return Growl::TYPE_WARNING;
            case 5:
                return Growl::TYPE_GROWL;
            default :
                return Growl::TYPE_SUCCESS;
        }
    }

    private static function getIcon($type)
    {
        if (!isset($type)) {
            return "glyphicon glyphicon-info-sign";
        }
        switch ($type) {
            case 1:
                return 'glyphicon glyphicon-remove-sign';
            case 4:
                return 'glyphicon glyphicon-exclamation-sign';
            default :
                return "glyphicon glyphicon-info-sign";
        }
    }

}