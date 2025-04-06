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

    const CATEGORY_DEFINITION       = 1;
    const CATEGORY_ADVISABILITY     = 2;
    const CATEGORY_UTILIZATION      = 3;
    const CATEGORY_REPORTING        = 4;
    const CATEGORY_PROGRAM          = 5;


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


    public static function getArrayCategory(): array
    {
        return [
            //MASTER
            self::CATEGORY_DEFINITION => Yii::t('app', 'Definisi'),
            self::CATEGORY_ADVISABILITY  => Yii::t('app', 'Kelayakan'),
            self::CATEGORY_UTILIZATION  => Yii::t('app', 'Penggunaan'),
            self::CATEGORY_REPORTING  => Yii::t('app', 'Pelaporan & Administrasi'),
            self::CATEGORY_PROGRAM  => Yii::t('app', 'Program Sekolah Penggerak'),
        ];
    }

    public static function getOneIsVisible($_module = null): string
    {
        if($_module)
        {
            $arrayModule = self::getArrayCategory();

            switch ($_module) {
                case ($_module == self::CATEGORY_DEFINITION):
                    $returnValue = ($arrayModule[$_module];
                    break;
                case ($_module == self::CATEGORY_ADVISABILITY):
                    $returnValue = ($arrayModule[$_module];
                    break;
                case ($_module == self::CATEGORY_UTILIZATION):
                    $returnValue = ($arrayModule[$_module];
                    break;
                case ($_module == self::CATEGORY_REPORTING):
                    $returnValue = ($arrayModule[$_module];
                    break;
                case ($_module == self::CATEGORY_PROGRAM):
                    $returnValue = ($arrayModule[$_module];
                    break;
                default:
                    $returnValue = ($arrayModule[$_module];
            }

            return $returnValue;

        }
        else
            return '-';
    }
}
