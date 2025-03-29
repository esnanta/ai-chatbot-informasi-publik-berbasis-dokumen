<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="about-program">
    <h2>Tentang Chatbot AI</h2>

    <p>
        Chatbot AI Layanan Informasi Dana BOS hadir untuk mempermudah akses informasi terkait
        <b>
            Peraturan Menteri Pendidikan, Kebudayaan, Riset, dan Teknologi (Permendikbudristek)
            Nomor 63 Tahun 2023
        </b>.
    </p>
    <p>
        Sebagai layanan informasi publik, chatbot ini bertujuan membantu pengguna memahami regulasi dengan lebih mudah,
        sehingga pengelolaan dana dapat dilakukan secara profesional, transparan, dan sesuai aturan.
        Dengan teknologi AI, layanan ini diharapkan dapat meningkatkan akuntabilitas dan efisiensi
        pengelolaan Dana BOS.
    </p>

    <div class="alert alert-warning" role="alert">
        <strong>Penting:</strong>
        <p>
            Program ini menggunakan kombinasi model <em>sentence transformer</em> dan
            <em>cross-encoder</em> untuk memberikan jawaban yang relevan.
        </p>
        <ul>
            <li><b>Cakupan Terbatas:</b> Chatbot saat ini hanya dapat menjawab pertanyaan yang
                berkaitan dengan isi Permendikbudristek No. 63 Tahun 2023.
            </li>
            <li><b>Sensitivitas Frasa:</b> Kualitas jawaban bergantung pada seberapa mirip pertanyaan
                dengan informasi yang tersedia. Pertanyaan yang terlalu umum atau menggunakan istilah
                yang berbeda mungkin menghasilkan jawaban yang kurang relevan.
            </li>
            <li><b>Tidak Ada Interpretasi Hukum:</b> Chatbot tidak dirancang untuk memberikan
                interpretasi hukum atau nasihat profesional.
            </li>
            <li><b>Potensi Jawaban Serupa:</b> Dalam beberapa kasus, chatbot dapat memberikan jawaban
                yang serupa untuk pertanyaan yang memiliki kemiripan makna, meskipun kata-katanya berbeda.
            </li>
        </ul>
    </div>

    <h3>Umpan Balik</h3>
    <p>
        Untuk meningkatkan kualitas layanan, silakan berikan umpan balik Anda melalui tombol
        <i>upvote</i> (👍) atau <i>downvote</i> (👎) setelah menerima jawaban.
        Masukan Anda akan sangat membantu dalam pengembangan program ini lebih lanjut.
    </p>

</div>