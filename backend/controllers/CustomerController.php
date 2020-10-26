<?php

namespace backend\controllers;

use common\controllers\Controller;
use common\models\search\CustomerSearch;
use common\models\user\Customer;
use common\models\user\UserRoles;
use Yii;

class CustomerController extends Controller
{
    protected function rules()
    {
        return UserRoles::ADMIN_ROLES;
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render("view", ["model" => Customer::findOne($id)]);
    }
}