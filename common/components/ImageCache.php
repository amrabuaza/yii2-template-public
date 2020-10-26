<?php

namespace common\components;

use Yii;
use yii\helpers\BaseFileHelper;
use yii\imagine\Image;

class ImageCache extends \yii\base\Component
{

    public static function generateUrl($path, $size = null)
    {
        if ($size) {
            return rtrim(Yii::$app->params['cdn_url'], "/") . '/cache/' . $size . '/' . $path;
        } else {
            return rtrim(Yii::$app->params['cdn_url'], "/") . '/' . $path;
        }
    }

    public function url($image, $size = null)
    {
        if (is_object($image)) {
            $image = $image->path;
        }
        if ($size) {
            return rtrim(Yii::$app->params['cdn_url'], "/") . '/cache/' . $size . '/' . ltrim($image, "/");
        } else {
            return rtrim(Yii::$app->params['cdn_url'], "/") . '/' . ltrim($image, "/");
        }
    }


    /**
     * @param $original_image
     * @param $size
     * @throws \yii\base\Exception
     */
    public function resizeImage($original_image, $size)
    {

        $srcImagePath = Yii::getAlias("@cdn/" . $original_image);
        $cachePath = Yii::getAlias("@cdn/cache/" . $size . '/' . $original_image);

        // image already created
        if (is_file($cachePath)) {
            return file_get_contents($cachePath);
        }
        // Check whether there is a source file
        if (!is_file($srcImagePath))
            return false;

        return $this->createCachedFile($srcImagePath, $cachePath, $size);
    }


    /**
     * @param $srcImagePath
     * @param $pathToSave
     * @param $size
     */
    private function createCachedFile($srcImagePath, $pathToSave, $size)
    {

        if (!file_exists($srcImagePath) || !is_file($srcImagePath)) {
            return false;
        }

        BaseFileHelper::createDirectory(dirname($pathToSave), 0777, true);
        $size = $this->parseSize($size);

        $result = Image::resize($srcImagePath, $size['width'], $size['height'])
            ->save($pathToSave);
        return $result->get('png');
    }

    /**
     * Parses size string
     * For instance: 400x400, 400x, x400
     * @param $sizeString
     * @return array|null
     */
    private function parseSize($sizeString)
    {
        $sizeArray = explode('x', $sizeString);
        $part1 = (isset($sizeArray[0]) and $sizeArray[0] != '');
        $part2 = (isset($sizeArray[1]) and $sizeArray[1] != '');
        if ($part1 && $part2) {
            if (intval($sizeArray[0]) > 0
                &&
                intval($sizeArray[1]) > 0
            ) {
                $size = [
                    'width' => intval($sizeArray[0]),
                    'height' => intval($sizeArray[1])
                ];
            } else {
                $size = null;
            }
        } elseif ($part1 && !$part2) {
            $size = [
                'width' => intval($sizeArray[0]),
                'height' => null
            ];
        } elseif (!$part1 && $part2) {
            $size = [
                'width' => null,
                'height' => intval($sizeArray[1])
            ];
        } else {
            throw new \Exception('Error parsing size.');
        }
        return $size;
    }


}