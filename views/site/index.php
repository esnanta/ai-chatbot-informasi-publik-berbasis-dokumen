<?php

/** @var yii\web\View $this */
/** @var app\models\QaLog $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'DocuQuery';
?>
<div class="site-index">
    <h1><?= Html::encode($this->title) ?> (Prototype)</h1>
    <p>AI Chatbot Layanan Informasi Berbasis Dokumen</p>

    <table class="table table-bordered">
        <tr>
            <td><b>Sumber</b></td>
            <td><?= Html::a('Permendikbudristek No. 63 Tahun 2023', 'https://github.com/esnanta/ai-chatbot-dana-bos-api/blob/main/knowledge_base/Permendikbudriset_No_63_Tahun_2023.pdf', ['target' => '_blank']) ?></td>
        </tr>
        <tr>
            <td><b>Informasi</b></td>
            <td>
                Contoh <?= Html::a('pertanyaan', ['suggestion/index']) ?> -
                <?= Html::a('Log', ['site/log']) ?> -
                <?= Html::a('About', ['site/about']) ?> </td>
        </tr>
        <tr>
            <td><b>Server API</b></td>
            <td>
                <!-- === ELEMEN STATUS SERVER === -->
                <div class="server-status-container mb-3">
                    <span id="server-status-indicator" class="badge bg-secondary">Mengecek...</span>
                    <span id="server-status-message" style="font-size: 0.9em; margin-left: 5px;"></span>
                </div>
                <!-- === AKHIR ELEMEN STATUS SERVER === -->
            </td>
        </tr>
    </table>


    <?php $form = ActiveForm::begin([
        'id' => 'chatbot-form',
        'action' => Url::to(['site/index']),
        'options' => ['class' => 'form-horizontal'],
        'enableAjaxValidation' => false,
    ]); ?>

    <!-- Input untuk pencarian dengan fitur autocomplete -->
    <div style="position: relative;">
        <?= $form->field($model, 'question', [
            'template' => "{input}\n{label}\n{error}",
            'options' => ['class' => 'form-floating mb-3']
        ])->textarea([
            'id' => 'question-input',
            'class' => 'form-control',
            'placeholder' => 'Ketik pertanyaan...',
            'autocomplete' => 'off',
            //'rows' => 6,
            'style' => 'height: 100px'
        ])->label('Pertanyaan') ?>
        <div id="suggestions" style="position: absolute; z-index: 1000; width: 100%;"></div>
    </div>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Ask', [
            'class' => 'btn btn-primary',
            'id' => 'submit-ask-btn', // Tambahkan ID
            'disabled' => true // Set disabled secara default
        ]) ?>
        <!-- Loading Indicator -->
        <div id="loading-indicator" style="display: none; margin-left: 10px;">
            <div class="spinner"></div> Loading...
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <div id="answer" style="margin-top: 20px;"></div>

    <input type="hidden" id="answer-id">

    <!-- Tombol Upvote & Downvote (Disembunyikan awalnya) -->
    <div id="vote-buttons" style="display: none; margin-top: 10px;">
        <button id="upvote-btn" class="btn btn-success">👍 Upvote</button>
        <button id="downvote-btn" class="btn btn-danger">👎 Downvote</button>
    </div>

</div>

<?php
$checkServerStatusUrl = Url::to(['site/check-server-status']);
$this->registerJs(<<<JS
$(document).ready(function() {

    // --- Fungsi untuk Cek Status Server ---
    function checkServerStatus() {
        var statusIndicator = $('#server-status-indicator');
        var statusMessage = $('#server-status-message');

        statusIndicator.text('Mengecek...').removeClass('bg-success bg-danger bg-warning').addClass('bg-secondary');
        statusMessage.text(''); // Kosongkan pesan sebelumnya

        $.ajax({
            url: '$checkServerStatusUrl', // Gunakan variabel PHP
            type: 'GET',
            dataType: 'json',
            timeout: 5000, // Tambahkan timeout untuk request AJAX itu sendiri (misal 5 detik)
            success: function(response) {
                if (response && response.status) {
                    if (response.status === 'online') {
                        statusIndicator.text('Online').removeClass('bg-secondary bg-danger').addClass('bg-success');
                        statusMessage.text(''); // Kosongkan pesan jika online
                        // Anda bisa mengaktifkan form di sini jika diperlukan
                        // $('#submit-ask-btn').prop('disabled', false);
                        // $('#question-input').prop('disabled', false);
                    } else if (response.status === 'offline') {
                        statusIndicator.text('Offline').removeClass('bg-secondary bg-success').addClass('bg-danger');
                        statusMessage.text('(' + (response.message || 'Tidak dapat terhubung') + ')');
                        // Anda bisa menonaktifkan form di sini jika server offline
                        // $('#submit-ask-btn').prop('disabled', true);
                        // $('#question-input').prop('disabled', true);
                    } else {
                        // Status tidak dikenal atau error dari backend
                        statusIndicator.text('Error').removeClass('bg-secondary bg-success').addClass('bg-warning');
                        statusMessage.text('(' + (response.message || 'Status tidak diketahui') + ')');
                    }
                } else {
                    // Respons tidak valid dari server
                    statusIndicator.text('Error').removeClass('bg-secondary bg-success').addClass('bg-warning');
                    statusMessage.text('(Respons tidak valid)');
                }
            },
            error: function(xhr, status, error) {
                // Error saat melakukan AJAX call ke Yii2 (bukan status server target)
                console.error("AJAX Error checking server status:", status, error);
                statusIndicator.text('Error Cek').removeClass('bg-secondary bg-success').addClass('bg-warning');
                statusMessage.text('(Gagal menghubungi pemeriksa status)');
                 // Pertimbangkan untuk menonaktifkan form jika status tidak bisa dicek
                 // $('#submit-ask-btn').prop('disabled', true);
                 // $('#question-input').prop('disabled', true);
            },
            complete: function() {
                 // Logika yang dijalankan setelah success atau error
                 // Misalnya, jika Anda ingin mencoba lagi setelah beberapa waktu
            }
        });
    }

    // --- Panggil fungsi cek status saat halaman siap ---
    checkServerStatus();
    
    
    
    
    // --- PERUBAHAN 1: Aktifkan tombol submit setelah dokumen siap ---
    $('#submit-ask-btn').prop('disabled', false);

    // Fitur Autocomplete untuk pertanyaan
    $("#question-input").on("keyup", function() {
        let query = $(this).val();

        if (query.length < 3) {
            $("#suggestions").html("").hide();
            return;
        }

        $.get("site/suggestion", { query: query }, function(data) {
            let suggestionBox = $("#suggestions");
            suggestionBox.html("").show(); // Pastikan tampil saat ada data

            if (data && data.length > 0) {
                data.forEach(function(item) {
                    let div = $("<div>").text(item.question).addClass("suggestion-item");
                    div.on("click", function() {
                        $("#question-input").val(item.question);
                        suggestionBox.hide();
                    });
                    suggestionBox.append(div);
                });
            } else {
                suggestionBox.hide(); // Sembunyikan jika tidak ada saran
            }
        }, "json").fail(function() {
             $("#suggestions").hide(); // Sembunyikan jika request gagal
        });;
    });

    // Menutup rekomendasi saat klik di luar
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

        // Tampilkan loading indicator & disable tombol submit
        $('#loading-indicator').show();
        $('#submit-ask-btn').prop('disabled', true); // Disable tombol saat proses
        $('#answer').html(''); // Kosongkan jawaban sebelumnya
        $('#vote-buttons').hide(); // Sembunyikan tombol vote lama
        $('#answer-id').val(''); // Kosongkan ID jawaban lama

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

                    // --- PERUBAHAN 2: Pastikan tombol vote enabled sebelum ditampilkan ---
                    $('#upvote-btn').prop('disabled', false);
                    $('#downvote-btn').prop('disabled', false);

                    // Tampilkan tombol upvote/downvote
                    $('#vote-buttons').show();
                } else {
                    $('#answer').html('<b>Error:</b> No answer received or invalid response.');
                }
            },
            error: function(xhr, status, error) {
                // Tampilkan detail error jika ada
                $('#answer').html('<b>Error:</b> ' + error + ' - ' + xhr.responseText);
            },
            complete: function() {
                 // Sembunyikan loading indicator & enable tombol submit lagi setelah selesai 
                 // (baik sukses maupun error)
                $('#loading-indicator').hide();
                $('#submit-ask-btn').prop('disabled', false);
            }
        });
    });

    // Handle Upvote
    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    $('#upvote-btn').on('click', function() {
        var id = $('#answer-id').val();
        if (!id) return; 

        // --- PERUBAHAN 2: Disable kedua tombol segera setelah diklik ---
        $('#upvote-btn').prop('disabled', true);
        $('#downvote-btn').prop('disabled', true);

        $.post({
            url: 'site/upvote', // Pastikan URL benar
            data: {id: id, _csrf: csrfToken},
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Tampilkan pesan atau update UI (opsional)
                    alert('Upvote berhasil!');
                    $('#upvote-btn').addClass('btn-outline-success').removeClass('btn-success'); // Contoh feedback visual
                } else {
                    alert('Upvote gagal! ' + (response.message || ''));
                    // Jika gagal, mungkin ingin mengaktifkan kembali tombol? Tergantung kebutuhan.
                    $('#upvote-btn').prop('disabled', false);
                    $('#downvote-btn').prop('disabled', false);
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat mengirim upvote.');
                 // Jika gagal, mungkin ingin mengaktifkan kembali tombol? Tergantung kebutuhan.
                 // $('#upvote-btn').prop('disabled', false);
                 // $('#downvote-btn').prop('disabled', false);
            }
        });
    });

    // Handle Downvote
    $('#downvote-btn').on('click', function() {
        var id = $('#answer-id').val();
         if (!id) return; 

        $('#upvote-btn').prop('disabled', true);
        $('#downvote-btn').prop('disabled', true);

        $.post({
            url: 'site/downvote', 
            data: {id: id, _csrf: csrfToken},
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Downvote berhasil!');
                     $('#downvote-btn').addClass('btn-outline-danger').removeClass('btn-danger'); // Contoh feedback visual
                } else {
                    alert('Downvote gagal! ' + (response.message || ''));
                    $('#upvote-btn').prop('disabled', false);
                    $('#downvote-btn').prop('disabled', false);
                }
            },
             error: function() {
                alert('Terjadi kesalahan saat mengirim downvote.');
                 $('#upvote-btn').prop('disabled', false);
                 $('#downvote-btn').prop('disabled', false);
            }
        });
    });

    // Fungsi loadLogs tidak diubah, asumsikan sudah benar
    function loadLogs() {
        $.get("site/logs", function(data) { // Pastikan URL benar
            const chatHistory = document.getElementById('chat-history'); // Pastikan elemen ini ada jika digunakan
            let logsContainer = $("#chatbot-logs"); // Pastikan elemen ini ada di HTML
            if (!logsContainer.length) return; // Keluar jika elemen tidak ditemukan

            logsContainer.html(""); // Kosongkan kontainer

            if (data?.logs?.length > 0) {
                let table = $("<table class='table table-striped'>");
                let thead = $("<thead>").append("<tr><th>Pertanyaan</th><th>Jawaban</th><th>Waktu</th></tr>");
                let tbody = $("<tbody>");

                data.logs.forEach(function(log) {
                    let question = log?.question || "Tidak tersedia";
                    let answer = log?.answer || "Tidak tersedia";
                    let time = log?.timestamp ? new Date(log.timestamp * 1000).toLocaleString() : "Waktu tidak tersedia"; // Asumsi timestamp dalam detik

                    // Hanya tambahkan baris jika data valid (opsional, tergantung kebutuhan)
                    // if (question !== "Tidak tersedia" && answer !== "Tidak tersedia") {
                        let row = $("<tr>");
                        row.append($("<td>").text(question)); // Gunakan .text() untuk keamanan
                        row.append($("<td>").text(answer));
                        row.append($("<td>").text(time));
                        tbody.append(row);
                    // }
                });

                if (tbody.children().length === 0) {
                    logsContainer.html("<p>Belum ada log yang valid tersedia.</p>");
                } else {
                    table.append(thead).append(tbody);
                    logsContainer.append(table);
                }
            } else {
                logsContainer.html("<p>Belum ada log tersedia.</p>");
            }
        }, "json").fail(function(jqXHR, textStatus, errorThrown) {
             let logsContainer = $("#chatbot-logs");
             if (logsContainer.length) {
                 logsContainer.html("<p>Gagal mengambil log: " + textStatus + ", " + errorThrown + "</p>");
             }
        });
    }

    // Pastikan elemen #chatbot-logs ada di HTML Anda di suatu tempat agar loadLogs berfungsi
    // Contoh: <div id="chatbot-logs"></div>

    // Load logs saat halaman dibuka (jika elemennya ada)
    // if ($("#chatbot-logs").length) {
    //     loadLogs();
    //     setInterval(loadLogs, 10000); // Refresh logs setiap 10 detik
    // }

});
JS
);
?>
<style>
    /* Styling untuk kotak saran */
    #suggestions {
        border: 1px solid #ddd;
        /* max-width: 400px; */ /* Dihapus agar lebar sesuai input */
        background: #fff;
        /* position: absolute; */ /* Sudah diatur inline */
        /* z-index: 1000; */ /* Sudah diatur inline */
        display: none;
        border-radius: 0 0 5px 5px; /* Rapikan sudut bawah */
        overflow: hidden;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        max-height: 200px; /* Batasi tinggi jika saran banyak */
        overflow-y: auto; /* Tambahkan scroll jika perlu */
        margin-top: -1px; /* Rapatkan dengan input */
    }
    .suggestion-item {
        padding: 8px 12px; /* Sedikit lebih banyak padding */
        cursor: pointer;
        border-bottom: 1px solid #eee;
        font-size: 0.9em;
    }
    .suggestion-item:last-child {
        border-bottom: none; /* Hapus border bawah item terakhir */
    }
    .suggestion-item:hover {
        background: #f2f2f2;
    }

    /* Styling untuk loading indicator */
    #loading-indicator {
        /* display: inline-block; */ /* Sudah diatur inline */
        /* margin-left: 10px; */ /* Sudah diatur inline */
        color: #555;
        vertical-align: middle; /* Posisikan vertikal di tengah tombol */
    }

    .spinner {
        border: 4px solid rgba(0, 0, 0, 0.1);
        border-left-color: #0d6efd; /* Warna primary Bootstrap */
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
        display: inline-block;
        vertical-align: middle;
        margin-right: 5px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    /* Style tambahan untuk tombol vote yang sudah diklik (opsional) */
    #upvote-btn.btn-outline-success,
    #downvote-btn.btn-outline-danger {
        pointer-events: none; /* Mencegah klik lagi meskipun tidak disabled */
    }

</style>
