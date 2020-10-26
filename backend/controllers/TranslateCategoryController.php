<?php

namespace backend\controllers;

use common\controllers\Controller;
use common\lib\i18nModule\models\TranslateCategory;
use common\lib\i18nModule\models\TranslateCategorySearch;
use common\models\user\UserRoles;
use Yii;

/**
 * TranslateCategoryController implements the CRUD actions for TranslateCategory model.
 */
class TranslateCategoryController extends Controller
{
    protected function rules()
    {
        return UserRoles::ADMIN_ROLES;
    }

    /**
     * Lists all SourceMessage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TranslateCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all SourceMessage models.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TranslateCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

}