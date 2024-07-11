CREATE DATABASE IF NOT EXISTS my_db;

DROP TABLE IF EXISTS `call_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `call_details` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `call_id` int unsigned DEFAULT NULL,
  `date` datetime NOT NULL,
  `details` text NOT NULL,
  `hours` int NOT NULL,
  `minutes` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `call_id` (`call_id`),
  CONSTRAINT `call_details_ibfk_1` FOREIGN KEY (`call_id`) REFERENCES `call_headers` (`call_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `call_headers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `call_headers` (
  `call_id` int unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `it_person` varchar(32) NOT NULL,
  `user_name` varchar(32) NOT NULL,
  `subject` varchar(64) NOT NULL,
  `details` text,
  `total_hours` int DEFAULT '0',
  `total_minutes` int DEFAULT '0',
  `status` varchar(255) DEFAULT NULL COMMENT 'New, In Progress, Completed',
  PRIMARY KEY (`call_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;