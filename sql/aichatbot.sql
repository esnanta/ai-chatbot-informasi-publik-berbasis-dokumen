-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2025 at 06:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ai_chatbot_bos`
--

-- --------------------------------------------------------

--
-- Table structure for table `tx_qa_log`
--

CREATE TABLE `tx_qa_log` (
                             `id` int(11) NOT NULL,
                             `question` longtext DEFAULT NULL,
                             `answer` longtext DEFAULT NULL,
                             `upvote` int(11) DEFAULT NULL,
                             `downvote` int(11) DEFAULT NULL,
                             `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tx_suggestion`
--

CREATE TABLE `tx_suggestion` (
                                 `id` int(11) NOT NULL,
                                 `question` text DEFAULT NULL,
                                 `category` tinyint(4) DEFAULT NULL,
                                 `description` text DEFAULT NULL,
                                 `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tx_suggestion`
--

INSERT INTO `tx_suggestion` (`id`, `question`, `category`, `description`, `created_at`) VALUES
                                                                                            (1, 'Apa yang dimaksud dengan Satuan Pendidikan?', 1, 'Pasal 1 Angka 1', '2025-04-06 23:32:29'),
                                                                                            (2, 'Apa yang dimaksud dengan Dana BOSP?', 1, 'Pasal 1 Angka 2', '2025-04-06 23:32:29'),
                                                                                            (3, 'Apa itu Dana BOP PAUD?', 1, 'Pasal 1 Angka 4', '2025-04-06 23:32:29'),
                                                                                            (4, 'Apa definisi Dana BOS?', 1, 'Pasal 1 Angka 5', '2025-04-06 23:32:29'),
                                                                                            (5, 'Apa yang dimaksud Dana BOP PAUD Reguler?', 1, 'Pasal 1 Angka 7', '2025-04-06 23:32:29'),
                                                                                            (6, 'Apa itu Dana BOS Reguler?', 1, 'Pasal 1 Angka 8', '2025-04-06 23:32:29'),
                                                                                            (7, 'Apa itu Dana BOP Kesetaraan Reguler?', 1, 'Pasal 1 Angka 9', '2025-04-06 23:32:29'),
                                                                                            (8, 'Apa itu Dana BOS Kinerja?', 1, 'Pasal 1 Angka 11', '2025-04-06 23:32:29'),
                                                                                            (9, 'Apa yang dimaksud dengan Sekolah Terintegrasi?', 1, 'Pasal 1 Angka 22', '2025-04-06 23:32:29'),
                                                                                            (10, 'Jelaskan tentang Program Sekolah Penggerak?', 1, 'Pasal 1 Angka 23', '2025-04-06 23:32:29'),
                                                                                            (11, 'Satuan Pendidikan apa saja yang menyelenggarakan layanan PAUD dan dapat menerima Dana BOP PAUD?', 2, 'Pasal 4 ayat (2)', '2025-04-06 23:32:29'),
                                                                                            (12, 'Satuan Pendidikan apa saja yang menjadi penerima Dana BOS?', 2, 'Pasal 7 ayat (1)', '2025-04-06 23:32:29'),
                                                                                            (13, 'Bagaimana penghitungan Dana BOS Reguler untuk SLB, Sekolah Terintegrasi, dan Satuan Pendidikan di Daerah Khusus yang memiliki Peserta Didik kurang dari 60?', 2, 'Pasal 24', '2025-04-06 23:32:29'),
                                                                                            (14, 'Apa kriteria Peserta Didik yang dihitung dalam alokasi Dana BOP Kesetaraan Reguler?', 2, 'Pasal 27 ayat (3)', '2025-04-06 23:32:29'),
                                                                                            (15, 'Apa saja komponen penggunaan Dana BOP PAUD Kinerja?', 3, 'Pasal 37', '2025-04-06 23:32:29'),
                                                                                            (16, 'Untuk apa Dana BOP PAUD Kinerja bagi Satuan Pendidikan yang melaksanakan Program Sekolah Penggerak yang ditetapkan sebagai pelaksana program pengimbasan?', 3, 'Pasal 37A', '2025-04-06 23:32:29'),
                                                                                            (17, 'Apa saja komponen penggunaan Dana BOS Kinerja bagi sekolah yang melaksanakan Program Sekolah Penggerak?', 3, 'Pasal 42 ayat (2)', '2025-04-06 23:32:29'),
                                                                                            (18, 'Apa komponen penggunaan Dana BOS Kinerja bagi sekolah yang memiliki prestasi?', 3, 'Pasal 42 ayat (3)', '2025-04-06 23:32:29'),
                                                                                            (19, 'Apa komponen penggunaan Dana BOS Kinerja sekolah yang memiliki kemajuan terbaik?', 3, 'Pasal 42 ayat (6)', '2025-04-06 23:32:29'),
                                                                                            (20, 'Apa saja komponen penggunaan Dana BOP Kesetaraan Kinerja?', 3, 'Pasal 45', '2025-04-06 23:32:29'),
                                                                                            (21, 'Sebutkan contoh kegiatan pengembangan sumber daya manusia yang dibiayai Dana BOP PAUD Kinerja Sekolah Penggerak?', 3, 'Lampiran I Bagian B nomor 1 huruf a', '2025-04-06 23:32:29'),
                                                                                            (22, 'Bagaimana cara Kepala Satuan Pendidikan menyampaikan laporan realisasi penggunaan Dana BOSP?', 4, 'Pasal 51 ayat (1)', '2025-04-06 23:32:29'),
                                                                                            (23, 'Kapan batas waktu penyampaian laporan realisasi pengunaan Dana BOP PAUD Reguler, Dana BOS Reguler, atau Dana BOP Kesetaraan Reguler tahap I?', 4, 'Pasal 51 ayat (2) huruf a', '2025-04-06 23:32:29'),
                                                                                            (24, 'Kapan batas waktu penyampaian laporan realisasi keseluruhan penggunaan Dana BOSP yang diterima dalam satu tahun anggaran?', 4, 'Pasal 51 ayat (2) huruf b', '2025-04-06 23:32:29'),
                                                                                            (25, 'Apa yang digunakan sebagai dasar penyaluran Dana BOSP tahap I tahun berkenaan?', 4, 'Pasal 52a ayat (1)', '2025-04-06 23:32:29'),
                                                                                            (26, 'Apa yang menjadi dasar penyaluran Dana BOSP tahap II tahun anggaran berkenaan?', 4, 'Pasal 52a ayat (2)', '2025-04-06 23:32:29'),
                                                                                            (27, 'Jika sekolah saya baru ditetapkan sebagai Sekolah Penggerak, bagaimana saya semestinya memanfaatkan Dana BOS Kinerja yang diterima?', 5, 'Pasal 42 ayat (2), Lampiran I Bagian B nomor 3', '2025-04-06 23:32:29'),
                                                                                            (28, 'Apakah penyaluran Dana BOS tahap kedua akan terhambat jika laporan tahap pertama belum selesai?', 5, 'Implikasi dari Pasal 52a ayat (2)', '2025-04-06 23:32:29'),
                                                                                            (29, 'Sekolah kami di wilayah 3T (terdepan, terluar, tertinggal) dan murid SD hanya 45 orang, apakah perhitungan BOS Reguler tetap untuk 60 siswa?', 5, 'Implikasi dari Pasal 24 (Daerah Khusus)', '2025-04-06 23:32:29'),
                                                                                            (30, 'Apakah Dana BOP Kesetaraan Kinerja boleh dipakai untuk workshop peningkatan kompetensi tutor dalam pembelajaran digital?', 5, 'Pasal 45 (interpretasi komponen)', '2025-04-06 23:32:29'),
                                                                                            (31, 'Apa perbedaan fundamental antara alokasi Dana BOS Reguler dengan Dana BOS Kinerja?', 5, 'Pasal 1 Angka 8 vs Angka 11 (Tujuan Penggunaan)', '2025-04-06 23:32:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tx_qa_log`
--
ALTER TABLE `tx_qa_log`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tx_suggestion`
--
ALTER TABLE `tx_suggestion`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tx_qa_log`
--
ALTER TABLE `tx_qa_log`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tx_suggestion`
--
ALTER TABLE `tx_suggestion`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
