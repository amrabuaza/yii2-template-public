<?php

namespace backend\modules\privateApi\controllers;

class MeController extends Controller
{

    public function actionInfo()
    {
        return $this->getUser();
    }

}