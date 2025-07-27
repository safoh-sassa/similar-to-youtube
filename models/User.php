<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

        
    /**
     * Finds if user exists by email
     *
     * @param string $email
     * @return static|null
     */
    public static function isEmailExist($email)
    {
        return static::find()->where(['email' => $email])->count() == 1;
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    public static function getUser($user_id = null, $params = null) {

        if( $user_id == null && $params == null )
            return self::findOne(self::getUserId());
        else {

            if( !self::isUserExists($user_id) )
                throw new Exception("ID of this user does not exist.");


            return self::find()->select($params)->where(['id' => $user_id])->one();
        }
    }

    public static function getUserById($userId) {
        if( !self::isUserExists($userId) )
            throw new \Exception('User does not exist');

        return User::findOne($userId);
    }

    /**
     * This function gets user ip
     *
     * @return string (user ip)
     */
    public function getUserIp() {
        return Yii::$app->getRequest()->getUserIP();
    }

    public static function isAdmin($userId = null)
    {

        if (!$userId) {
            return self::find()->where([
                'id' => static::getUserId(),
                'group_id' => 1
            ])->count() == 1;
        } else  {
            return self::find()->where([
                    'id' => $userId,
                    'group_id' => 1
                ])->count() == 1;
        }
    }

    /**
     * @return string (authorized user's name)
     */
    public static function getUserName() {
        return Yii::$app->user->identity->username;
    }

    /**
     * @return string (authorized email)
     */
    public static function getUserEmail($user_id = null) {

        if( $user_id == null)
            return Yii::$app->user->identity->email;
        else {
            if( !self::isUserExists($user_id) )
                throw new \Exception('This email does not exist.');

            return self::findOne($user_id)->email;
        }
    }



    /**
     * This function checks whether person is in group of "user"
     *
     * @param  @id - user id
     * @return boolean
     */
    public static function isUser($id) {
        return self::getUserGroupKey($id) == 'user';
    }

    /**
     * This function retrieves authorized user id
     *
     * @return boolean
     */
    public static function getUserId() {
        return Yii::$app->user->identity->id;
    }

    /**
     * This function defines whether user is guest or not
     *
     * @return boolean
     */
    public static function isGuest() {
        return Yii::$app->user->isGuest;
    }
}
