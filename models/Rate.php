<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;


class Rate extends ActiveRecord {

    /**
     * Table name of the class
     * 
     * @return string
     */
    public static function tableName() {
        return 'rate';
    }

    /**
     * Checks if video has like
     *
     * 
     * @param  $videoId integer Video ID
     * @return boolean
     */
    public static function hasLike($videoId) {
        $userId = User::getUserId();
        return self::find()
            ->where([
                'video_id' => $videoId,
                'user_id' => $userId,
                'like_bool' => 1
            ])
            ->count() == 1;
    }

    /**
     * Checks if video has dislike
     *
     * 
     * @param  $videoId integer Video ID
     * @return boolean
     */
    public static function  hasDislike($videoId) {
        $userId = User::getUserId();
        return self::find()
            ->where([
                'video_id' => $videoId,
                'user_id' => $userId,
                'dislike_bool' => 1
            ])
            ->count() == 1;
    }

    /**
     * Finds specific row in this model table 
     * 
     * @param  $videoId integer Video ID
     * @return object
     */
    public static function findRate($videoId) {
        return self::find()
            ->where([
                'video_id' => $videoId,
                'user_id' => User::getUserId()
            ])->one();
    }

    /**
     * Delete dislike on video
     * 
     * @param  $videoId integer Video ID
     * @return boolean
     */
    public static function removeDislike($videoId) {
        $rate = self::findRate($videoId);
        $rate->dislike_bool = 0;
        return $rate->update();
    }

     /**
     * Delete like on video
     * 
     * @param  $videoId integer Video ID
     * @return boolean
     */
    public static function removeLike($videoId) {
        $rate = self::findRate($videoId);
        $rate->like_bool = 0;
        return $rate->update();
    }

    /**
     * Checks of rating row exists 
     * 
     * @param  $videoId integer Video ID
     * @return boolean
     */
    public static function exists($videoId) {
        return self::find()
            ->where([
                'video_id' => $videoId,
                'user_id' => User::getUserId()
            ])
            ->count() == 1;
    }

    /**
     * Generate new dislike or like row in the database
     * 
     * @param  $videoId integer Video ID
     * @return boolean
     */
    public static function createLikeDislikeRow($videoId) {
        $rate = new self();
        $rate->video_id = $videoId;
        $rate->user_id = User::getUserId();
        $rate->like_bool = 0;
        $rate->dislike_bool = 0;
        return $rate->save();
    }

    /**
     * Put rating of video up 
     * 
     * @param  $videoId integer Video ID
     * @return boolean
     */
    public static function rateUp($videoId) {
        if( !self::exists($videoId) ) {
            self::createLikeDislikeRow($videoId);
        }

        if( self::hasDislike($videoId) )
            self::removeDislike($videoId);

        $rate = self::findRate($videoId);
        $rate->like_bool = 1;
        return $rate->update();
    }

    /**
     * Put rating of video down 
     * 
     * @param  $videoId integer Video ID
     * @return boolean
     */
    public static function rateDown($videoId) {
        if( !self::exists($videoId) ) {
            self::createLikeDislikeRow($videoId);
        }

        if( self::hasLike($videoId) )
            self::removeLike($videoId);

        $rate = self::findRate($videoId);
        $rate->dislike_bool = 1;
        return $rate->update();
    }

    /**
     * Get number of video likes 
     * 
     * @param  $videoId integer Video ID
     * @return integer
     */
    public static function likesCount($videoId) {
        return self::find()->where([
            'video_id' => $videoId,
            'like_bool' => 1
        ])->count();
    }

    /**
     * Get number of video dislikes 
     * 
     * @param  $videoId integer Video ID
     * @return integer
     */
    public static function dislikesCount($videoId) {
        return self::find()->where([
            'video_id' => $videoId,
            'dislike_bool' => 1
        ])->count();
    }


}
