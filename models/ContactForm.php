<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $message;

    /**
     * Rules for validation of the model
     * 
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'message'], 'trim'],
            [['name', 'email', 'subject', 'message'], 'required'],
            ['email', 'email']
        ];
    }

    /**
     * Add comment
     * 
     * @param boolean comment added or not 
     */
    public function sendEmail() {

        $subject = 'New message from contact form';

        $body = null; 
        $body = 'Sender details:<br/>';
        $body .= '<strong>Name</strong>: ' . $this->name;  
        $body .= '<br><strong>Email</strong>: ' . $this->email;
        $body .= '<br><strong>Subject</strong>: ' . $this->subject;
        $body .= '<br><strong>Message</strong>:<br/>' . $this->message;


        $mailed = Mail::send([
                'from' => 'videovideo1993@gmail.com',
                'to' => 'ms79ms@gmail.com',
                'subject' => $subject, 
                'body' => $body
            ]);

        return $mailed;
    }

}
