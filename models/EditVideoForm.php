<?php

namespace app\models;

use Yii;
use yii\base\Model;

class EditVideoForm extends Model
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
     * @param  $videoId integer ID of the video
     * @return boolean video was updated or not 
     */
    public function update($videoId) {
        $video = Video::findOne($videoId);
        $video->title = $this->title;
        $video->url = $this->url;
        $video->description = $this->description;
        $video->module_id = $this->module_id;
        return $video->update();
    }

}
