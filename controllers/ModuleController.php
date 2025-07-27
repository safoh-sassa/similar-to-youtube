<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\App;
use app\models\Module;
use app\models\AddModuleForm;

class ModuleController extends Controller
{
    /**
     * Behaviour config of the controller
     * 
     * @return array
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [],
                'rules' => [
                    [
                        'actions' => ['all', 'add', 'delete'],
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['all', 'add', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['get'],
                ],
            ],
        ];
    }

    /**
     * All modules
     * 
     * @return string
     */
    public function actionAll()
    {
        $query = Module::find()->where(['!=', 'id', 0]);

        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);

        $modules = $query->orderBy('id DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('all', [
            'modules' => $modules,
            'pagination' => $pagination
        ]);
    }

    /**
     * Add module
     * 
     * @return string
     */
    public function actionAdd() {
        $model = new AddModuleForm();

        if( $model->load(App::post()) && $model->validate() ) {
            if( $model->add() ) {
                App::alert('success', 'Module was successfully added.');
            } else {
                App::alert('danger', 'Error while adding a module.');
            }

            return $this->redirect(['module/all']);
        }

        return $this->render('add', ['model' => $model]);
    }

    /**
     * Delete module
     * 
     * @return string
     */
    public function actionDelete() {
        $moduleId = App::get('id');

        if( !$moduleId || !Module::exists($moduleId) || !User::isAdmin() ) {
            return $this->redirect(['module/all']);
        }

        $module = Module::findOne($moduleId);

        if( $module->delete() ) {
            Module::updateAllRelatedVideos($moduleId);

            App::alert('success', 'Module was successfully deleted.');
        } else {
            App::alert('danger', 'Error while deleting a module. Try again later.');
        }

        return $this->redirect(['module/all']);
    }

}
