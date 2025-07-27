<?php

namespace app\models;

use Yii;
use yii\base\Model;


class AddModuleForm extends Model
{
    public $module_name;

    /**
     * Rules for validation of the model
     * 
     * @return array
     */
    public function rules()
    {
        return [

            [['module_name'], 'trim'],
            [['module_name'], 'required']

        ];
    }


    /**
     * Add new module 
     *
     * @return boolean Whether module was added or not 
     */
    public function add() {
        $module = new Module();
        $module->module_name = $this->module_name;

        return $module->save();
    }

}
