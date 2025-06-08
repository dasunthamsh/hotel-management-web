-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: hotel_reservation
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `billings`
--

DROP TABLE IF EXISTS `billings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `billings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reservation_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `branch_id` bigint unsigned NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('credit_card','cash','travel_agency') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('pending','paid','no_show') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `restaurant_charges` decimal(10,2) NOT NULL DEFAULT '0.00',
  `room_service_charges` decimal(10,2) NOT NULL DEFAULT '0.00',
  `laundry_charges` decimal(10,2) NOT NULL DEFAULT '0.00',
  `telephone_charges` decimal(10,2) NOT NULL DEFAULT '0.00',
  `club_facility_charges` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `billings_reservation_id_foreign` (`reservation_id`),
  KEY `billings_user_id_foreign` (`user_id`),
  KEY `billings_branch_id_foreign` (`branch_id`),
  CONSTRAINT `billings_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `billings_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `billings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billings`
--

LOCK TABLES `billings` WRITE;
/*!40000 ALTER TABLE `billings` DISABLE KEYS */;
INSERT INTO `billings` VALUES (1,2,6,1,200.00,'cash','paid',0.00,100.00,0.00,0.00,0.00,'2025-05-26 11:02:19','2025-05-27 09:40:17'),(2,3,6,1,50.00,'cash','paid',0.00,0.00,0.00,0.00,0.00,'2025-05-26 11:05:12','2025-05-26 11:05:18'),(3,4,6,1,80.00,'cash','paid',0.00,0.00,0.00,0.00,0.00,'2025-05-26 11:10:46','2025-05-26 11:10:54'),(4,10,6,1,0.00,'cash','paid',0.00,0.00,0.00,0.00,0.00,'2025-05-26 12:34:07','2025-05-26 12:34:18'),(5,11,6,1,0.00,'cash','paid',0.00,0.00,0.00,0.00,0.00,'2025-05-26 12:38:59','2025-05-26 12:39:11'),(6,9,6,1,110.00,'cash','paid',0.00,0.00,0.00,0.00,60.00,'2025-05-26 12:39:22','2025-05-27 11:48:28'),(7,12,6,1,3000.00,'cash','paid',0.00,0.00,0.00,0.00,0.00,'2025-05-26 13:33:12','2025-05-26 13:33:18'),(8,7,6,1,150.00,'cash','paid',0.00,0.00,10.00,10.00,50.00,'2025-05-26 13:33:45','2025-05-27 11:47:31'),(10,8,6,1,102.00,'cash','paid',0.00,0.00,7.00,5.00,10.00,'2025-05-27 12:55:20','2025-05-28 11:08:05'),(11,13,6,1,62.00,'cash','paid',0.00,0.00,0.00,0.00,12.00,'2025-05-28 10:55:14','2025-06-01 06:26:50'),(12,17,6,1,2047.67,'cash','paid',0.00,0.00,0.00,7.67,40.00,'2025-05-28 11:13:03','2025-05-28 11:21:41'),(13,14,6,1,52.00,'cash','paid',0.00,0.00,0.00,0.00,2.00,'2025-05-28 11:22:10','2025-05-28 11:22:25'),(14,19,6,1,2020.00,'cash','paid',0.00,0.00,0.00,0.00,20.00,'2025-05-28 15:39:50','2025-05-28 17:07:22'),(16,21,2,1,100.00,'cash','paid',0.00,0.00,0.00,0.00,0.00,'2025-05-28 16:42:44','2025-06-03 14:56:44'),(17,22,2,1,114.00,'cash','paid',0.00,0.00,0.00,4.00,10.00,'2025-05-28 16:42:44','2025-06-01 10:54:22'),(18,23,2,1,65.00,'cash','paid',0.00,5.00,0.00,0.00,10.00,'2025-05-28 16:44:11','2025-05-29 07:52:44'),(22,23,2,1,50.00,NULL,'pending',0.00,0.00,0.00,0.00,0.00,'2025-05-28 16:52:43','2025-05-28 16:52:43'),(23,22,2,1,100.00,NULL,'pending',0.00,0.00,0.00,0.00,0.00,'2025-05-28 17:03:44','2025-05-28 17:03:44'),(25,28,7,2,2000.00,NULL,'pending',0.00,0.00,0.00,0.00,0.00,'2025-05-28 19:20:32','2025-05-28 19:20:32'),(26,15,6,1,60.00,'credit_card','paid',0.00,0.00,0.00,0.00,10.00,'2025-06-01 04:04:59','2025-06-01 10:23:04'),(27,16,6,1,100.00,'cash','paid',0.00,0.00,0.00,0.00,20.00,'2025-06-01 04:06:13','2025-06-01 10:09:02'),(28,18,6,1,60.00,'cash','paid',0.00,0.00,0.00,0.00,10.00,'2025-06-01 06:07:20','2025-06-01 10:54:52'),(29,29,6,1,100.00,'cash','paid',0.00,0.00,0.00,0.00,0.00,'2025-06-01 06:48:23','2025-06-04 03:33:10'),(30,27,7,1,110.00,'cash','paid',0.00,0.00,0.00,0.00,10.00,'2025-06-01 10:36:22','2025-06-02 07:35:43'),(31,21,2,1,100.00,NULL,'pending',0.00,0.00,0.00,0.00,0.00,'2025-06-03 08:10:43','2025-06-03 08:10:43'),(33,31,6,1,160.00,'cash','paid',0.00,0.00,0.00,0.00,0.00,'2025-06-04 03:43:50','2025-06-07 06:03:01'),(34,42,7,1,67.00,'cash','paid',7.00,4.00,0.00,3.00,3.00,'2025-06-04 15:56:48','2025-06-04 16:02:19'),(35,44,2,1,524.88,'travel_agency','pending',0.00,0.00,0.00,0.00,0.00,'2025-06-04 16:08:47','2025-06-04 16:08:47'),(36,45,2,1,524.88,'travel_agency','pending',0.00,0.00,0.00,0.00,0.00,'2025-06-04 16:08:47','2025-06-04 16:08:47'),(37,46,2,1,524.88,'travel_agency','pending',0.00,0.00,0.00,0.00,0.00,'2025-06-04 16:08:47','2025-06-04 16:08:47'),(38,47,2,1,524.88,'travel_agency','pending',0.00,0.00,0.00,0.00,0.00,'2025-06-04 16:08:47','2025-06-04 16:08:47'),(39,47,2,1,2000.00,NULL,'pending',0.00,0.00,0.00,0.00,0.00,'2025-06-04 16:12:00','2025-06-04 16:12:00'),(40,47,2,1,2000.00,NULL,'pending',0.00,0.00,0.00,0.00,0.00,'2025-06-04 16:12:00','2025-06-04 16:12:00'),(41,40,9,1,2000.00,NULL,'pending',0.00,0.00,0.00,0.00,0.00,'2025-06-04 16:12:10','2025-06-04 16:12:10'),(42,50,6,1,400.00,'cash','paid',0.00,0.00,0.00,0.00,0.00,'2025-06-07 06:02:35','2025-06-07 18:31:27'),(43,36,1,1,80.00,'credit_card','pending',0.00,0.00,0.00,0.00,0.00,'2025-06-07 12:43:50','2025-06-07 12:43:50'),(44,48,6,1,2100.00,'credit_card','pending',0.00,0.00,0.00,0.00,0.00,'2025-06-07 12:43:50','2025-06-07 12:43:50'),(45,49,6,1,2100.00,'credit_card','pending',0.00,0.00,0.00,0.00,0.00,'2025-06-07 12:43:50','2025-06-07 12:43:50'),(46,56,6,2,100.00,NULL,'pending',0.00,0.00,0.00,0.00,0.00,'2025-06-07 21:08:09','2025-06-07 21:08:09');
/*!40000 ALTER TABLE `billings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `branches` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branches`
--

LOCK TABLES `branches` WRITE;
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
INSERT INTO `branches` VALUES (1,'Colombo Branch','Galle Road, Colombo','0112345678','2025-05-26 08:58:36','2025-05-26 08:58:36'),(2,'Kandy Branch','Peradeniya Road, Kandy','0812345678','2025-05-26 08:58:36','2025-05-26 08:58:36'),(3,'Galle Branch','Unawatuna, Galle','0912238846','2025-06-06 20:27:10','2025-06-06 20:27:10');
/*!40000 ALTER TABLE `branches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (42,'2019_12_14_000001_create_personal_access_tokens_table',1),(43,'2025_05_23_000001_create_branches_table',1),(44,'2025_05_23_000002_create_users_table',1),(45,'2025_05_23_000003_create_room_types_table',1),(46,'2025_05_23_000004_create_rooms_table',1),(47,'2025_05_23_000005_create_reservations_table',1),(48,'2025_05_23_000006_create_billings_table',1),(49,'2025_05_23_000007_create_travel_agencies_table',1),(50,'2025_05_23_000008_create_travel_agency_bookings_table',1),(51,'2025_05_23_000009_create_reports_table',1),(52,'2025_05_24_163347_make_price_per_night_nullable_in_room_types',1),(53,'2025_05_26_173207_add_duration_fields_to_reservations',2),(54,'2025_05_26_175318_change_date_columns_to_datetime_in_reservations',3),(55,'2025_05_30_114742_add_report_type_and_data_to_reports_table',4),(56,'2025_05_30_185000_add_date_range_to_reports_table',5),(57,'2025_06_07_193100_add_role_to_users_table',6),(58,'2025_06_07_204445_add_admin_role_to_users_table',7);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
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
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` bigint unsigned DEFAULT NULL,
  `report_date` date NOT NULL,
  `total_occupancy` int NOT NULL,
  `total_revenue` decimal(10,2) NOT NULL,
  `no_show_count` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_branch_id_foreign` (`branch_id`),
  CONSTRAINT `reports_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` VALUES (54,1,'2025-05-29',0,0.00,0,'2025-05-30 08:12:17','2025-06-07 20:10:02'),(55,1,'2025-05-30',0,0.00,0,'2025-05-30 08:12:17','2025-06-07 20:10:02'),(56,1,'2025-05-31',0,0.00,0,'2025-05-30 08:12:17','2025-06-07 20:10:02'),(57,1,'2025-06-01',0,0.00,0,'2025-05-30 08:12:17','2025-06-07 20:10:02'),(58,1,'2025-06-02',0,0.00,0,'2025-05-30 08:12:17','2025-06-07 20:10:02'),(59,1,'2025-06-03',0,0.00,0,'2025-05-30 08:12:17','2025-06-07 20:10:02'),(60,1,'2025-06-04',0,3172.00,0,'2025-05-30 08:12:17','2025-06-07 20:06:33'),(61,1,'2025-06-05',0,110.00,0,'2025-05-30 08:12:17','2025-06-07 20:06:33'),(62,1,'2025-06-06',0,5409.76,0,'2025-05-30 08:12:17','2025-06-07 20:06:33'),(63,1,'2025-06-07',0,524.88,0,'2025-05-30 08:12:17','2025-06-07 20:06:33'),(64,1,'2025-06-08',0,0.00,0,'2025-05-30 08:12:17','2025-06-07 20:06:10'),(65,1,'2025-06-09',0,0.00,0,'2025-05-30 08:12:17','2025-05-30 08:18:41'),(66,1,'2025-06-10',0,0.00,0,'2025-05-30 08:12:17','2025-05-30 08:18:41'),(67,1,'2025-06-11',0,0.00,0,'2025-05-30 08:18:41','2025-05-30 08:18:41'),(68,1,'2025-06-12',0,2000.00,0,'2025-05-30 08:18:41','2025-06-04 16:17:46'),(69,1,'2025-06-13',0,0.00,0,'2025-05-30 08:18:41','2025-05-30 08:18:41'),(70,1,'2025-06-14',0,0.00,0,'2025-05-30 08:18:41','2025-05-30 08:18:41'),(71,1,'2025-06-15',0,0.00,0,'2025-05-30 08:18:41','2025-05-30 08:18:41'),(72,1,'2025-06-16',0,4524.88,0,'2025-05-30 08:18:41','2025-06-04 16:17:46'),(73,1,'2025-06-17',0,0.00,0,'2025-05-30 08:18:41','2025-05-30 08:18:41'),(74,1,'2025-06-18',0,0.00,0,'2025-05-30 08:18:41','2025-05-30 08:18:41'),(75,1,'2025-06-19',0,0.00,0,'2025-05-30 08:18:41','2025-05-30 08:18:41'),(76,1,'2025-06-20',0,160.00,0,'2025-05-30 08:18:41','2025-06-04 03:59:29'),(77,1,'2025-06-21',0,0.00,0,'2025-05-30 08:18:41','2025-05-30 08:18:41'),(78,1,'2025-06-22',0,0.00,0,'2025-05-30 08:18:41','2025-05-30 08:18:41'),(79,1,'2025-06-23',0,0.00,0,'2025-05-30 08:18:41','2025-05-30 08:18:41'),(80,1,'2025-06-24',0,0.00,0,'2025-05-30 08:18:41','2025-05-30 08:18:41'),(81,1,'2025-06-25',0,0.00,0,'2025-05-30 08:18:41','2025-05-30 08:18:41'),(82,1,'2025-06-26',0,400.00,0,'2025-05-30 08:18:41','2025-06-07 06:19:23'),(83,1,'2025-06-27',0,0.00,0,'2025-05-30 08:18:41','2025-05-30 08:18:41'),(84,1,'2025-06-28',0,0.00,0,'2025-05-30 08:18:41','2025-05-30 08:18:41'),(85,1,'2025-06-29',0,0.00,0,'2025-05-30 08:18:41','2025-05-30 08:18:41'),(86,1,'2025-06-30',0,67.00,0,'2025-05-30 08:18:41','2025-06-04 16:17:46'),(87,1,'2025-05-17',0,0.00,0,'2025-05-30 08:40:00','2025-05-30 08:40:00'),(88,1,'2025-05-18',0,0.00,0,'2025-05-30 08:40:00','2025-05-30 08:40:00'),(89,1,'2025-05-19',0,0.00,0,'2025-05-30 08:40:00','2025-05-30 08:40:00'),(90,1,'2025-05-20',0,0.00,0,'2025-05-30 08:40:00','2025-05-30 08:40:00'),(91,1,'2025-05-21',0,0.00,0,'2025-05-30 08:40:00','2025-05-30 08:40:00'),(92,1,'2025-05-22',0,0.00,0,'2025-05-30 08:40:00','2025-05-30 08:40:00'),(93,1,'2025-05-23',0,0.00,0,'2025-05-30 08:40:00','2025-05-30 08:40:00'),(94,1,'2025-05-24',0,0.00,0,'2025-05-30 08:40:00','2025-05-30 08:40:00'),(95,1,'2025-05-25',0,0.00,0,'2025-05-30 08:40:00','2025-05-30 08:40:00'),(96,1,'2025-05-26',0,0.00,0,'2025-05-30 08:40:00','2025-05-30 08:40:00'),(97,1,'2025-05-27',0,0.00,0,'2025-05-30 08:40:00','2025-06-07 20:10:02'),(98,1,'2025-05-28',0,0.00,0,'2025-05-30 08:40:00','2025-06-07 20:10:02'),(99,NULL,'2025-06-02',1,250.00,0,'2025-06-03 16:50:33','2025-06-03 16:50:33'),(100,NULL,'2025-06-06',1,4280.00,3,'2025-06-07 12:44:04','2025-06-07 12:44:04');
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `branch_id` bigint unsigned NOT NULL,
  `room_id` bigint unsigned DEFAULT NULL,
  `room_type_id` bigint unsigned NOT NULL,
  `check_in_date` datetime NOT NULL,
  `check_out_date` datetime DEFAULT NULL,
  `duration_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration_value` int DEFAULT NULL,
  `number_of_occupants` int NOT NULL,
  `status` enum('pending','confirmed','checked_in','checked_out','cancelled','no_show') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `credit_card_details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_suite` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservations_user_id_foreign` (`user_id`),
  KEY `reservations_branch_id_foreign` (`branch_id`),
  KEY `reservations_room_id_foreign` (`room_id`),
  KEY `reservations_room_type_id_foreign` (`room_type_id`),
  CONSTRAINT `reservations_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reservations_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reservations_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` VALUES (1,6,1,NULL,1,'2025-06-03 00:00:00','2025-06-05 00:00:00',NULL,NULL,1,'cancelled','1838223',0,'2025-05-26 09:03:11','2025-05-26 11:00:49'),(2,6,1,1,1,'2025-06-03 00:00:00','2025-06-05 00:00:00',NULL,NULL,1,'checked_out','21212883',0,'2025-05-26 10:43:23','2025-05-26 11:02:28'),(3,6,1,1,1,'2025-05-27 00:00:00','2025-05-28 00:00:00',NULL,NULL,1,'checked_out','1228383',0,'2025-05-26 10:44:32','2025-05-26 11:05:18'),(4,6,1,31,2,'2025-06-06 00:00:00','2025-06-07 00:00:00',NULL,NULL,2,'checked_out',NULL,0,'2025-05-26 10:46:04','2025-05-26 11:10:54'),(5,6,1,NULL,2,'2025-07-10 00:00:00','2025-07-11 00:00:00',NULL,NULL,2,'cancelled','8737322',0,'2025-05-26 10:50:38','2025-05-26 12:20:05'),(6,6,1,51,3,'2025-06-04 00:00:00','2025-06-10 00:00:00',NULL,NULL,4,'checked_out','93874334',1,'2025-05-26 10:57:34','2025-05-28 10:55:35'),(7,6,1,31,2,'2025-05-27 00:00:00','2025-05-28 00:00:00',NULL,NULL,2,'checked_out',NULL,0,'2025-05-26 11:06:51','2025-05-26 13:33:55'),(8,6,1,31,2,'2025-05-27 00:00:00','2025-05-28 00:00:00',NULL,NULL,2,'checked_out','654433',0,'2025-05-26 11:08:45','2025-05-28 10:57:52'),(9,6,1,1,1,'2025-06-04 00:00:00','2025-06-05 00:00:00',NULL,NULL,1,'checked_out',NULL,0,'2025-05-26 11:09:18','2025-05-26 12:39:27'),(10,6,1,51,3,'2025-06-03 00:00:00','2025-06-17 00:00:00','weeks',2,4,'checked_out',NULL,0,'2025-05-26 12:32:47','2025-05-26 12:34:18'),(11,6,1,51,3,'2025-06-01 00:00:00','2025-06-22 00:00:00','weeks',3,4,'checked_out','218844',0,'2025-05-26 12:38:10','2025-05-26 12:39:11'),(12,6,1,51,3,'2025-06-04 00:00:00','2025-06-25 00:00:00','weeks',3,4,'checked_out','838733',0,'2025-05-26 13:32:10','2025-05-26 13:33:18'),(13,6,1,1,1,'2025-06-04 00:00:00','2025-06-05 00:00:00',NULL,NULL,1,'checked_out','827734',0,'2025-05-27 11:55:28','2025-06-01 06:26:50'),(14,6,1,2,1,'2025-05-30 00:00:00','2025-05-31 00:00:00',NULL,NULL,1,'checked_out','773322',0,'2025-05-27 13:01:02','2025-05-28 11:22:25'),(15,6,1,3,1,'2025-05-29 00:00:00','2025-05-30 00:00:00',NULL,NULL,1,'checked_out','55444',0,'2025-05-28 08:47:02','2025-06-01 04:05:43'),(16,6,1,31,2,'2025-05-29 00:00:00','2025-05-30 00:00:00',NULL,NULL,1,'checked_out','342355',0,'2025-05-28 11:11:16','2025-06-01 10:01:09'),(17,6,1,53,3,'2025-05-29 00:00:00','2025-06-12 00:00:00','weeks',2,4,'checked_out',NULL,0,'2025-05-28 11:12:02','2025-05-28 11:13:17'),(18,6,1,3,1,'2025-05-30 00:00:00','2025-05-31 00:00:00',NULL,NULL,1,'checked_out',NULL,0,'2025-05-28 15:29:07','2025-06-01 10:54:52'),(19,6,1,51,3,'2025-06-01 00:00:00','2025-06-15 00:00:00','weeks',2,4,'checked_out','2773723',0,'2025-05-28 15:29:51','2025-05-28 17:07:22'),(21,2,1,2,1,'2025-05-30 00:00:00','2025-06-01 00:00:00',NULL,NULL,1,'checked_out',NULL,0,'2025-05-28 16:42:44','2025-06-03 14:56:44'),(22,2,1,2,1,'2025-05-30 00:00:00','2025-06-01 00:00:00',NULL,NULL,1,'checked_out',NULL,0,'2025-05-28 16:42:44','2025-06-01 07:09:13'),(23,2,1,2,1,'2025-05-31 00:00:00','2025-06-01 00:00:00',NULL,NULL,1,'checked_out',NULL,0,'2025-05-28 16:44:11','2025-05-28 16:53:51'),(27,7,1,2,1,'2025-06-05 00:00:00','2025-06-07 00:00:00',NULL,NULL,1,'checked_out',NULL,0,'2025-05-28 19:17:38','2025-06-02 07:35:43'),(28,7,2,104,3,'2025-06-03 00:00:00','2025-06-17 00:00:00','weeks',2,4,'checked_in',NULL,0,'2025-05-28 19:18:17','2025-05-28 19:20:32'),(29,6,1,1,1,'2025-06-02 00:00:00','2025-06-04 00:00:00',NULL,NULL,1,'checked_out','163673732',0,'2025-06-01 06:45:19','2025-06-04 00:27:07'),(31,6,1,31,2,'2025-06-20 00:00:00','2025-06-22 00:00:00',NULL,NULL,2,'checked_out','654444',0,'2025-06-03 15:21:30','2025-06-07 06:03:01'),(32,6,1,NULL,3,'2025-06-10 00:00:00','2025-06-24 00:00:00','weeks',2,4,'cancelled','9383884',0,'2025-06-03 15:23:06','2025-06-07 18:23:54'),(33,1,1,NULL,2,'2025-06-06 00:00:00','2025-06-07 00:00:00',NULL,NULL,2,'cancelled',NULL,0,'2025-06-04 04:27:05','2025-06-04 04:48:47'),(36,1,1,NULL,2,'2025-06-06 00:00:00','2025-06-07 00:00:00',NULL,NULL,2,'no_show',NULL,0,'2025-06-04 04:44:28','2025-06-07 12:43:50'),(38,1,1,NULL,1,'2025-06-10 00:00:00','2025-06-11 00:00:00',NULL,NULL,1,'cancelled',NULL,0,'2025-06-04 04:47:38','2025-06-04 04:48:51'),(39,9,1,NULL,2,'2025-06-08 00:00:00','2025-06-10 00:00:00',NULL,NULL,2,'cancelled','7555344578',0,'2025-06-04 15:01:07','2025-06-04 15:06:55'),(40,9,1,52,3,'2025-06-12 00:00:00','2025-06-26 00:00:00','weeks',2,4,'checked_in','939388292',0,'2025-06-04 15:09:50','2025-06-04 16:12:10'),(41,9,1,NULL,1,'2025-06-19 00:00:00','2025-06-22 00:00:00',NULL,NULL,1,'cancelled','38982833',0,'2025-06-04 15:15:29','2025-06-07 20:37:41'),(42,7,1,1,1,'2025-06-30 00:00:00','2025-07-01 00:00:00',NULL,NULL,1,'checked_out','737822222',0,'2025-06-04 15:48:08','2025-06-04 16:00:00'),(43,8,1,NULL,3,'2025-06-08 00:00:00','2025-06-22 00:00:00','weeks',2,3,'pending','288383',0,'2025-06-04 16:06:07','2025-06-04 16:06:07'),(44,2,1,NULL,1,'2025-06-07 00:00:00','2025-06-10 00:00:00',NULL,NULL,1,'cancelled',NULL,0,'2025-06-04 16:08:47','2025-06-07 12:39:01'),(45,2,1,NULL,2,'2025-06-06 00:00:00','2025-06-08 00:00:00',NULL,NULL,2,'pending',NULL,0,'2025-06-04 16:08:47','2025-06-04 16:08:47'),(46,2,1,NULL,2,'2025-06-06 00:00:00','2025-06-08 00:00:00',NULL,NULL,2,'pending',NULL,0,'2025-06-04 16:08:47','2025-06-04 16:08:47'),(47,2,1,51,3,'2025-06-16 00:00:00','2025-06-30 00:00:00','weeks',2,4,'checked_in',NULL,0,'2025-06-04 16:08:47','2025-06-04 16:12:00'),(48,6,1,NULL,4,'2025-06-06 00:00:00','2025-06-27 00:00:00',NULL,NULL,4,'no_show',NULL,0,'2025-06-05 01:59:07','2025-06-07 12:43:50'),(49,6,1,NULL,4,'2025-06-06 00:00:00','2025-06-27 00:00:00',NULL,NULL,4,'no_show',NULL,0,'2025-06-05 01:59:30','2025-06-07 12:43:50'),(50,6,1,134,4,'2025-06-26 00:00:00','2025-06-30 00:00:00',NULL,NULL,4,'checked_out','3288332',0,'2025-06-05 02:00:06','2025-06-07 18:31:27'),(51,6,1,NULL,4,'2025-06-26 00:00:00','2025-06-30 00:00:00',NULL,NULL,4,'pending','4435664',0,'2025-06-05 02:01:03','2025-06-05 02:01:03'),(52,6,1,NULL,4,'2025-06-27 00:00:00','2025-06-28 00:00:00',NULL,NULL,4,'pending',NULL,0,'2025-06-05 02:02:14','2025-06-05 02:02:14'),(55,11,1,NULL,1,'2025-06-20 00:00:00','2025-06-27 00:00:00',NULL,NULL,1,'pending','787665676',0,'2025-06-07 02:15:21','2025-06-07 02:17:32'),(56,6,2,54,1,'2025-06-08 00:00:00','2025-06-10 00:00:00',NULL,NULL,1,'checked_in','499453',0,'2025-06-07 06:01:06','2025-06-07 21:08:09'),(57,15,1,NULL,1,'2025-06-09 00:00:00','2025-06-17 00:00:00',NULL,NULL,1,'pending',NULL,0,'2025-06-07 15:25:52','2025-06-07 15:25:52');
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_types`
--

DROP TABLE IF EXISTS `room_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `room_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price_per_night` decimal(8,2) DEFAULT NULL,
  `weekly_rate` decimal(10,2) DEFAULT NULL,
  `monthly_rate` decimal(10,2) DEFAULT NULL,
  `max_occupants` int NOT NULL,
  `is_suite` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_types`
--

LOCK TABLES `room_types` WRITE;
/*!40000 ALTER TABLE `room_types` DISABLE KEYS */;
INSERT INTO `room_types` VALUES (1,'Single Room','Cozy single room',50.00,NULL,NULL,1,0,'2025-05-26 08:58:39','2025-05-26 08:58:39'),(2,'Double Room','Spacious double room',80.00,NULL,NULL,2,0,'2025-05-26 08:58:39','2025-05-26 08:58:39'),(3,'One-Bedroom Suite','Luxury suite for extended stays',NULL,1000.00,3500.00,4,1,'2025-05-26 08:58:39','2025-05-26 08:58:39'),(4,'Family Room','Family Stays',100.00,NULL,NULL,4,0,'2025-06-05 07:28:00','2025-06-05 07:28:00'),(5,'Two-Bedroom Suite','Features a dedicated workspace or boardroom, catering to business travelers',NULL,1500.00,5500.00,6,1,NULL,NULL),(6,'Executive Suite','Located on the top floor of a hotel, often offering panoramic views and exceptional luxury',NULL,3000.00,11000.00,8,1,NULL,NULL),(7,'Residential Suite','Luxury suite for extended stays',NULL,1000.00,3500.00,4,1,'2025-06-07 15:10:17','2025-06-07 15:10:17');
/*!40000 ALTER TABLE `room_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` bigint unsigned NOT NULL,
  `room_type_id` bigint unsigned NOT NULL,
  `room_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('available','occupied','maintenance') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rooms_branch_id_foreign` (`branch_id`),
  KEY `rooms_room_type_id_foreign` (`room_type_id`),
  CONSTRAINT `rooms_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rooms_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,1,1,'101','available','2025-05-26 08:58:39','2025-06-04 16:00:00'),(2,1,1,'102','available','2025-05-26 08:58:39','2025-06-04 03:38:44'),(3,1,1,'103','available','2025-05-26 08:58:40','2025-06-01 10:54:52'),(4,1,1,'104','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(5,1,1,'105','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(6,1,1,'106','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(7,1,1,'107','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(8,1,1,'108','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(9,1,1,'109','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(10,1,1,'110','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(11,1,1,'201','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(12,1,1,'202','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(13,1,1,'203','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(14,1,1,'204','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(15,1,1,'205','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(16,1,1,'206','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(17,1,1,'207','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(18,1,1,'208','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(19,1,1,'209','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(20,1,1,'210','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(21,1,1,'301','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(22,1,1,'302','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(23,1,1,'303','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(24,1,1,'304','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(25,1,1,'305','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(26,1,1,'306','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(27,1,1,'307','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(28,1,1,'308','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(29,1,1,'309','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(30,1,1,'310','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(31,1,2,'401','available','2025-05-26 08:58:40','2025-06-07 06:03:01'),(32,1,2,'402','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(33,1,2,'403','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(34,1,2,'404','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(35,1,2,'405','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(36,1,2,'406','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(37,1,2,'407','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(38,1,2,'408','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(39,1,2,'409','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(40,1,2,'410','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(41,1,2,'501','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(42,1,2,'502','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(43,1,2,'503','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(44,1,2,'504','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(45,1,2,'505','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(46,1,2,'506','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(47,1,2,'507','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(48,1,2,'508','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(49,1,2,'509','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(50,1,2,'510','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(51,1,3,'61','occupied','2025-05-26 08:58:40','2025-06-04 16:12:00'),(52,1,3,'62','occupied','2025-05-26 08:58:40','2025-06-04 16:12:10'),(53,1,3,'63','available','2025-05-26 08:58:40','2025-05-28 11:13:17'),(54,2,1,'101','occupied','2025-05-26 08:58:40','2025-06-07 21:08:09'),(55,2,1,'102','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(56,2,1,'103','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(57,2,1,'104','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(58,2,1,'105','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(59,2,1,'106','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(60,2,1,'107','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(61,2,1,'108','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(62,2,1,'109','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(63,2,1,'110','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(64,2,1,'201','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(65,2,1,'202','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(66,2,1,'203','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(67,2,1,'204','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(68,2,1,'205','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(69,2,1,'206','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(70,2,1,'207','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(71,2,1,'208','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(72,2,1,'209','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(73,2,1,'210','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(74,2,1,'301','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(75,2,1,'302','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(76,2,1,'303','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(77,2,1,'304','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(78,2,1,'305','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(79,2,1,'306','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(80,2,1,'307','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(81,2,1,'308','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(82,2,1,'309','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(83,2,1,'310','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(84,2,2,'401','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(85,2,2,'402','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(86,2,2,'403','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(87,2,2,'404','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(88,2,2,'405','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(89,2,2,'406','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(90,2,2,'407','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(91,2,2,'408','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(92,2,2,'409','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(93,2,2,'410','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(94,2,2,'501','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(95,2,2,'502','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(96,2,2,'503','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(97,2,2,'504','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(98,2,2,'505','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(99,2,2,'506','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(100,2,2,'507','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(101,2,2,'508','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(102,2,2,'509','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(103,2,2,'510','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(104,2,3,'61','occupied','2025-05-26 08:58:40','2025-05-28 19:20:32'),(105,2,3,'62','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(106,2,3,'63','available','2025-05-26 08:58:40','2025-05-26 08:58:40'),(116,2,5,'71','available',NULL,NULL),(117,2,5,'72','available',NULL,NULL),(118,2,5,'73','available',NULL,NULL),(119,2,6,'81','available',NULL,NULL),(130,1,5,'71','available',NULL,NULL),(131,1,5,'72','available',NULL,NULL),(132,1,5,'73','available',NULL,NULL),(133,1,6,'81','available',NULL,NULL),(134,1,4,'301','available',NULL,'2025-06-07 18:31:27'),(135,1,4,'302','available',NULL,NULL),(136,1,4,'303','available',NULL,NULL),(137,1,4,'304','available',NULL,NULL),(138,1,4,'305','available',NULL,NULL),(139,1,4,'306','available',NULL,NULL),(140,1,4,'307','available',NULL,NULL),(141,1,4,'308','available',NULL,NULL),(142,1,4,'309','available',NULL,NULL),(143,1,4,'310','available',NULL,NULL),(144,2,4,'301','available',NULL,NULL),(145,2,4,'302','available',NULL,NULL),(146,2,4,'303','available',NULL,NULL),(147,2,4,'304','available',NULL,NULL),(148,2,4,'305','available',NULL,NULL),(149,2,4,'306','available',NULL,NULL),(150,2,4,'307','available',NULL,NULL),(151,2,4,'308','available',NULL,NULL),(152,2,4,'309','available',NULL,NULL),(153,2,4,'310','available',NULL,NULL),(154,3,1,'101','available',NULL,NULL),(155,3,1,'102','available',NULL,NULL),(156,3,1,'103','available',NULL,NULL),(157,3,1,'104','available',NULL,NULL),(158,3,1,'105','available',NULL,NULL),(159,3,1,'106','available',NULL,NULL),(160,3,1,'107','available',NULL,NULL),(161,3,1,'108','available',NULL,NULL),(162,3,1,'109','available',NULL,NULL),(163,3,1,'110','available',NULL,NULL),(164,3,1,'111','available',NULL,NULL),(165,3,1,'112','available',NULL,NULL),(166,3,1,'113','available',NULL,NULL),(167,3,1,'114','available',NULL,NULL),(168,3,1,'115','available',NULL,NULL),(169,3,1,'116','available',NULL,NULL),(170,3,1,'117','available',NULL,NULL),(171,3,1,'118','available',NULL,NULL),(172,3,1,'119','available',NULL,NULL),(173,3,1,'120','available',NULL,NULL),(174,3,1,'121','available',NULL,NULL),(175,3,1,'122','available',NULL,NULL),(176,3,1,'123','available',NULL,NULL),(177,3,1,'124','available',NULL,NULL),(178,3,1,'125','available',NULL,NULL),(179,3,1,'126','available',NULL,NULL),(180,3,1,'127','available',NULL,NULL),(181,3,1,'128','available',NULL,NULL),(182,3,1,'129','available',NULL,NULL),(183,3,1,'130','available',NULL,NULL),(184,3,2,'201','available',NULL,NULL),(185,3,2,'202','available',NULL,NULL),(186,3,2,'203','available',NULL,NULL),(187,3,2,'204','available',NULL,NULL),(188,3,2,'205','available',NULL,NULL),(189,3,2,'206','available',NULL,NULL),(190,3,2,'207','available',NULL,NULL),(191,3,2,'208','available',NULL,NULL),(192,3,2,'209','available',NULL,NULL),(193,3,2,'210','available',NULL,NULL),(194,3,2,'211','available',NULL,NULL),(195,3,2,'212','available',NULL,NULL),(196,3,2,'213','available',NULL,NULL),(197,3,2,'214','available',NULL,NULL),(198,3,2,'215','available',NULL,NULL),(199,3,2,'216','available',NULL,NULL),(200,3,2,'217','available',NULL,NULL),(201,3,2,'218','available',NULL,NULL),(202,3,2,'219','available',NULL,NULL),(203,3,2,'220','available',NULL,NULL),(204,3,4,'301','available',NULL,NULL),(205,3,4,'302','available',NULL,NULL),(206,3,4,'303','available',NULL,NULL),(207,3,4,'304','available',NULL,NULL),(208,3,4,'305','available',NULL,NULL),(209,3,4,'306','available',NULL,NULL),(210,3,4,'307','available',NULL,NULL),(211,3,4,'308','available',NULL,NULL),(212,3,4,'309','available',NULL,NULL),(213,3,4,'310','available',NULL,NULL),(214,3,3,'61','available',NULL,NULL),(215,3,3,'62','available',NULL,NULL),(216,3,3,'63','available',NULL,NULL),(217,3,5,'71','available',NULL,NULL),(218,3,5,'72','available',NULL,NULL),(219,3,5,'73','available',NULL,NULL),(220,3,6,'81','available',NULL,NULL);
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `travel_agencies`
--

DROP TABLE IF EXISTS `travel_agencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `travel_agencies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `travel_agencies`
--

LOCK TABLES `travel_agencies` WRITE;
/*!40000 ALTER TABLE `travel_agencies` DISABLE KEYS */;
INSERT INTO `travel_agencies` VALUES (1,'TravelEasy','cssithu02@gmail.com','0119876543',1,'2025-05-26 08:58:40','2025-05-26 08:58:40'),(2,'GoBeyond','akilanilupul3@gmail.com','0114566435',1,NULL,NULL),(3,'Global Travels','namal@globaltravels.com','123-456-7890',1,'2025-06-08 02:25:56','2025-06-08 02:25:56'),(4,'Sunrise Tours','info@sunrisetours.com','987-654-3210',1,'2025-06-08 02:25:56','2025-06-08 02:25:56'),(5,'Adventure Seekers','hello@adventureseekers.com','555-123-4567',0,'2025-06-08 02:25:56','2025-06-08 02:25:56'),(6,'Island Explorers','support@islandexplorers.com','222-333-4444',1,'2025-06-08 02:25:56','2025-06-08 02:25:56'),(7,'Royal Vacations','sales@royalvacations.com','888-777-6666',0,'2025-06-08 02:25:56','2025-06-08 02:25:56');
/*!40000 ALTER TABLE `travel_agencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `travel_agency_bookings`
--

DROP TABLE IF EXISTS `travel_agency_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `travel_agency_bookings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `travel_agency_id` bigint unsigned NOT NULL,
  `reservation_id` bigint unsigned NOT NULL,
  `discount_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `quotation_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `travel_agency_bookings_travel_agency_id_foreign` (`travel_agency_id`),
  KEY `travel_agency_bookings_reservation_id_foreign` (`reservation_id`),
  CONSTRAINT `travel_agency_bookings_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `travel_agency_bookings_travel_agency_id_foreign` FOREIGN KEY (`travel_agency_id`) REFERENCES `travel_agencies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `travel_agency_bookings`
--

LOCK TABLES `travel_agency_bookings` WRITE;
/*!40000 ALTER TABLE `travel_agency_bookings` DISABLE KEYS */;
INSERT INTO `travel_agency_bookings` VALUES (2,1,21,3.00,97.00,'2025-05-28 16:42:44','2025-05-28 16:42:44'),(3,1,22,3.00,97.00,'2025-05-28 16:42:44','2025-05-28 16:42:44'),(4,1,23,8.00,811.90,'2025-05-28 16:44:11','2025-05-28 16:44:11'),(8,1,44,15.00,524.88,'2025-06-04 16:08:47','2025-06-04 16:08:47'),(9,1,45,15.00,524.88,'2025-06-04 16:08:47','2025-06-04 16:08:47'),(10,1,46,15.00,524.88,'2025-06-04 16:08:47','2025-06-04 16:08:47'),(11,1,47,15.00,524.88,'2025-06-04 16:08:47','2025-06-04 16:08:47');
/*!40000 ALTER TABLE `travel_agency_bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('customer','clerk','manager','admin') COLLATE utf8mb4_unicode_ci DEFAULT 'customer',
  `branch_id` bigint unsigned DEFAULT NULL,
  `nationality` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_branch_id_foreign` (`branch_id`),
  CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Customer One','customer@hotel.com','$2y$12$73cfHNSWzKIw8WD9gWBAuuy6S3cNpQCrCxJUT09QS.G54etABPMb6','customer',NULL,'Sri Lankan','0771234567','2025-05-26 08:58:39','2025-05-26 08:58:39'),(2,'Clerk Colombo','clerk@hotel.com','$2y$12$RogDTvT7o1vqcEhwgSSMlehMoq42eChYE62jiuTqTXB5FQEC0gOO2','clerk',1,'Sri Lankan','0771234568','2025-05-26 08:58:39','2025-05-26 08:58:39'),(3,'Manager Colombo','manager@hotel.com','$2y$12$kDctguvbRMSbD94Z2iFrFeHHBa9..4rYoj.kJ7LSFbgcOF8Xbb1lG','manager',1,'Sri Lankan','0771234569','2025-05-26 08:58:39','2025-05-26 08:58:39'),(4,'Clerk Kandy','clerkKandy@hotel.com','$2y$12$xaQ5OzmPKjkp5L8Lf5/l8eA6mNPfWHJj2WNHCGLd9QcrxcOo1Qjp6','clerk',2,'Sri Lankan','0771234234','2025-05-26 08:58:39','2025-05-26 08:58:39'),(5,'Manager Kandy','managerKandy@hotel.com','$2y$12$PCFmDwaiGB9F.IsHzpjL1Ot9KWb9umiIQMuB6AzBG/vJUUIQZSpNS','manager',2,'Sri Lankan','0711234568','2025-05-26 08:58:39','2025-05-26 08:58:39'),(6,'Chamathka Sithumini','cssithu02@gmail.com','$2y$12$umnveOOlrd58l13jPi2Y1eoNLGXeLoWNHNTuOMP5JWwWVITh8IYpO','customer',NULL,'Sri Lanka','+94','2025-05-26 09:02:39','2025-06-04 14:31:37'),(7,'Akila Nilupul','akilanilupul3@gmail.com','$2y$12$JLsqFdzDeoN2/XfcFxhWMOCucsb4fddzHzB/KMEATA/BKeYLz8gaW','customer',NULL,'Sri Lanka','0767479233','2025-05-28 19:16:02','2025-05-28 19:16:02'),(8,'Namal Rajapaksha','namal@gmail.com','$2y$12$.0Q9FC3uMLmlxn1aa4TkHusvUq0WjEPPDHKvwc6dfOicZYXa2rmxS','customer',NULL,'United States','+1 555282233','2025-06-04 14:27:20','2025-06-04 14:27:20'),(9,'Srimal Nimsara','srimal@gmail.com','$2y$12$czkQCOrhNYkbFSSfbxcbMe.7fw2Hnk7Vd.PJ7JAzZqq.Y36IUSzbO','customer',NULL,'Sri Lanka','+94 7735267881','2025-06-04 15:00:16','2025-06-04 15:00:16'),(11,'Nadun Jeewantha','nadunjt@gmail.com','$2y$12$tNjHf4tfvA5jOkC7bM8SSud4HZwNhaaIVduJ/vKk8.X2dZcWJfGB6','customer',NULL,'Sri Lanka','+94 772637825','2025-06-06 10:17:44','2025-06-06 10:17:44'),(12,'Manager Galle','managerGalle@hotel.com','$2y$12$kDctguvbRMSbD94Z2iFrFeHHBa9..4rYoj.kJ7LSFbgcOF8Xbb1lG','manager',3,'Sri Lanka','0771234568',NULL,NULL),(13,'Clerk Galle','clerkGalle@hotel.com','$2y$12$RogDTvT7o1vqcEhwgSSMlehMoq42eChYE62jiuTqTXB5FQEC0gOO2','clerk',3,'Sri Lanka','0771223568',NULL,NULL),(15,'Admin User','admin@hotel.com','$2y$12$tdog1BdnvfKGYK.Zzy3.S./FdRXVSijsTMxYOMc7VnF3TWcCAZ6Ty','admin',NULL,NULL,NULL,'2025-06-07 15:16:16','2025-06-07 15:16:16'),(18,'akila','akila@hotel','$2y$12$VFO.UQ3H4zu9yg1wibAWKujTFQ0bP/rfSBL6B.93ek/BjwyGOOHMC','clerk',1,NULL,NULL,'2025-06-07 18:01:30','2025-06-07 18:01:30'),(19,'Kumara','kumara@hotel.com','$2y$12$gKbQ8OnfdtV3CNSBNQz4IueJ91nts8Jf.t2wHr7fxnYLWXMAU5Ume','manager',2,NULL,NULL,'2025-06-07 18:03:13','2025-06-07 18:03:13');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-08  8:15:49
