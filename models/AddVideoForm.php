<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AddVideoForm extends Model
{
    public $title;
    public $url;
    public $module_id;
    public $description;

    /**
     * Rules for validation of the model
     * 
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'url', 'description'], 'trim'],
            [['title', 'url'], 'required'],
            ['module_id', 'integer']
        ];
    }

    /**
     * To add the video
     * 
     * @return boolean Video was added or not 
     */
    public function add() {
        $video = new Video();
        $video->user_id = User::getUserId();
        $video->title = $this->title;
        $video->url = $this->url;
        $video->description = $this->description;
        $video->module_id = $this->module_id;

        return $video->save();
    }

}
