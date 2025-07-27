<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Comment extends ActiveRecord {

	/**
	 * Table name of the class
	 * 
	 * @return string
	 */
    public static function tableName() {
        return 'comments';
    }

    /**
     * @param  $commentId string integer 
     * @return string first and last name of the commentor
     */
    public static function getUserFullName($commentId) {
        $comment = self::findOne($commentId);
        $userId = $comment->user_id;
        $user = User::findOne($userId);
        return $user->first_name . ' ' . $user->last_name;
    }


}
