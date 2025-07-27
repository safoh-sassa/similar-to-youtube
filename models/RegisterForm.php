<?php

namespace app\models;

use Yii;
use yii\base\Model;


class RegisterForm extends Model
{
    public $student_id;
    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $password;

    /**
     * Rules for validation of the model
     * 
     * @return array
     */
    public function rules()
    {
        return [
            [['student_id', 'first_name', 'last_name', 'username', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['student_id', 'unique', 'targetClass' => 'app\models\User'],
            ['email', 'unique', 'targetClass' => 'app\models\User']
        ];
    }

    /**
     * Add user 
     *
     * @return  boolean
     */
    public function add() {
        $user = new User();
        $user->student_id = $this->student_id;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->generateAuthKey();
        $user->password = $user->setPassword( $this->password );
        return $user->save();
    }

}
