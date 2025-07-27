<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Comment;
use app\models\Rate;
use app\models\User;
use app\models\VideoFavorites;


class Video extends ActiveRecord {


    /**
     * Table name of the class
     * 
     * @return string
     */
    public static function tableName() {
        return 'videos';
    }

    /**
     * Relation between Module class and itself
     * 
     * @return string
     */
    public function getModule() {
        return $this->hasOne(Module::className(), ['id' => 'module_id']);
    }
    
    /**
     * Relation between User class and itself
     * 
     * @return string
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Relation between VideoFavorites and itself
     * @return [type]
     */
    public function getFavorites() {
        return $this->hasMany(VideoFavorites::className(), ['video_id' => 'id']);
    }

    /**
     * Checks if video is personal 
     * 
     * @param  $videoId integer Video ID
     * @return boolean
     */
    public static function isMy($videoId) {
        if( User::isGuest() )
            return false; 

        return self::find()->where([
            'user_id' => User::getUserId(),
            'id' => $videoId])->count() == 1;
    }

    /**
     * Checks if video is favorited 
     * 
     * @param  $videoId integer Video ID
     * @return boolean
     */
    public static function isFavorited($videoId) {
        return VideoFavorites::exists($videoId);
    }


    /**
     * Update view count on the video
     * @param  $videoId integer Video ID
     */
    public static function updateViewNumber($videoId) {
        $video = self::findOne($videoId);

        $video->updateCounters(['views_count' => 1]);
    }

    /**
     * Return first and last name of the video author 
     * 
     * @param  $videoId integer Video ID
     * @return string (first and last name)
     */
    public static function getAuthor($videoId) {
        $video = self::findOne($videoId);

        $userId = $video->user_id;

        $user = User::findOne($userId);

        return $user->first_name . ' ' . $user->last_name;
    }

    /**
     * Get video view count
     * 
     * @param  $videoId integer Video ID
     * @return integer
     */
    public static function getViewsCount($videoId) {
        $video = self::findOne($videoId);

        return $video->views_count;
    }

    /**
     * Deletes the video and comments if it has 
     * 
     * @param  $videoId integer Video ID
     * @return boolean
     */
    public static function deleteVideo($videoId) {

        $video = self::findOne($videoId);

        $wasDeleted = $video->delete();


        if( self::hasComments($videoId) ) {
            $commentsDeleted = Comment::deleteAll(['video_id' => $videoId]);

            return $wasDeleted && $commentsDeleted;
        } else {
            return $wasDeleted;
        }
    }

    /**
     * Like the video 
     * 
     * @param  $videoId integer Video ID
     * @return boolean
     */
    public static function likeVideo($videoId) {
        return Rate::rateUp($videoId);
    }

    /**
     * Dislike the video 
     * 
     * @param  $videoId integer Video ID
     * @return boolean
     */
    public static function dislikeVideo($videoId) {
        return Rate::rateDown($videoId);
    }

    /**
     * Checks if video has comments
     * @param  $videoId integer Video ID
     * @return boolean
     */
    public static function hasComments($videoId) {
       return Comment::find()->where(['video_id' => $videoId])->count() >= 1;
    }

    /**
     * Check if video exists
     *  
     * @param  $videoId integer Video ID
     * @return boolean
     */
    public static function exists($videoId) {
        return self::find()->where(['id' => $videoId])->count() == 1;
    }

    /**
     * Get video likes number
     * @param  $videoId integer Video ID
     * @return integer
     */
    public static function getLikesNumber($videoId) {
        return Rate::likesCount($videoId);
    }

    /**
     * Get video dislikes number
     * @param  $videoId integer Video ID
     * @return integer
     */
    public static function getDislikesNumber($videoId) {
        return Rate::dislikesCount($videoId);
    }

    /**
     * @param  $url string (url of the video source)
     * @return string (html)
     */
    public static function embedVideo($url) {
        //Regex for matching YouTube URLs
        $youTubeWatchMatch = '/https:\/\/www\.youtube\.com\/watch\?v=([a-z0-9-_]{1,})/i';
        $youTubeShortUrlMatch = '/https:\/\/youtu\.be\/([a-z0-9-_]{1,})/i';

        // Regex for mathing Vimeo URLs
        $vimeoWatchMatch = '/https:\/\/vimeo.com\/([0-9]{1,})/i';

        // Boolean values to check if video is youtube or vimeo 
        // Using previously declared regexes
        $isYouTube = preg_match($youTubeWatchMatch, $url) || preg_match($youTubeShortUrlMatch, $url);
        $isVimeo = preg_match($vimeoWatchMatch, $url);

        //Check if url is youtube or video and add specific URL starting to the iframe tag
        if( $isYouTube )
            $html = '<iframe width="280" height="157" src="https://www.youtube.com/embed/';
        else if( $isVimeo ) { // Check url is vimeo type
            $html = '<iframe width="280" height="157" src="https://player.vimeo.com/video/';
        }

        /**
         * Get the unique ID from the URL of the vide and prepend to the HTML 
         */
        if( preg_match($youTubeWatchMatch, $url, $matches) ) {
            $html .= $matches[1];
        } else if( preg_match($youTubeShortUrlMatch, $url, $matches) ) {
            $html .= $matches[1];
        } else if(  preg_match($vimeoWatchMatch, $url, $matches) ) {
            $html .= $matches[1];
        } else {
            $html = '<iframe width="280" height="157" src="'. $url .'" border="0"></iframe>';
        }

        /**
         * Check if video is YouTube or Vimeo and add last part of iframe to add 
         * the video
         */
        if( $isYouTube )
            $html .= '" frameborder="0" allowfullscreen></iframe>';
        else if( $isVimeo )
            $html .= '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

        return $html;
    }

}
