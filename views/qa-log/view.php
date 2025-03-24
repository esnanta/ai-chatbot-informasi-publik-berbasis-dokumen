<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\QaLog $model */

$this->title = $model->question;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Qa Logs'), 'url' => ['/site/log']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="qa-log-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'answer',
                'format' => 'raw', // Agar bisa menampilkan HTML
                'value' => function ($model) {
                    $text = Html::encode($model->answer); // Escape HTML untuk keamanan

                    // Hilangkan karakter "(" dan ")" yang tidak diperlukan
                    $text = preg_replace('/[\(\)]/', '', $text);

                    // Pisahkan paragraf dengan <br><br>
                    $text = preg_replace('/-\d+-/', '<br><br>', $text); // Ganti "-8-" dengan pemisah yang lebih baik
                    $text = preg_replace('/\n/', '<br>', $text); // Ubah newline menjadi <br>

                    // Ubah daftar menjadi <ul> <li>
                    $text = preg_replace('/(\d+)\)\s/', '<li>', $text); // Ganti "1)" menjadi "<li>"
                    $text = preg_replace('/(<li>.*?)(?=<li>|$)/s', '<ul>$1</ul>', $text); // Bungkus dalam <ul>

                    return $text;
                },
            ],
            'upvote',
            'downvote',
            'created_at',
        ],
    ]) ?>

</div>
