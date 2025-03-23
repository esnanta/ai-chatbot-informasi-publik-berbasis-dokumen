<?php
namespace app\models;

use yii\base\Model;

class ChatbotForm extends Model
{
    public $question;

    public function rules()
    {
        return [
            [['question'], 'required'],
            [['question'], 'string', 'min' => 2], // Add a minimum length validation
        ];
    }
}