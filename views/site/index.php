<?php

/** @var yii\web\View $this */
/** @var app\models\QaLog $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'AI Chatbot';
?>
    <div class="site-index">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin([
            'id' => 'chatbot-form',
            'action' => Url::to(['site/index']),
            'options' => ['class' => 'form-horizontal'],
            'enableAjaxValidation' => false, // We handle the response, not full AJAX validation
        ]); ?>

        <?= $form->field($model, 'question')->textInput(['autofocus' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Ask', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <div id="answer" style="margin-top: 20px;">
            <!-- Answer will be displayed here -->
        </div>
    </div>

<?php
$this->registerJs(<<<JS
$(document).ready(function() {
    $('#chatbot-form').on('submit', function(e) {
        e.preventDefault(); // Mencegah form dikirim secara normal
        var form = $(this);
        var formData = form.serialize(); // Mengambil data form

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response && response.answer) {
                    $('#answer').html('<b>Answer:</b> ' + response.answer);
                    $('#chatbot-form')[0].reset(); // Mengosongkan input setelah sukses
                } else {
                    $('#answer').html('<b>Error:</b> No answer received or invalid response.');
                }
            },
            error: function(xhr, status, error) {
                $('#answer').html('<b>Error:</b> ' + error);
            }
        });
    });
});
JS
);
?>
