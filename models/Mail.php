<?php

namespace app\models;

use Yii;

class Mail {
	
	public static function send(array $array) {

		if( !is_array($array) )
			throw new \Exception('Parameter must be an array');

		$send = Yii::$app->mail->compose()
			->setFrom($array['from'])
            ->setTo($array['to'])
            ->setSubject($array['subject'])
            ->setHtmlBody($array['body'])
            ->send();

        return $send;
	}
}


?>