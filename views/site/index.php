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
        'enableAjaxValidation' => false, // AJAX ditangani secara manual
    ]); ?>

    <?= $form->field($model, 'question')->textInput(['autofocus' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Ask', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <!-- Tempat menampilkan jawaban -->
    <div id="answer" style="margin-top: 20px;"></div>

    <!-- Input hidden untuk menyimpan ID jawaban -->
    <input type="hidden" id="answer-id">

    <!-- Tombol Upvote & Downvote (Disembunyikan awalnya) -->
    <div id="vote-buttons" style="display: none; margin-top: 10px;">
        <button id="upvote-btn" class="btn btn-success">👍 Upvote</button>
        <button id="downvote-btn" class="btn btn-danger">👎 Downvote</button>
    </div>
</div>

<?php
$this->registerJs(<<<JS
$(document).ready(function() {
    // Handle Form Submit
    $('#chatbot-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = form.serialize();

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response && response.answer) {
                    // Tampilkan jawaban
                    $('#answer').html('<b>Answer:</b> ' + response.answer);

                    // Simpan ID jawaban untuk upvote/downvote
                    $('#answer-id').val(response.id);

                    // Tampilkan tombol upvote/downvote
                    $('#vote-buttons').show();
                } else {
                    $('#answer').html('<b>Error:</b> No answer received or invalid response.');
                }
            },
            error: function(xhr, status, error) {
                $('#answer').html('<b>Error:</b> ' + error);
            }
        });
    });

    // Handle Upvote
    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    // Handle Upvote
    $('#upvote-btn').on('click', function() {
        var id = $('#answer-id').val();
        $.post({
            url: 'site/upvote',
            data: {id: id, _csrf: csrfToken},
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Upvote berhasil! Total Upvotes: ' + response.upvote);
                } else {
                    alert('Upvote gagal!');
                }
            }
        });
    });

    // Handle Downvote
    $('#downvote-btn').on('click', function() {
        var id = $('#answer-id').val();
        $.post({
            url: 'site/downvote',
            data: {id: id, _csrf: csrfToken},
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Downvote berhasil! Total Downvotes: ' + response.downvote);
                } else {
                    alert('Downvote gagal!');
                }
            }
        });
    });
});
JS
);
?>
