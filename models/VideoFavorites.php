<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;


class VideoFavorites extends ActiveRecord {


    /**
     * Table name
     * @return string 
     */
    public static function tableName() {
        return 'video_favorites';
    }


    /** 
     * Relation between User and itself 
     * @return string 
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Add new video to the favorite list 
     * 
     * @param $videoId integer Video ID
     * @return boolean 
     */
    public static function addOne($videoId) {
        $favorite = new self();

        $favorite->user_id = User::getUserId();
        $favorite->video_id = $videoId;

        return $favorite->save();
    }

    /**
     * Delete the video from favorites 
     * 
     * @param  $videoId integer Video ID
     * @return boolean
     */
    public static function deleteOne($videoId) {
        $favorite = self::find()->where([
            'user_id' => User::getUserId(),
            'video_id' => $videoId
        ])->one();

        return $favorite->delete();
    }

    /**
     * If video exists in the favorite by specific user 
     * @param  $videoId integer Video ID
     * @return boolean
     */
    public static function exists($videoId) {
        return self::find()->where([
            'user_id' => User::getUserId(),
            'video_id' => $videoId
        ])->count() == 1;
    }

}
