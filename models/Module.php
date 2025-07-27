<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Video;


class Module extends ActiveRecord {

    /**
     * Table name of the class
     * 
     * @return string
     */
    public static function tableName() {
        return 'modules';
    }

    /**
     * Checks if module exists
     * @param  $moduleId integer ID of the module 
     * @return boolean
     */
    public static function exists($moduleId) {
        return self::find()->where(['id' => $moduleId])->count() == 1;
    }

    /**
     * Get all modules
     * 
     * @return array
     */
    public static function getCategories() {
        $_categories = self::find()->all();

        $categories = [];

        $categories[0] = '';

        foreach ($_categories as $key => $category)
            $categories[$category->id] = $category->module_name;

        return $categories;
    }

    /**
     * Update all videos that are related to $moduleId ID
     * 
     * @param  $moduleId integer ID of the module 
     * @return boolean
     */
    public static function updateAllRelatedVideos($moduleId) {
        $affectedRows = Video::updateAll(['module_id' => 0], ['module_id' => $moduleId]);

        if($affectedRows >= 1)
            return true;
        else
            return false;
    }

    /**
     * Add new module 
     *
     * @return boolean (module added or not)
     */
    public function add() {
        $module = new Video();
        $module->user_id = User::getUserId();
        $module->title = $this->title;
        $module->url = $this->url;
        $module->module_id = $this->url;
        $module->description = $this->description;
        return $module->save();
    }


}
