# AI Chatbot Berbasis Dokumen untuk Layanan Informasi Publik  
**Studi Kasus: Permendikbudristek No. 63/2023 (Dana BOS)**

## Gambaran Umum

Proyek ini adalah prototipe awal chatbot berbasis AI yang dirancang untuk memberikan informasi terkait regulasi dari Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi (Permendikbudristek) Nomor 63 Tahun 2023. Chatbot ini berfokus pada pertanyaan seputar pengelolaan Dana Bantuan Operasional Sekolah (BOS), termasuk BOP PAUD (Bantuan Operasional Pendidikan Anak Usia Dini), BOS (Bantuan Operasional Sekolah), dan BOP Kesetaraan.

Chatbot ini menggunakan pendekatan **sentence transformer**, yang berarti keakuratan jawaban sangat bergantung pada cara penyampaian pertanyaan dan kata kunci yang digunakan. Untuk hasil optimal, pengguna disarankan menggunakan frasa yang sesuai dengan isi regulasi Permendikbudristek No. 63/2023.

**Ini adalah prototipe awal yang mungkin belum selalu memberikan jawaban yang akurat atau lengkap.** Jawaban chatbot didasarkan pada dokumen regulasi yang tersedia dan tidak boleh dianggap sebagai nasihat hukum. Dalam beberapa kasus, chatbot dapat memberikan jawaban yang bersifat umum atau repetitif.

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

## Instalasi dan Pengaturan

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

### 2. **Persiapan Data**
*   Simpan file PDF regulasi Permendikbudristek No. 63/2023 di direktori khusus (misalnya, `knowledge_base`).
*   Jalankan skrip Python untuk mengekstrak teks, melakukan pemrosesan, membagi menjadi bagian kecil, dan membuat embedding. Hasilnya akan disimpan dalam file seperti `embeddings.npy` dan `chunks.json`. Pastikan jalur file disesuaikan dengan konfigurasi proyek.

### 3. **Menjalankan API FastAPI**
*   Jalankan server FastAPI menggunakan `uvicorn`:
    ```bash
    uvicorn main:app --host 0.0.0.0 --port 8000
    ```

### 4. **Persiapan Lingkungan PHP (Yii2)**
*   Pastikan server web (Apache/Nginx) telah dikonfigurasi untuk menjalankan aplikasi Yii2.
*   Konfigurasikan aplikasi Yii2, termasuk koneksi database dan pengaturan URL.

### 5. **Menjalankan Aplikasi**
*   Akses aplikasi melalui browser untuk mulai menggunakan chatbot.

## Kontribusi

Kontribusi dalam bentuk perbaikan kode, penambahan fitur, atau pelaporan bug sangat diterima!

## Lisensi

Proyek ini dilisensikan di bawah MIT License - lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.
