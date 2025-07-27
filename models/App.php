<?php
namespace app\models;

use Yii;

class App {

    /**
     * Alert function
     * 
     * @param  string type of the alert
     * @param  string text of the alert
     */
    public static function alert($type, $message) {
        Yii::$app->getSession()->setFlash($type, $message);
    }

    /**
     * Get the name of the $_GET according to $get = $_GET[$get]
     *
     * Usage: App::get('id'), which will return the id value from the URL 
     * 
     * @param  string name of the $_GET
     * 
     * @return string value of $_GET
     */
    public static function get($get) {
        return Yii::$app->request->get($get);
    }

    /**
     * Get the name of the $_POST according to $name = $_GET[$post]
     *
     * Usage: App::post('id'), which will return the post value from the form
     * 
     * @param  string name of the $_POST
     * 
     * @return string value of $_POST
     */
    public static function post($post = null) {
        if($post !== null )
            return Yii::$app->request->post($post);
        else
            return Yii::$app->request->post();
    }
}