<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tx_suggestion".
 *
 * @property int $id
 * @property string|null $question
 * @property string|null $category
 * @property string|null $description
 * @property string|null $created_at
 */
class Suggestion extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tx_suggestion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question', 'category', 'description', 'created_at'], 'default', 'value' => null],
            [['question', 'category', 'description'], 'string'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'question' => Yii::t('app', 'Question'),
            'category' => Yii::t('app', 'Category'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

}
