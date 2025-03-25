<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="about-program">
    <h2>Tentang Chatbot AI</h2>

    <p>
        Chatbot AI Layanan Informasi Publik ini dikembangkan sebagai purwarupa awal untuk menyediakan
        informasi terkait <b>Peraturan Menteri Pendidikan, Kebudayaan, Riset,
            dan Teknologi (Permendikbudristek) Nomor 63 Tahun 2023</b>.
        Program ini dirancang untuk menjawab pertanyaan yang berhubungan dengan  pengelolaan
        Dana Bantuan Operasional Satuan Pendidikan (BOSP), termasuk Dana BOP PAUD, Dana BOS,
        dan Dana BOP Kesetaraan.
    </p>

    <div class="alert alert-warning" role="alert">
        <strong>Penting:</strong>
        <p>
            Program dikembangkan dengan memanfaatkan <em>sentence transformer</em>.
            Frasa dan kata kunci yang digunakan dalam pertanyaan akan sangat memengaruhi
            akurasi dan relevansi jawaban yang diberikan. <b>Hal ini karena model
                mencari kesamaan makna antara pertanyaan dan teks dalam regulasi.</b>
        </p>
        <ul>
            <li><b>Cakupan Terbatas:</b> Chatbot saat ini hanya dapat menjawab pertanyaan yang
                secara langsung berkaitan dengan isi Permendikbudristek No. 63 Tahun 2023.
            </li>
            <li><b>Sensitivitas Frasa:</b> Kualitas jawaban sangat bergantung pada frasa pertanyaan.
                Pertanyaan yang terlalu umum atau menggunakan istilah di luar dokumen regulasi dapat
                menghasilkan jawaban yang kurang relevan.
            </li>
            <li><b>Tidak Ada Interpretasi Hukum:</b> Chatbot tidak dirancang untuk memberikan interpretasi hukum atau nasihat profesional.</li>
            <li><b>Potensi Jawaban Berulang:</b> Dalam beberapa kasus, chatbot dapat memberikan jawaban yang serupa untuk pertanyaan yang berbeda namun memiliki kemiripan frasa.</li>
        </ul>
    </div>

    <h3>Umpan Balik</h3>
    <p>
        Untuk meningkatkan kualitas layanan, silakan berikan umpan balik Anda melalui tombol <i>upvote</i> (👍) atau <i>downvote</i> (👎) setelah menerima jawaban. Masukan Anda akan sangat membantu dalam pengembangan program ini lebih lanjut.
    </p>

</div>

