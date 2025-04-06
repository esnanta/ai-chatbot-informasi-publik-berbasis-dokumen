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
    </div>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'question',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::encode($model->question) . ' ' .
                        Html::a(
                            'Ask',
                            ['site/index', 'q' => $model->question],
                            ['title' => 'Lihat detail', 'style' => 'margin-left: 5px;']
                        );
                },
            ],
            [
                'attribute' => 'category',
                'value' => function ($model, $key, $index, $widget) {
                    return ($model->category !== null && method_exists($model, 'getOneCategory'))
                        ? $model->getOneCategory($model->category)
                        : '';
                },
                'filter' => $categoryList,
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'id' => null
                ],
                'format' => 'raw',
            ],
            // --- AKHIR KOLOM CATEGORY ---
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
