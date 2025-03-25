<?php

/** @var yii\web\View $this */
/** @var app\models\QaLog $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'AI Chatbot Layanan Informasi Dana BOS';
?>
<div class="site-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Berdasarkan <b>Permendikbudristek No. 63 Tahun 2023</b>.
    </p>

    <?php $form = ActiveForm::begin([
        'id' => 'chatbot-form',
        'action' => Url::to(['site/index']),
        'options' => ['class' => 'form-horizontal'],
        'enableAjaxValidation' => false, // AJAX ditangani secara manual
    ]); ?>

    <!-- ✅ DITAMBAHKAN: Input untuk pencarian dengan fitur autocomplete -->
    <div style="position: relative;">
        <?= $form->field($model, 'question')->textInput([
            'id' => 'question-input',
            'autofocus' => true,
            'placeholder' => 'Ketik pertanyaan...',
            'autocomplete' => 'off'
        ]) ?>
        <div id="suggestions"></div>
    </div>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div id="answer" style="margin-top: 20px;"></div>

    <input type="hidden" id="answer-id">

    <!-- Tombol Upvote & Downvote (Disembunyikan awalnya) -->
    <div id="vote-buttons" style="display: none; margin-top: 10px;">
        <button id="upvote-btn" class="btn btn-success">👍 Upvote</button>
        <button id="downvote-btn" class="btn btn-danger">👎 Downvote</button>
    </div>

    <hr>

    <p>
        <b>Informasi Tambahan:</b>
    </p>
    <ul>
        <li><b>Jawaban :</b> Ada tiga jawaban yang ditampilkan berdasarkan <i>similarities</i> antara pertanyaan dengan dokumen.</li>
        <li><b>About:</b> Penjelasan mengenai chatbot ini dapat ditemukan di menu <?= Html::a('About', ['site/about']) ?>.</li>
        <li><b>Log:</b> Riwayat pertanyaan dan jawaban dapat dilihat di menu <?= Html::a('Log', ['site/log']) ?>.</li>
    </ul>

</div>

<?php
$this->registerJs(<<<JS
$(document).ready(function() {

    // ✅ DITAMBAHKAN: Fitur Autocomplete untuk pertanyaan
    $("#question-input").on("keyup", function() {
        let query = $(this).val();
        
        if (query.length < 3) {
            $("#suggestions").html("").hide();
            return;
        }

        $.get("site/suggestion", { query: query }, function(data) {
            let suggestionBox = $("#suggestions");
            suggestionBox.html("").show();

            data.forEach(function(item) {
                let div = $("<div>").text(item.question).addClass("suggestion-item");
                div.on("click", function() {
                    $("#question-input").val(item.question);
                    suggestionBox.hide();
                });
                suggestionBox.append(div);
            });
        }, "json");
    });

    // ✅ DITAMBAHKAN: Menutup rekomendasi saat klik di luar
    $(document).on("click", function(event) {
        if (!$(event.target).closest("#question-input, #suggestions").length) {
            $("#suggestions").hide();
        }
    });

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

    // ✅ DITAMBAHKAN: Handle Upvote
    var csrfToken = $('meta[name="csrf-token"]').attr("content");

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

    // ✅ DITAMBAHKAN: Handle Downvote
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

<style>
    /* ✅ DITAMBAHKAN: Styling untuk kotak saran */
    #suggestions {
        border: 1px solid #ddd;
        max-width: 400px;
        background: #fff;
        position: absolute;
        z-index: 1000;
        display: none;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }
    .suggestion-item {
        padding: 8px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
    }
    .suggestion-item:hover {
        background: #f2f2f2;
    }
</style>
