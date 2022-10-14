-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: lottogame
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
-- Table structure for table `roll_events`
--

DROP TABLE IF EXISTS `roll_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roll_events` (
  `roll_event_id` int NOT NULL AUTO_INCREMENT,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`roll_event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roll_events`
--

LOCK TABLES `roll_events` WRITE;
/*!40000 ALTER TABLE `roll_events` DISABLE KEYS */;
INSERT INTO `roll_events` VALUES (1,'2022-10-14 07:50:33'),(2,'2022-10-14 07:56:10'),(3,'2022-10-14 07:56:57'),(4,'2022-10-14 08:13:56'),(5,'2022-10-14 08:16:24'),(6,'2022-10-14 08:20:28');
/*!40000 ALTER TABLE `roll_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rolls`
--

DROP TABLE IF EXISTS `rolls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rolls` (
  `roll_id` int NOT NULL AUTO_INCREMENT,
  `rolled_digit` int NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `roll_event_id` int NOT NULL,
  PRIMARY KEY (`roll_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rolls`
--

LOCK TABLES `rolls` WRITE;
/*!40000 ALTER TABLE `rolls` DISABLE KEYS */;
INSERT INTO `rolls` VALUES (1,9,'2022-10-14 07:50:51',1),(2,11,'2022-10-14 07:50:52',1),(3,10,'2022-10-14 07:50:53',1),(4,15,'2022-10-14 07:50:55',1),(5,13,'2022-10-14 07:50:56',1),(6,4,'2022-10-14 07:56:11',2),(7,7,'2022-10-14 07:56:11',2),(8,14,'2022-10-14 07:56:12',2),(9,12,'2022-10-14 07:56:12',2),(10,13,'2022-10-14 07:56:12',2),(11,11,'2022-10-14 07:56:58',3),(12,4,'2022-10-14 07:56:58',3),(13,7,'2022-10-14 07:56:59',3),(14,13,'2022-10-14 07:56:59',3),(15,2,'2022-10-14 07:56:59',3),(16,8,'2022-10-14 08:13:57',4),(17,15,'2022-10-14 08:13:57',4),(18,4,'2022-10-14 08:13:58',4),(19,6,'2022-10-14 08:13:58',4),(20,12,'2022-10-14 08:13:58',4),(21,15,'2022-10-14 08:16:25',5),(22,12,'2022-10-14 08:16:25',5),(23,9,'2022-10-14 08:16:26',5),(24,14,'2022-10-14 08:16:26',5),(25,3,'2022-10-14 08:16:26',5),(26,7,'2022-10-14 08:20:29',6),(27,2,'2022-10-14 08:20:29',6),(28,3,'2022-10-14 08:20:29',6),(29,15,'2022-10-14 08:20:30',6),(30,11,'2022-10-14 08:20:30',6);
/*!40000 ALTER TABLE `rolls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `ticket_id` int NOT NULL AUTO_INCREMENT,
  `first_digit` int NOT NULL,
  `second_digit` int NOT NULL,
  `third_digit` int NOT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_valid` bit(1) NOT NULL DEFAULT b'1',
  `matches` int DEFAULT NULL,
  `roll_event_id` int DEFAULT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (1,3,6,12,'2022-10-14 07:50:13',_binary '\0',NULL,1),(2,7,6,9,'2022-10-14 07:56:06',_binary '\0',1,2),(3,6,7,11,'2022-10-14 07:56:42',_binary '\0',2,3),(4,1,2,3,'2022-10-14 07:56:45',_binary '\0',1,3),(5,14,3,6,'2022-10-14 07:56:49',_binary '\0',NULL,3),(6,6,4,8,'2022-10-14 08:13:43',_binary '\0',6,4),(7,4,7,12,'2022-10-14 08:13:45',_binary '\0',4,4),(8,1,2,3,'2022-10-14 08:13:49',_binary '\0',0,4),(9,15,10,3,'2022-10-14 08:13:53',_binary '\0',2,4),(10,6,8,7,'2022-10-14 08:20:20',_binary '\0',1,6);
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-14 16:34:07
