<?php

namespace frontend\helper;

use common\models\user\User;
use Yii;
use yii\httpclient\Client;

class OAuthClient
{
    private $baseUrl = "";

    public function sendRequest($subUrl, $method, $headers = null, $data = null)
    {
        $client = new Client();
        $headers = $this->setAccessTokenAndAcceptLanguage($headers);
        $url = $this->baseUrl . $subUrl;

        return $client->createRequest()
            ->setMethod($method)
            ->setUrl($url)
            ->setData($data)
            ->setHeaders($headers)
            ->send();
    }

    private function setAccessTokenAndAcceptLanguage($headers)
    {
        $accessToken = User::findOne(Yii::$app->user->id)->access_token;
        $headers["Authorization"] = "Bearer $accessToken";
        $headers["Accept-Language"] = Yii::$app->language;
        return $headers;
    }

    public function getContent($response)
    {
        return json_decode($response->content, true);
    }


}