<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AdminLogInForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * Rules for validation of the model
     * 
     * @return array
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            ['email', 'email'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],

            ['email', 'isUserAdminByEmail']
        ];
    }

    /**
     * Validates the user or incorrect email or password
     * 
     * @param  $attribute attribute name from the rules  
     * @param  $params parameters of the attribute 
     * @return string 
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
        }
    }

    /**
     * Checks if user is admin
     * 
     * @param  $attribute attribute name from the rules  
     * @param  $params parameters of the attribute 
     * @return string 
     */
    public function isUserAdminByEmail($attribute, $params) {
        $user = User::findByEmail($this->email);

        if( !User::isAdmin($user->id) ) {
            $this->addError($attribute, 'Sorry, but you are not an admin to authorize here.');
        }
    }

    /**
     * Creates $_SESSION for user to log in 
     * 
     * @return boolean 
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Get user by email address
     * 
     * @return object
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
