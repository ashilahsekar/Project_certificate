-- MariaDB dump 10.19-11.1.2-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: certificate
-- ------------------------------------------------------
-- Server version	11.1.2-MariaDB-1:11.1.2+maria~ubu2204

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `certificate_fields`
--

DROP TABLE IF EXISTS `certificate_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `certificate_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `certificate_id` int(11) NOT NULL,
  `field_name` varchar(100) NOT NULL,
  `field_value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `certificate_id` (`certificate_id`),
  CONSTRAINT `certificate_fields_ibfk_1` FOREIGN KEY (`certificate_id`) REFERENCES `certificates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certificate_fields`
--

LOCK TABLES `certificate_fields` WRITE;
/*!40000 ALTER TABLE `certificate_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `certificate_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certificates`
--

DROP TABLE IF EXISTS `certificates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `certificates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `certificate_code` varchar(100) NOT NULL,
  `issued_at` timestamp NULL DEFAULT current_timestamp(),
  `certificate_template` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `certificate_code` (`certificate_code`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `courses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certificates`
--

LOCK TABLES `certificates` WRITE;
/*!40000 ALTER TABLE `certificates` DISABLE KEYS */;
/*!40000 ALTER TABLE `certificates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `event_description` text DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `organizer` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES
(1,'belajar PHP dasar','lreom lorem lraofnceac','2024-10-31','Ibnu','2024-10-30 16:23:05');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reset_password`
--

DROP TABLE IF EXISTS `reset_password`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reset_password` (
  `id` int(11) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reset_password`
--

LOCK TABLES `reset_password` WRITE;
/*!40000 ALTER TABLE `reset_password` DISABLE KEYS */;
/*!40000 ALTER TABLE `reset_password` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nik` varchar(16) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('participant','admin') DEFAULT 'participant',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'3175062406070009','Chaeza Ibnu Akbar','ibnu235729@gmail.com','0859102628529','bdab5a4645b586e9c168ff965359ce44;968bcb95bf8c2198a3a2fc0add3ca25ca42610273a5e28bf7fa5e56a3c625582','admin','2024-10-30 15:23:06'),
(2,'125246347','tes','test@admin.com','325326463','6f7c00ee18caebb0d8615033308402ee;c6f3dfda09023540f892154c646aaa41797f29717a20a4000fe0cc96fe3b8412','participant','2024-10-30 16:03:32');
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

-- Dump completed on 2024-10-31  8:05:23
