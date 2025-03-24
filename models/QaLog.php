<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tx_qa_logs".
 *
 * @property int $id
 * @property string|null $question
 * @property string|null $answer
 * @property int|null $upvote
 * @property int|null $downvote
 * @property string|null $created_at
 */
class QaLog extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tx_qa_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question', 'answer', 'upvote', 'downvote', 'created_at'], 'default', 'value' => null],
            [['question', 'answer'], 'string'],
            [['upvote', 'downvote'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = date('Y-m-d H:i:s');
            $this->upvote = 0;
            $this->downvote = 0;
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'question' => Yii::t('app', 'Question'),
            'answer' => Yii::t('app', 'Answer'),
            'upvote' => Yii::t('app', 'Upvote'),
            'downvote' => Yii::t('app', 'Downvote'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

}
