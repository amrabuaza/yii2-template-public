<?php

namespace common\controllers;

use Yii;
use yii\helpers\StringHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ImageResizeController extends Controller
{

    public function actionIndex($size,$path){


        if(YII_ENV_DEV){
            if(!StringHelper::endsWith($path,'.jpg')){
                $path = $path.'.jpg';
            }
        }

        $result = Yii::$app->imageCache->resizeImage($path,$size);
        if(!$result){
            throw new NotFoundHttpException('invalid service configuration');
        }

        header('Content-type: image/png');
        echo $result;
        exit;
    }
}