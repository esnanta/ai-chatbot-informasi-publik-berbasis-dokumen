/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - ai_chatbot_bos
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ai_chatbot_bos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `ai_chatbot_bos`;

/*Table structure for table `tx_qa_log` */

DROP TABLE IF EXISTS `tx_qa_log`;

CREATE TABLE `tx_qa_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` longtext DEFAULT NULL,
  `answer` longtext DEFAULT NULL,
  `upvote` int(11) DEFAULT NULL,
  `downvote` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tx_qa_log` */

/*Table structure for table `tx_suggestion` */

DROP TABLE IF EXISTS `tx_suggestion`;

CREATE TABLE `tx_suggestion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text DEFAULT NULL,
  `category` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tx_suggestion` */

insert  into `tx_suggestion`(`id`,`question`,`category`,`description`,`created_at`) values 
(1,'Apa yang dimaksud dengan Dana BOSP?','Definisi','Pasal 1 (definition of Dana BOSP)','2025-03-24 22:04:13'),
(2,'Apa yang dimaksud dengan Dana BOP PAUD?','Definisi','Pasal 1 (definition of Dana BOP PAUD)','2025-03-24 22:04:13'),
(3,'Apa yang dimaksud dengan Dana BOS Reguler?','Definisi','Pasal 1 (definition of Dana BOS Reguler)','2025-03-24 22:04:13'),
(4,'Apa yang dimaksud dengan Dana BOP Kesetaraan?','Definisi','Pasal 1 (definition of BOP Kesetaraan)','2025-03-24 22:04:13'),
(5,'Apa perbedaan antara Dana BOS Reguler dan Dana BOS Kinerja?','Definisi','Pasal 1, Pasal 7 (definitions and types of BOS funds)','2025-03-24 22:04:13'),
(6,'Apa yang dimaksud dengan Satuan Pendidikan?','Definisi','Pasal 1','2025-03-24 22:04:13'),
(7,'Satuan Pendidikan apa saja yang menerima Dana BOS?','Kelayakan','Pasal 7 (lists eligible schools: SD, SMP, SMA, SLB, SMK)','2025-03-24 22:04:13'),
(8,'Siapa yang menerima Dana BOP PAUD?','Kelayakan','Pasal 4','2025-03-24 22:04:13'),
(9,'Sebutkan komponen dana BOS untuk prestasi.','Penggunaan Dana','RINCIAN KOMPONEN PENGGUNAAN\r\nDANA BANTUAN OPERASIONAL SATUAN PENDIDIKAN \r\nHal 5','2025-03-24 22:04:13'),
(10,'Untuk apa saja Dana BOS Kinerja dapat digunakan?','Penggunaan Dana','Pasal 42 (detailed breakdown of uses, including for Program Sekolah Penggerak, schools with achievements, and schools with the best progress)','2025-03-24 22:04:13'),
(11,'Komponen penggunaan Dana BOP PAUD Kinerja meliputi apa saja?','Penggunaan Dana','Pasal 37 (lists components: human resource development, independent curriculum learning, school digitization, data-based planning)','2025-03-24 22:04:13'),
(12,'Bagaimana Dana BOS Kinerja digunakan untuk sekolah yang melaksanakan Program Sekolah Penggerak?','Penggunaan Dana','Pasal 42 (specifically addresses the use for Program Sekolah Penggerak)','2025-03-24 22:04:13'),
(13,'Apa saja komponen penggunaan Dana BOS Reguler?','Penggunaan Dana','There is no specific pasal, because it is for general operational.','2025-03-24 22:04:13'),
(14,'Apakah Dana BOSP dapat digunakan untuk pengembangan sumber daya manusia?','Penggunaan Dana','Pasal 37, Pasal 42 (this is a key component for Kinerja funds)','2025-03-24 22:04:13'),
(15,'Apa itu pembelajaran kurikulum merdeka dalam penggunaan Dana BOSP?','Penggunaan Dana','Pasal 37, Pasal 42','2025-03-24 22:04:13'),
(16,'Kapan laporan realisasi penggunaan Dana BOSP harus disampaikan?','Pelaporan & Administrasi','Pasal 51 (specifies deadlines: July 31 for the first stage, January 31 for the full year)','2025-03-24 22:04:13'),
(17,'Bagaimana cara menyampaikan laporan realisasi penggunaan Dana BOSP?','Pelaporan & Administrasi','Pasal 51 (states that reports are submitted through the application system provided by the Ministry)','2025-03-24 22:04:13'),
(18,'Apa yang dimaksud dengan RKAS dalam pengelolaan Dana BOSP?','Pelaporan & Administrasi','Pasal 1 angka 24','2025-03-24 22:04:13'),
(19,'Apa yang dimaksud dengan Program Sekolah Penggerak?','Program Sekolah Penggerak','Pasal 1 (definition) and recurring throughout the document in the context of Dana BOS Kinerja.','2025-03-24 22:04:13'),
(20,'Bagaimana sekolah pengimbas menggunakan Dana BOS Kinerja?','Program Sekolah Penggerak','Pasal 42','2025-03-24 22:04:13');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
