<?php

use app\models\Suggestion;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\SuggestionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Suggestions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suggestion-index">

    <div class="row">
        <div class="col-md-10">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-md-2">
            <?= Html::a(Yii::t('app', 'Ask Chatbot'), ['/site/index'], ['class' => 'btn btn-success pull-right']) ?>
        </div>
    </div>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'question:ntext',
            'category:ntext',
            'description:ntext',
            'created_at',
            [
                'class' => ActionColumn::class,
                'template' => '{view}',
                'urlCreator' => function ($action, Suggestion $model, $key, $index, $column) {
                    if ($action === 'view') {
                        return Url::to(['view', 'id' => $model->id]);
                    }
                    return '#';
                },
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
