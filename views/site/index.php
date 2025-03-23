<?php

/** @var yii\web\View $this */
/** @var app\models\ChatbotForm $model */

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
$(function() {
    $('#chatbot-form').on('beforeSubmit', function(e) {
        e.preventDefault(); // Prevent default form submission
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(), // CORRECT: Use form.serialize()
            dataType: 'json', // Expect a JSON response
            success: function(response) {
                if (response && response.answer) {
                    $('#answer').html('<b>Answer:</b> ' + response.answer);
                } else {
                    $('#answer').html('<b>Error:</b> No answer received or invalid response.');
                }
            },
            error: function(xhr, status, error) {
                $('#answer').html('<b>Error:</b> An error occurred: ' + error); // Display error
            }
        });
    });
});
JS
);
?>