<?php

namespace app\controllers;

use app\models\AddVideoToModuleForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\App;
use app\models\Video;
use app\models\Comment;
use app\models\CommentForm;
use app\models\AddVideoForm;
use app\models\EditVideoForm;
use app\models\Module;

class VideoController extends Controller
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
                        'actions' => ['add', 'module', 'edit', 'delete', 'like', 'dislike'],
                        'allow' => false,
                        'roles' => ['?'],
                    ],

                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [],
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
     * Editing action: to edit the video
     * 
     * @return string
     */
    public function actionEdit() {
        $videoId = App::get('id');

        if( !$videoId || !Video::exists($videoId) || (!User::isAdmin() && !Video::isMy($videoId)) ) {
            return $this->redirect(['/']);
        }

        $model = new EditVideoForm();


        if( $model->load(Yii::$app->request->post()) && $model->validate() ) {
            if( $model->update($videoId) ) {
                App::alert('success', 'Your video was successfully updated.');
                return $this->redirect(['video/view', 'id' => $videoId]);
            } else {
                App::alert('danger', 'There was an error while updating a video. Try again later.');
                return $this->refresh();
            }
        }

        $video = Video::findOne($videoId);

        return $this->render('edit', [
            'model' => $model,
            'video' => $video
        ]);
    }

    /**
     * Adding action: to add a new video
     * 
     * @return string
     */
    public function actionAdd() { // video/add
        $model = new AddVideoForm();


        if( $model->load(Yii::$app->request->post()) && $model->validate() ) {
            if( $model->add() ) {
                App::alert('success', 'Your video was successfully added.');
                return $this->redirect(['site/index']);
            } else {
                App::alert('danger', 'There was an error while adding a video. Try again later.');
                return $this->refresh();
            }
        }

        return $this->render('add', ['model' => $model]);
    }

    /**
     * View action: to view the video 
     * 
     * @return string
     */
    public function actionView() { // video/view
        $id = App::get('id');

        if( !$id || !Video::exists($id) ) {
            return $this->redirect(['/']);
        }

        Video::updateViewNumber($id);

        $model = new CommentForm();

        if( !User::isGuest() ) {
            if( $model->load(Yii::$app->request->post()) && $model->validate()&& !User::isGuest() ) {

                if( User::isGuest())
                   return $this->redirect(['site/login']);

                if( $model->add($id) ) {
                    App::alert('success', 'Comment was added.');
                } else {
                    App::alert('danger', 'There was an error while adding a comment. Try again later.');
                }
                return $this->refresh();
            }
        }

        $query = Comment::find()->where(['video_id' => $id]);

        $commentPagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);

        $comments = $query->orderBy('id DESC')
            ->offset($commentPagination->offset)
            ->limit($commentPagination->limit)
            ->all();

        $video = Video::findOne($id);

        return $this->render('view', [
            'video' => $video,
            'model' => $model,
            'comments' => $comments,
            'commentsPagination' => $commentPagination
        ]);
    }

    /**
     * Module action: to view videos by specific module
     * 
     * @return string
     */
    public function actionModule() {
        $moduleId = App::get('id');


        if( !$moduleId || !Module::exists($moduleId) ) {
            return $this->redirect(['/']);
        }

        $module = Module::findOne($moduleId);

        $query = Video::find()->where(['module_id' => $moduleId]);

        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);

        $videos = $query->orderBy('id DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('module', [
            'module' => $module,
            'videos' => $videos,
            'pagination' => $pagination
        ]);
    }

    /**
     * Delete action: to delete specific video according to the ID
     * 
     * @return string
     */
    public function actionDelete() {

        $videoId = App::get('id');

        if( !$videoId || !Video::exists($videoId) || (!User::isAdmin() && !Video::isMy($videoId))) {
            return $this->redirect(['/']);
        }

        if( Video::deleteVideo($videoId) ) {
            App::alert('success', 'This video was successfully deleted.');
        } else {
            App::alert('danger', 'Error while deleting a video. Try again later.');
        }
        return $this->redirect(['/']);
    }

    /**
     * Like action: to like specific video
     * 
     * @return string
     */
    public function actionLike() {
        $videoId = App::get('id');

        if( !$videoId || !Video::exists($videoId)  ) {
            return $this->redirect(['/']);
        }

        Video::likeVideo($videoId);
        return $this->redirect(['video/view', 'id' => $videoId]);

    }

    /**
     * Dislike action: to dislike specific video
     * 
     * @return string
     */
    public function actionDislike() {
        $videoId = App::get('id');

        if( !$videoId || !Video::exists($videoId) ) {
            return $this->redirect(['/']);
        }

        Video::dislikeVideo($videoId);

        return $this->redirect(['video/view', 'id' => $videoId]);
    }
}
