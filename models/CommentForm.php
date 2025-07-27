<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CommentForm extends Model
{
    public $comment;
    public $user_id;
    public $video_id;

    /**
     * Rules for validation of the model
     * 
     * @return array
     */
    public function rules()
    {
        return [
            [['comment'], 'trim'],
            [['comment'], 'required']
        ];
    }

    /**
     * Add comment
     * 
     * @param boolean comment added or not 
     */
    public function add($videoId) {
        $comment = new Comment();
        $comment->user_id = User::getUserId();
        $comment->comment = $this->comment;
        $comment->video_id = $videoId;
        $comment->date_sent = time();
        return $comment->save();
    }

}
