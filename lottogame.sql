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
-- Table structure for table `6_42_tickets`
--

DROP TABLE IF EXISTS `6_42_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `6_42_tickets` (
  `ticket_id` int NOT NULL AUTO_INCREMENT,
  `digit_1` int NOT NULL,
  `digit_2` int NOT NULL,
  `digit_3` int NOT NULL,
  `digit_4` int NOT NULL,
  `digit_5` int NOT NULL,
  `digit_6` int NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_valid` bit(1) NOT NULL DEFAULT b'1',
  `matched_digits` int DEFAULT NULL,
  `roll_event_id` int DEFAULT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `6_42_tickets`
--

LOCK TABLES `6_42_tickets` WRITE;
/*!40000 ALTER TABLE `6_42_tickets` DISABLE KEYS */;
INSERT INTO `6_42_tickets` VALUES (1,8,24,29,1,29,14,'2022-10-17 15:45:02',_binary '\0',3,1),(2,2,16,8,15,13,31,'2022-10-17 15:45:03',_binary '\0',1,1),(3,1,21,41,21,38,34,'2022-10-17 15:45:04',_binary '\0',2,1),(4,42,28,6,14,18,32,'2022-10-17 15:45:06',_binary '\0',1,1),(5,23,28,3,30,26,22,'2022-10-17 15:45:07',_binary '\0',1,1),(6,28,33,20,26,39,30,'2022-10-17 15:53:23',_binary '\0',1,2),(7,36,35,15,22,33,16,'2022-10-17 15:53:24',_binary '\0',1,2),(8,27,23,28,17,15,15,'2022-10-17 15:53:25',_binary '\0',1,2),(9,30,25,7,3,4,30,'2022-10-17 15:53:26',_binary '\0',0,2),(10,18,34,13,40,12,22,'2022-10-17 15:59:39',_binary '\0',1,3),(11,4,34,22,26,38,30,'2022-10-17 15:59:42',_binary '\0',0,3),(12,42,9,27,10,9,17,'2022-10-17 15:59:45',_binary '\0',1,3),(13,29,2,27,5,40,41,'2022-10-17 15:59:48',_binary '\0',2,3),(14,14,20,41,36,29,12,'2022-10-17 15:59:53',_binary '\0',3,3),(15,32,12,27,16,36,25,'2022-10-17 15:59:57',_binary '\0',3,3);
/*!40000 ALTER TABLE `6_42_tickets` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roll_events`
--

LOCK TABLES `roll_events` WRITE;
/*!40000 ALTER TABLE `roll_events` DISABLE KEYS */;
INSERT INTO `roll_events` VALUES (1,'2022-10-17 15:45:09'),(2,'2022-10-17 15:53:29'),(3,'2022-10-17 16:00:05');
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rolls`
--

LOCK TABLES `rolls` WRITE;
/*!40000 ALTER TABLE `rolls` DISABLE KEYS */;
INSERT INTO `rolls` VALUES (1,29,'2022-10-17 15:45:10',1),(2,24,'2022-10-17 15:45:11',1),(3,31,'2022-10-17 15:45:11',1),(4,21,'2022-10-17 15:45:12',1),(5,28,'2022-10-17 15:45:12',1),(6,33,'2022-10-17 15:45:13',1),(7,16,'2022-10-17 15:53:29',2),(8,27,'2022-10-17 15:53:30',2),(9,20,'2022-10-17 15:53:30',2),(10,2,'2022-10-17 15:53:30',2),(11,1,'2022-10-17 15:53:31',2),(12,21,'2022-10-17 15:53:31',2),(13,18,'2022-10-17 16:00:08',3),(14,25,'2022-10-17 16:00:11',3),(15,41,'2022-10-17 16:00:12',3),(16,36,'2022-10-17 16:00:14',3),(17,20,'2022-10-17 16:00:16',3),(18,27,'2022-10-17 16:00:17',3);
/*!40000 ALTER TABLE `rolls` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-18  0:03:14
