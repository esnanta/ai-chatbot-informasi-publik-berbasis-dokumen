# AI Chatbot Informasi Publik Berbasis Dokumen
**Studi Kasus: Permendikbudristek No. 63/2023 (Dana BOS)**

## Gambaran Umum

Proyek ini merupakan prototipe chatbot berbasis AI yang dirancang untuk memahami dan menyajikan informasi dari dokumen secara otomatis. Dengan teknologi AI, chatbot menelusuri dokumen regulasi dan memberikan jawaban yang relevan, sehingga pengguna dapat memperoleh informasi dengan cepat dan mudah.

DocuQuery menggunakan dua model utama, yaitu SentenceTransformer dan CrossEncoder, serta memanfaatkan FAISS untuk pencarian vektor berbasis kesamaan. 

* SentenceTransformer berfungsi untuk mengubah teks, baik dari dokumen maupun pertanyaan pengguna, menjadi representasi vektor (embedding).
* Ketika pengguna mengajukan pertanyaan, embedding dari pertanyaan tersebut dibandingkan dengan embedding dari chunk data menggunakan FAISS, yang bertugas mencari beberapa chunk dengan tingkat kesamaan tertinggi.
* FAISS mengembalikan daftar n chunk yang paling mirip dalam bentuk vektor. Daftar ini kemudian dievaluasi lebih lanjut oleh CrossEncoder, yang memberikan skor relevansi untuk menentukan chunk terbaik berdasarkan makna kontekstualnya.
* Chunk dengan skor tertinggi dari CrossEncoder ditampilkan sebagai jawaban kepada pengguna.
  
## Arsitektur

Proyek ini terdiri dari dua komponen utama:

*   **API:** Dibangun menggunakan **Python** (FastAPI). Komponen ini menangani logika utama chatbot, termasuk pemrosesan pertanyaan dan pencocokan dengan teks regulasi menggunakan model sentence transformer.
*   **UI:** Dibangun menggunakan **PHP** (Yii2). Komponen ini menyediakan antarmuka bagi pengguna untuk mengajukan pertanyaan, mengirimnya ke API, dan menampilkan jawaban.

## Keterbatasan Saat Ini

*   **Cakupan Terbatas:** Chatbot hanya dapat menjawab pertanyaan yang berkaitan langsung dengan isi Permendikbudristek No. 63/2023.
*   **Sensitivitas terhadap Frasa:** Keakuratan jawaban sangat bergantung pada bagaimana pertanyaan diajukan. Pertanyaan yang terlalu umum atau menggunakan istilah yang berbeda dari dokumen regulasi dapat menghasilkan jawaban yang kurang relevan.
*   **Tidak Memberikan Interpretasi Hukum:** Chatbot tidak dirancang untuk memberikan interpretasi hukum atau nasihat profesional.
*   **Jawaban yang Berulang:** Dalam beberapa kasus, chatbot dapat memberikan jawaban yang serupa untuk pertanyaan dengan makna yang mirip.

## Umpan Balik

Umpan balik dari pengguna sangat penting untuk meningkatkan kualitas chatbot ini. Silakan gunakan tombol *upvote* (👍) atau *downvote* (👎) setelah menerima jawaban untuk memberikan masukan. Setiap umpan balik akan sangat membantu pengembangan chatbot ke depannya.

## Instalasi dan Pengaturan (instalasi.txt)

### 1. **Persiapan Lingkungan Python**
*   Disarankan menggunakan virtual environment:
    ```bash
    python3 -m venv venv
    source venv/bin/activate  # Linux/macOS
    venv\Scripts\activate    # Windows
    ```
*   Instal paket Python yang diperlukan:
    ```bash
    pip install -r requirements.txt
    ```

### 2. **Menjalankan API FastAPI**
*   Jalankan server FastAPI menggunakan /api/chatbot.bat

### 3. **Persiapan Lingkungan PHP (Yii2)**
*   Pastikan server web (Apache/Nginx) telah dikonfigurasi untuk menjalankan aplikasi Yii2.
*   Konfigurasikan aplikasi Yii2, termasuk koneksi database dan pengaturan URL.

### 4. **Menjalankan Aplikasi**
*   Akses aplikasi melalui browser untuk mulai menggunakan chatbot.

## Kontribusi

Kontribusi dalam bentuk perbaikan kode, penambahan fitur, atau pelaporan bug sangat diterima!

## Lisensi

Proyek ini dilisensikan di bawah MIT License - lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.
