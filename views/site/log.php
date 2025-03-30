<?php

use app\models\QaLog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\QaLogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qa-log-index">
    <div class="row">
        <div class="col-md-10">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-md-2">
            <?= Html::a(Yii::t('app', 'Ask Chatbot'), ['/site/index'], ['class' => 'btn btn-success pull-right']) ?>
        </div>
    </div>


    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'question',
                'format' => 'ntext',
                'contentOptions' => ['style' => 'width: 30%; word-wrap: break-word;'],
                'headerOptions' => ['style' => 'width: 30%;'],
            ],
            [
                'attribute' => 'answer',
                'format' => 'html',
                'contentOptions' => ['style' => 'width: 50%; word-wrap: break-word;'],
                'headerOptions' => ['style' => 'width: 50%;'],
            ],
            'upvote',
            'downvote',
            [
                'class' => ActionColumn::class,
                'template' => '{view}',
                'urlCreator' => function ($action, QaLog $model, $key, $index, $column) {
                    if ($action === 'view') {
                        return Url::to(['/qa-log/view', 'id' => $model->id]);
                    }
                    return '#';
                },
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
