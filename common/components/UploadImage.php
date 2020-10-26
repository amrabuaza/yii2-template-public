<?php

namespace common\helper;

use Yii;
use yii\helpers\FileHelper;
use yii\imagine\Image;

abstract class UploadImage
{
    const CDN_PATH = '@cdn/';

    public static function createUploadPath($extension, $basePath = "")
    {
        $currentDate = date('Y-m');
        if (isset($basePath) && $basePath != "") {
            self::createDirectoryIfNotExists($basePath);
            self::createDirectoryIfNotExists($basePath . "/" . $currentDate);
            return $basePath . "/" . $currentDate . "/" . self::guid() . '.' . $extension;
        } else {
            self::createDirectoryIfNotExists($currentDate);
            return $currentDate . "/" . self::guid() . '.' . $extension;
        }
    }

    public static function saveAndResize($image, $name, $width, $height)
    {

        $path = self::CDN_PATH . $name;

        $savePath = Yii::getAlias($path);
        if (!$image->saveAs($savePath)) {
            return false;
        }
        Image::resize($savePath, $width, $height)->save($savePath);

        return true;
    }

    public static function save($image, $name)
    {
        $path = self::CDN_PATH . $name;
        $savePath = Yii::getAlias($path);
        if (!$image->saveAs($savePath)) {
            return false;
        }
        return true;
    }

    private static function guid()
    {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    private static function createDirectoryIfNotExists($path)
    {
        $saveDirectory = Yii::getAlias(self::CDN_PATH . $path);
        if (!file_exists($saveDirectory)) {
            FileHelper::createDirectory($saveDirectory);
        }
    }
}