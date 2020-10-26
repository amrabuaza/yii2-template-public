<?php

namespace backend\modules\privateApi\controllers;

class CustomerController extends Controller
{

    protected function authOptional()
    {
        return ['test'];
    }

    public function actionTest()
    {
        return $this->sendSuccessResponse("test");
    }

}