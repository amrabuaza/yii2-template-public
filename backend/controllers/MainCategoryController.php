<?php

namespace backend\controllers;

use common\controllers\Controller;
use common\helper\Constants;
use common\models\translation\MainCategoryLanguage;
use common\models\user\UserRoles;
use Yii;
use common\models\categories\MainCategory;
use common\models\search\MainCategorySearch;
use yii\web\NotFoundHttpException;

/**
 * MainCategoryController implements the CRUD actions for MainCategory model.
 */
class MainCategoryController extends Controller
{

    protected function rules()
    {
        return UserRoles::ADMIN_ROLES;
    }


    /**
     * Lists all MainCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MainCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MainCategory model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MainCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MainCategory();
        $model->status = Constants::ACTIVE;
        $modelAr = new MainCategoryLanguage();
        if ($model->load(Yii::$app->request->post(), 'MainCategory')
            && $model->save()
            && $modelAr->load(Yii::$app->request->post(), 'MainCategoryLanguage')) {
            $modelAr->main_category_id = $model->id;
            $modelAr->language = "ar";
            $modelAr->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'modelAr' => $modelAr
        ]);
    }

    /**
     * Updates an existing MainCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdateTranslations($id, $language)
    {
        $model = MainCategoryLanguage::findOne(["main_category_id" => $id, Constants::LANGUAGE => $language]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('translations', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MainCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MainCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MainCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MainCategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
