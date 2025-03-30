# AI Chatbot Informasi Publik Berbasis Dokumen
**Studi Kasus: Permendikbudristek No. 63/2023 (Dana BOS)**

## Gambaran Umum

Proyek ini merupakan prototipe chatbot berbasis AI yang dirancang untuk memahami dan 
menyajikan informasi dari dokumen secara otomatis. Dengan memanfaatkan teknologi 
Pemrosesan Bahasa Alami (NLP), chatbot ini menelusuri dokumen regulasi dan memberikan 
jawaban yang relevan atas pertanyaan pengguna, memungkinkan akses informasi yang cepat dan mudah.

Chatbot ini menggunakan pipeline dua tahap yang melibatkan model **SentenceTransformer** dan 
**CrossEncoder** untuk memastikan akurasi dan relevansi jawaban. SentenceTransformer melakukan 
penyaringan awal yang *cepat* untuk menemukan kandidat yang *mungkin* relevan dari banyak data. 
CrossEncoder kemudian melakukan analisis yang *lebih lambat tetapi lebih akurat* pada sejumlah 
kecil kandidat tersebut untuk memilih jawaban terbaik. Pendekatan dua tahap ini menyeimbangkan 
kecepatan dan kualitas.

1.  **Tahap Retrieval (Pengambilan Kandidat):**
    *   **SentenceTransformer** digunakan untuk mengubah teks pertanyaan pengguna dan potongan-potongan teks (chunks) dari dokumen menjadi representasi vektor numerik (embeddings) yang menangkap makna semantiknya.
    *   Ketika pertanyaan masuk, embedding pertanyaan dibandingkan dengan semua embedding chunk menggunakan **pencarian kemiripan (cosine similarity)**.
    *   Tahap ini dengan cepat mengidentifikasi sejumlah kecil chunk (misalnya, 10-15 kandidat) yang paling mirip secara semantik dengan pertanyaan.

2.  **Tahap Reranking (Penilaian Ulang Presisi):**
    *   Kandidat chunk yang diperoleh dari tahap retrieval kemudian dinilai ulang menggunakan **CrossEncoder**.
    *   Berbeda dengan SentenceTransformer yang melihat teks secara terpisah, CrossEncoder mengevaluasi *pasangan* `(pertanyaan, kandidat_chunk)` secara bersamaan. Hal ini memungkinkannya untuk memahami konteks dan nuansa hubungan antara pertanyaan dan kandidat chunk dengan lebih baik.
    *   CrossEncoder memberikan skor relevansi yang lebih presisi untuk setiap kandidat.

3.  **Hasil Akhir:**
    *   Chunk dengan skor tertinggi dari CrossEncoder dipilih sebagai jawaban yang paling relevan dan disajikan kepada pengguna (biasanya 3 teratas).

## Arsitektur

Proyek ini terdiri dari dua komponen utama:

*   **API Backend:** Dibangun menggunakan **Python** dengan framework **FastAPI**. Komponen ini menangani logika inti chatbot:
    *   Menerima permintaan dari UI.
    *   Memproses pertanyaan menggunakan pipeline SentenceTransformer (retrieval) dan CrossEncoder (reranking).
    *   Mengakses data chunk dan embeddings yang telah diproses sebelumnya.
    *   Mengembalikan jawaban yang relevan ke UI.
*   **UI Frontend:** Dibangun menggunakan **PHP** dengan framework **Yii2**. Komponen ini menyediakan antarmuka pengguna grafis (GUI) untuk:
    *   Mengajukan pertanyaan.
    *   Mengirim pertanyaan ke API Backend.
    *   Menampilkan jawaban yang diterima dari API.
    *   (Opsional) Mengumpulkan umpan balik pengguna.

## Keterbatasan Saat Ini

*   **Cakupan Terbatas:** Chatbot hanya dilatih dan dapat menjawab pertanyaan yang berkaitan langsung dengan isi Permendikbudristek No. 63/2023 tentang Dana BOSP.
*   **Sensitivitas terhadap Frasa:** Keakuratan jawaban dapat dipengaruhi oleh cara pertanyaan diajukan. Pertanyaan yang terlalu umum, ambigu, atau menggunakan terminologi yang sangat berbeda dari dokumen dapat menghasilkan jawaban yang kurang relevan.
*   **Tidak Memberikan Interpretasi Hukum:** Chatbot ini berfungsi sebagai alat pencarian informasi dan tidak dirancang untuk memberikan interpretasi hukum, nasihat keuangan, atau opini profesional. Informasi yang diberikan harus diverifikasi dengan sumber resmi.
*   **Potensi Jawaban Kurang Tepat:** Meskipun menggunakan reranking, terkadang jawaban terbaik mungkin tidak termasuk dalam kandidat awal yang diambil oleh SentenceTransformer, atau CrossEncoder mungkin masih salah menilai relevansi dalam kasus yang kompleks.

## Umpan Balik

Umpan balik dari pengguna sangat penting untuk meningkatkan kualitas chatbot ini. Jika UI menyediakan fitur umpan balik (misalnya, tombol 👍/👎), mohon gunakan untuk memberikan masukan Anda. Setiap masukan akan sangat membantu pengembangan chatbot ke depannya.

## Instalasi dan Pengaturan

Untuk instruksi detail mengenai instalasi dan pengaturan lingkungan backend (Python/FastAPI) dan frontend (PHP/Yii2), silakan merujuk ke file [**INSTALL.md**](INSTALL.md).

## Kontribusi

Kontribusi dalam bentuk perbaikan kode, peningkatan dokumentasi, penambahan fitur, atau pelaporan bug sangat diterima! Silakan buat *Pull Request* atau buka *Issue* di repositori GitHub.

## Lisensi

Proyek ini dilisensikan di bawah MIT License - lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.