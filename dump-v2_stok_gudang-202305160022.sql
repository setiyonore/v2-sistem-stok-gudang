-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: v2_stok_gudang
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `barang`
--

DROP TABLE IF EXISTS `barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barang` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `referensi_satuan` bigint unsigned NOT NULL,
  `referensi_kategori` bigint unsigned NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `barang_referensi_satuan_foreign` (`referensi_satuan`),
  KEY `barang_referensi_kategori_foreign` (`referensi_kategori`),
  CONSTRAINT `barang_referensi_kategori_foreign` FOREIGN KEY (`referensi_kategori`) REFERENCES `referensi` (`id`),
  CONSTRAINT `barang_referensi_satuan_foreign` FOREIGN KEY (`referensi_satuan`) REFERENCES `referensi` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang`
--

LOCK TABLES `barang` WRITE;
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` VALUES (1,6,5,'Antena Rocket Dish 30 DBi','12',NULL,'2023-04-05 09:43:02'),(2,6,5,'Mikrotik Routerboard CCR 1036','7','2023-01-01 16:42:47','2023-01-15 09:14:24'),(3,6,5,'Router Cisco','5','2023-01-15 08:32:53','2023-04-05 09:43:02');
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barang_keluar_item`
--

DROP TABLE IF EXISTS `barang_keluar_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barang_keluar_item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_barang_id` bigint unsigned NOT NULL,
  `barang_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `barang_keluar_detil_barang_id_foreign` (`barang_id`),
  CONSTRAINT `barang_keluar_detil_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang_keluar_item`
--

LOCK TABLES `barang_keluar_item` WRITE;
/*!40000 ALTER TABLE `barang_keluar_item` DISABLE KEYS */;
INSERT INTO `barang_keluar_item` VALUES (1,1,1,1,'2023-05-11 02:04:13','2023-05-12 01:44:37'),(2,1,2,2,'2023-05-11 02:04:13','2023-05-12 01:44:37'),(3,2,1,6,'2023-05-12 07:09:50','2023-05-12 07:16:58'),(4,2,3,4,'2023-05-12 07:09:50','2023-05-12 07:16:58');
/*!40000 ALTER TABLE `barang_keluar_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barang_masuk`
--

DROP TABLE IF EXISTS `barang_masuk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barang_masuk` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `yang_menyerahkan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pegawai_id` bigint unsigned NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_sp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `barang_masuk_pegawai_id_foreign` (`pegawai_id`),
  CONSTRAINT `barang_masuk_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang_masuk`
--

LOCK TABLES `barang_masuk` WRITE;
/*!40000 ALTER TABLE `barang_masuk` DISABLE KEYS */;
INSERT INTO `barang_masuk` VALUES (1,'2023-05-11','pak tono',2,'untuk testing','ASDDFFGG','2023-05-11 02:03:54','2023-05-11 02:03:54'),(2,'2023-05-12','pak tono',2,'untuk testing','ASDGFD12331','2023-05-12 02:06:49','2023-05-12 02:06:49'),(3,'2023-05-12','pak toni',2,'untuk testing 2','KJJHHS888GGHJ','2023-05-12 02:10:39','2023-05-12 02:10:39');
/*!40000 ALTER TABLE `barang_masuk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barang_masuk_item`
--

DROP TABLE IF EXISTS `barang_masuk_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barang_masuk_item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `barang_masuk_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `item_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `barang_masuk_detil_barang_masuk_id_foreign` (`barang_masuk_id`),
  KEY `barang_masuk_item_item_id_fk` (`item_id`),
  CONSTRAINT `barang_masuk_detil_barang_masuk_id_foreign` FOREIGN KEY (`barang_masuk_id`) REFERENCES `barang_masuk` (`id`),
  CONSTRAINT `barang_masuk_item_item_id_fk` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang_masuk_item`
--

LOCK TABLES `barang_masuk_item` WRITE;
/*!40000 ALTER TABLE `barang_masuk_item` DISABLE KEYS */;
INSERT INTO `barang_masuk_item` VALUES (1,1,'2023-05-11 02:03:54','2023-05-11 02:03:54',1),(2,1,'2023-05-11 02:03:54','2023-05-11 02:03:54',2),(3,2,'2023-05-12 02:06:49','2023-05-12 02:06:49',3),(4,3,'2023-05-12 02:10:39','2023-05-12 02:10:39',4),(5,3,'2023-05-12 02:12:08','2023-05-12 02:12:08',5),(6,3,'2023-05-12 02:12:08','2023-05-12 02:12:08',6);
/*!40000 ALTER TABLE `barang_masuk_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history_status_item`
--

DROP TABLE IF EXISTS `history_status_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `history_status_item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `item_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `referensi_status_item` bigint unsigned NOT NULL,
  `referensi_jenis_transaksi` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `history_status_items_referensi_status_item_foreign` (`referensi_status_item`),
  KEY `history_status_items_referensi_jenis_transaksi_foreign` (`referensi_jenis_transaksi`),
  CONSTRAINT `history_status_items_referensi_jenis_transaksi_foreign` FOREIGN KEY (`referensi_jenis_transaksi`) REFERENCES `referensi` (`id`),
  CONSTRAINT `history_status_items_referensi_status_item_foreign` FOREIGN KEY (`referensi_status_item`) REFERENCES `referensi` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history_status_item`
--

LOCK TABLES `history_status_item` WRITE;
/*!40000 ALTER TABLE `history_status_item` DISABLE KEYS */;
INSERT INTO `history_status_item` VALUES (3,11,'2023-04-29',16,19,'2023-04-29 06:10:41','2023-04-29 06:10:41'),(4,1,'2023-05-11',16,19,'2023-05-11 02:03:54','2023-05-11 02:03:54'),(5,2,'2023-05-11',16,19,'2023-05-11 02:03:54','2023-05-11 02:03:54'),(6,1,'2023-05-12',17,20,'2023-05-12 01:44:37','2023-05-12 01:44:37'),(7,2,'2023-05-12',17,20,'2023-05-12 01:44:37','2023-05-12 01:44:37'),(8,3,'2023-05-12',16,19,'2023-05-12 02:06:49','2023-05-12 02:06:49'),(9,4,'2023-05-12',16,19,'2023-05-12 02:10:39','2023-05-12 02:10:39'),(10,5,'2023-05-12',16,19,'2023-05-12 02:12:08','2023-05-12 02:12:08'),(11,6,'2023-05-12',16,19,'2023-05-12 02:12:08','2023-05-12 02:12:08'),(12,6,'2023-05-12',17,20,'2023-05-12 07:16:58','2023-05-12 07:16:58'),(13,4,'2023-05-12',17,20,'2023-05-12 07:16:58','2023-05-12 07:16:58');
/*!40000 ALTER TABLE `history_status_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `barang_id` bigint unsigned NOT NULL,
  `referensi_kondisi_barang` bigint unsigned NOT NULL,
  `no_serial` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `referensi_status_item` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_barang_id_foreign` (`barang_id`),
  KEY `item_referensi_kondisi_barang_foreign` (`referensi_kondisi_barang`),
  CONSTRAINT `item_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`),
  CONSTRAINT `item_referensi_kondisi_barang_foreign` FOREIGN KEY (`referensi_kondisi_barang`) REFERENCES `referensi` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (1,1,14,'1234qwert',17,'2023-05-11 02:03:54','2023-05-11 02:03:54'),(2,2,14,'1234asdf',17,'2023-05-11 02:03:54','2023-05-11 02:03:54'),(3,3,14,'K8F7H5J3N6M2L1',16,'2023-05-12 02:06:49','2023-05-12 02:06:49'),(4,3,14,'R6T9Y1U5O4P2I8',17,'2023-05-12 02:10:39','2023-05-12 07:16:58'),(5,2,14,'Q2W9E7R4T0Y5U1',16,'2023-05-12 02:12:08','2023-05-12 02:12:08'),(6,1,14,'A5S7D3F1G9H2J8',17,'2023-05-12 02:12:08','2023-05-12 07:16:58');
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenis_referensi`
--

DROP TABLE IF EXISTS `jenis_referensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jenis_referensi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_referensi`
--

LOCK TABLES `jenis_referensi` WRITE;
/*!40000 ALTER TABLE `jenis_referensi` DISABLE KEYS */;
INSERT INTO `jenis_referensi` VALUES (1,'Satuan Barang','Satuan Barang','2022-12-23 13:30:40','2022-12-23 13:30:40'),(2,'Jabatan','jabatan','2022-12-23 13:31:25','2022-12-23 13:31:25'),(3,'Kategori Barang','Kategori Barang','2022-12-24 12:56:33','2022-12-24 12:56:33'),(4,'Jenis Perusahaan','Jenis Perusahaan','2022-12-28 02:37:50','2022-12-28 02:37:50'),(5,'Status Permintaan','Status Permintaan Order Barang','2023-01-09 02:41:08','2023-01-09 02:41:08'),(6,'Kondisi Barang','kondisi barang','2023-04-28 13:31:01','2023-04-28 13:31:01'),(7,'Status Barang','status barang','2023-04-28 13:58:48','2023-04-28 13:58:48'),(8,'Jenis Transaksi','jenis transaksi','2023-04-29 05:30:43','2023-04-29 05:30:43');
/*!40000 ALTER TABLE `jenis_referensi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2014_10_12_200000_add_two_factor_columns_to_users_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2022_12_02_210842_create_permission_tables',1),(7,'2022_12_18_135548_create_jenis_referensis_table',1),(8,'2022_12_21_130744_create_referensis_table',1),(10,'2022_12_24_190037_create_barangs_table',2),(14,'2022_12_26_044624_create_pegawais_table',3),(16,'2022_12_28_092040_create_perusahaans_table',4),(17,'2022_12_30_210626_update_table_users',5),(18,'2023_01_01_135018_create_barang_masuks_table',6),(19,'2023_01_01_140727_create_barang_masuk_detils_table',7),(23,'2023_01_08_211609_create_surat_permintaans_table',8),(24,'2023_01_10_102710_create_barang_keluars_table',8),(25,'2023_01_10_103843_create_barang_keluar_detils_table',8),(26,'2023_04_28_075643_create_items_table',9),(27,'2023_04_28_080635_rename_tbl_barang_masuk_dtl',10),(29,'2023_04_28_134947_add_column_no_sp_tbl_barang_masuk',11),(30,'2023_04_28_135159_remove_column_in_tbl_barang_masuk',12),(31,'2023_04_28_143630_drop_colum_barang_id_tbl_barang_masuk_item',13),(32,'2023_04_28_201800_create_history_status_items_table',13),(33,'2023_05_04_161911_create_order_barangs_table',14);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',2);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_barang`
--

DROP TABLE IF EXISTS `order_barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_barang` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `no_sp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `referensi_status_order` bigint unsigned NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pelanggan_id` bigint unsigned NOT NULL,
  `pegawai_id` bigint unsigned NOT NULL,
  `is_input_item` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_barang_referensi_status_order_foreign` (`referensi_status_order`),
  KEY `order_barang_pelanggan_id_foreign` (`pelanggan_id`),
  KEY `order_barang_pegawai_id_foreign` (`pegawai_id`),
  CONSTRAINT `order_barang_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`),
  CONSTRAINT `order_barang_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `perusahaan` (`id`),
  CONSTRAINT `order_barang_referensi_status_order_foreign` FOREIGN KEY (`referensi_status_order`) REFERENCES `referensi` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_barang`
--

LOCK TABLES `order_barang` WRITE;
/*!40000 ALTER TABLE `order_barang` DISABLE KEYS */;
INSERT INTO `order_barang` VALUES (1,'11052023/DTP/001','2023-05-11',12,'untuk testing',3,2,1,'2023-05-11 02:04:13','2023-05-12 01:44:37'),(2,'12052023/DTP/001','2023-05-12',12,'untuk testing instalasi',2,2,1,'2023-05-12 07:09:50','2023-05-12 07:16:58');
/*!40000 ALTER TABLE `order_barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pegawai`
--

DROP TABLE IF EXISTS `pegawai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pegawai` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `referensi_jabatan` bigint unsigned NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_lahir` date NOT NULL,
  `nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pegawai_referensi_jabatan_foreign` (`referensi_jabatan`),
  CONSTRAINT `pegawai_referensi_jabatan_foreign` FOREIGN KEY (`referensi_jabatan`) REFERENCES `referensi` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pegawai`
--

LOCK TABLES `pegawai` WRITE;
/*!40000 ALTER TABLE `pegawai` DISABLE KEYS */;
INSERT INTO `pegawai` VALUES (1,3,'Tio','2022-12-24','12.10.22','082231592577','Semolowaru Utara no 6',NULL,'2023-01-05 03:34:09'),(2,4,'Joko','2022-11-28','30.12.22','0893344444355','Jl Semampir no 5','2022-12-30 15:02:13','2022-12-30 15:02:13'),(3,4,'Sindi','2023-01-01','01.01.23','08993444344','Jl Ahmad Yani no 50','2023-01-01 08:59:05','2023-01-01 08:59:05');
/*!40000 ALTER TABLE `pegawai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'dashboard.index','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(2,'dashboard.barang','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(3,'dashboard.surat_pending','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(4,'dashboard.stok_barang','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(5,'pegawai.index','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(6,'pegawai.add','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(7,'pegawai.edit','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(8,'pegawai.delete','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(9,'perusahaan.index','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(10,'perusahaan.add','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(11,'perusahaan.edit','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(12,'perusahaan.delete','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(13,'barang.index','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(14,'barang.add','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(15,'barang.edit','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(16,'barang.delete','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(17,'barang.field_stok','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(18,'order.index','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(19,'order.add','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(20,'order.edit','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(21,'order.delete','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(22,'order.approval','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(23,'barang_masuk.index','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(24,'barang_masuk.add','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(25,'barang_masuk.edit','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(26,'barang_masuk.delete','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(27,'barang_keluar.index','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(28,'barang_keluar.approval','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(29,'referensi.index','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(30,'referensi.add','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(31,'referensi.edit','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(32,'referensi.delete','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(33,'jenis_referensi.index','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(34,'jenis_referensi.add','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(35,'jenis_referensi.edit','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(36,'jenis_referensi.delete','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(37,'roles.index','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(38,'roles.add','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(39,'roles.edit','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(40,'roles.delete','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(41,'user.index','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(42,'user.add','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(43,'user.edit','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(44,'user.delete','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(45,'order.input_item','web',NULL,NULL);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perusahaan`
--

DROP TABLE IF EXISTS `perusahaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perusahaan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `referensi_jenis_perusahaan` bigint unsigned NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp_pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `perusahaan_referensi_jenis_perusahaan_foreign` (`referensi_jenis_perusahaan`),
  CONSTRAINT `perusahaan_referensi_jenis_perusahaan_foreign` FOREIGN KEY (`referensi_jenis_perusahaan`) REFERENCES `referensi` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perusahaan`
--

LOCK TABLES `perusahaan` WRITE;
/*!40000 ALTER TABLE `perusahaan` DISABLE KEYS */;
INSERT INTO `perusahaan` VALUES (1,10,'PT.Bumi Perkasa','Jl.Ahmad Yani No 56','083343434','perkasa.bumi@gmail.com','Pak Yono','0878834343',NULL,'2022-12-30 13:53:38'),(2,9,'PT Golden Bridge','Jl Raya Gubeng no 9','031122233344','golden.bride@gmail.com',NULL,NULL,'2023-01-09 03:07:36','2023-01-09 03:07:36'),(3,9,'PT.Pertamini','Jl Raya Ahmad Yani no 15','031444556556','pertamini@gmail.com','pak reza','08997773443','2023-01-11 14:07:18','2023-01-11 14:07:18');
/*!40000 ALTER TABLE `perusahaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `referensi`
--

DROP TABLE IF EXISTS `referensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `referensi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jenis_referensi_id` bigint unsigned NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `referensi_jenis_referensi_id_foreign` (`jenis_referensi_id`),
  CONSTRAINT `referensi_jenis_referensi_id_foreign` FOREIGN KEY (`jenis_referensi_id`) REFERENCES `jenis_referensi` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `referensi`
--

LOCK TABLES `referensi` WRITE;
/*!40000 ALTER TABLE `referensi` DISABLE KEYS */;
INSERT INTO `referensi` VALUES (1,1,'M','Meter',NULL,'2022-12-24 06:06:50'),(3,2,'Teknisi','Teknisi','2022-12-23 19:03:55','2022-12-24 06:11:37'),(4,2,'Admin Gudang','Admin Gudang','2022-12-23 19:29:22','2022-12-23 19:29:22'),(5,3,'VSAT','VSAT','2022-12-24 12:56:54','2022-12-24 12:56:54'),(6,1,'Unit','Unit','2022-12-24 18:51:28','2023-01-01 16:42:19'),(7,1,'Lonjor','Lonjor','2022-12-24 18:51:42','2022-12-24 18:51:42'),(8,3,'Habis Pakai','Habis Pakai','2022-12-24 18:51:59','2022-12-24 18:51:59'),(9,4,'Customer','Customer','2022-12-28 02:38:27','2022-12-28 02:38:27'),(10,4,'Supplier','Supplier','2022-12-28 02:38:56','2022-12-28 02:38:56'),(11,5,'Pending','pending','2023-01-09 02:41:33','2023-01-09 02:41:33'),(12,5,'Disetujui','disetujui','2023-01-09 02:41:55','2023-01-09 02:41:55'),(13,5,'Ditolak','ditolak','2023-01-09 02:42:06','2023-01-09 02:42:06'),(14,6,'Normal','kondisi barang normal','2023-04-28 13:31:33','2023-04-28 13:31:33'),(15,6,'Cacat / Rusak','kondisi barang cacat atau rusak','2023-04-28 13:32:07','2023-04-28 13:32:07'),(16,7,'Tersedia','barang tersedia','2023-04-28 13:59:10','2023-04-28 13:59:10'),(17,7,'Terpakai','barang terpakai','2023-04-28 13:59:34','2023-04-28 13:59:34'),(18,7,'Ditukar','barang sedang ditukar','2023-04-28 13:59:58','2023-04-28 13:59:58'),(19,8,'Barang Masuk','barang masuk','2023-04-29 05:31:08','2023-04-29 05:31:08'),(20,8,'Barang Keluar','barang keluar','2023-04-29 05:32:51','2023-04-29 05:32:51');
/*!40000 ALTER TABLE `referensi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(18,2),(19,2),(20,2),(21,2);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'administrator','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(2,'teknisi','web','2022-12-23 13:29:31','2022-12-23 13:29:31'),(3,'admin gudang','web','2022-12-23 13:29:31','2022-12-23 13:29:31');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surat_permintaan`
--

DROP TABLE IF EXISTS `surat_permintaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `surat_permintaan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `no_sp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `referensi_status_sp` bigint unsigned NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pelanggan_id` bigint unsigned NOT NULL,
  `pegawai_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `surat_permintaan_referensi_status_sp_foreign` (`referensi_status_sp`),
  KEY `surat_permintaan_pelanggan_id_foreign` (`pelanggan_id`),
  KEY `surat_permintaan_pegawai_id_foreign` (`pegawai_id`),
  CONSTRAINT `surat_permintaan_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`),
  CONSTRAINT `surat_permintaan_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `perusahaan` (`id`),
  CONSTRAINT `surat_permintaan_referensi_status_sp_foreign` FOREIGN KEY (`referensi_status_sp`) REFERENCES `referensi` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surat_permintaan`
--

LOCK TABLES `surat_permintaan` WRITE;
/*!40000 ALTER TABLE `surat_permintaan` DISABLE KEYS */;
INSERT INTO `surat_permintaan` VALUES (4,'15012023/DTP/001','2023-01-15',12,'untuk installasi',2,2,'2023-01-15 12:20:02','2023-01-16 05:29:00'),(6,'18012023/DTP/001','2023-01-18',12,'installasi',2,2,'2023-01-18 02:10:08','2023-01-18 02:56:52'),(7,'20012023/DTP/001','2023-01-20',12,'untuk installasi',3,2,'2023-01-18 02:59:16','2023-01-18 02:59:30'),(8,'28012023/DTP/001','2023-01-28',13,'untuk installasi',3,2,'2023-01-18 05:18:04','2023-01-18 05:20:08'),(9,'02022023/DTP/001','2023-02-02',11,'untuk install jaringan',2,2,'2023-02-01 23:25:17','2023-02-01 23:25:17'),(10,'05042023/DTP/001','2023-04-05',12,'instalasi',2,2,'2023-04-05 09:41:13','2023-04-05 09:43:01');
/*!40000 ALTER TABLE `surat_permintaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pegawai_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','admin@gmail.com',NULL,'$2y$10$CXOZLJOrOG119YtempJI7e6i6xfkWdVv5KkrbCnNqDxZpkJ5ClLCa',NULL,NULL,NULL,'2022-12-23 13:29:31','2023-01-05 03:34:28',2),(2,'Setiyono','setiyono.ressly@gmail.com',NULL,'$2y$10$f84uD1gDLbk3ra2JoFk0OeHaSW/W5NvaRbvr2f9mkEc5C1ePu3HuS',NULL,NULL,NULL,'2022-12-30 14:40:21','2022-12-30 15:07:35',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'v2_stok_gudang'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-16  0:22:54
