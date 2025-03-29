<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Disclaimer';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="disclaimer">
    <p>
        Informasi yang diberikan oleh chatbot bersifat informatif dan tidak dapat dianggap
        sebagai nasihat hukum atau keputusan resmi.
    </p>
    <p>
        Program ini menggunakan kombinasi model <em>sentence transformer</em> dan
        <em>cross-encoder</em> untuk memberikan jawaban yang relevan.
    </p>
    <ul>
        <li><b>Cakupan Terbatas:</b> Chatbot saat ini hanya dapat menjawab pertanyaan yang berkaitan dengan isi Permendikbudristek No. 63 Tahun 2023.</li>
        <li><b>Sensitivitas Frasa:</b> Kualitas jawaban bergantung pada seberapa mirip pertanyaan dengan informasi yang tersedia. Pertanyaan yang terlalu umum atau menggunakan istilah yang berbeda mungkin menghasilkan jawaban yang kurang relevan.</li>
        <li><b>Tidak Ada Interpretasi Hukum:</b> Chatbot tidak dirancang untuk memberikan interpretasi hukum atau nasihat profesional.</li>
        <li><b>Potensi Jawaban Serupa:</b> Dalam beberapa kasus, chatbot dapat memberikan jawaban yang serupa untuk pertanyaan yang memiliki kemiripan makna, meskipun kata-katanya berbeda.</li>
    </ul>
</div>
