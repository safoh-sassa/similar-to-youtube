<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\App;
use app\models\Video;
use app\models\VideoFavorites;

class FavoriteController extends Controller
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
                        'actions' => ['my', 'add', 'delete'],
                        'allow' => false,
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
     * My action: to view user's personal videos saved as favorite
     * 
     * @return string
     */
    public function actionMy()
    {
        $query = Video::find()
            ->joinWith('favorites')
            ->where(['video_favorites.user_id' => User::getUserId()]);


        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);

        $videos = $query->orderBy('id DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('my', [
            'videos' => $videos,
            'pagination' => $pagination
        ]);
    }

    /**
     * Add action: to add video to the favorite
     * 
     * @return string
     */
    public function actionAdd() {
        $videoId = App::get('id');
        $backUrl = App::get('back_url');

        if( !$videoId || !Video::exists($videoId) || VideoFavorites::exists($videoId) ) {
            return $backUrl ? $this->redirect($backUrl) : $this->redirect(['favorite/my']);
        }

        if( VideoFavorites::addOne($videoId) ) {
            App::alert('success', 'This video was added to the favorites.');
        } else {
            App::alert('danger', 'Error while adding video to favorites. Try again later.');
        }

        return $backUrl ? $this->redirect($backUrl) : $this->redirect(['favorite/my']);
    }

    /**
     * Delete action: to delete video from favorites
     * 
     * @return string
     */
    public function actionDelete() {
        $videoId = App::get('id');
        $backUrl = App::get('back_url');

        if( !$videoId || !VideoFavorites::exists($videoId) ) {
            return $backUrl ? $this->redirect($backUrl) : $this->redirect(['favorite/my']);
        }

        if( VideoFavorites::deleteOne($videoId) ) {

            App::alert('success', 'Video was removed from favorites.');
        } else {
            App::alert('danger', 'Error while removing a video from favorites. Try again later.');
        }

        return $backUrl ? $this->redirect($backUrl) : $this->redirect(['favorite/my']);
    }

}
