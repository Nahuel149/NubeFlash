CREATE DATABASE  IF NOT EXISTS `lanube_api` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `lanube_api`;
-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: lanube_api
-- ------------------------------------------------------
-- Server version	8.0.34

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
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_log` (
  `activity_id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `action` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `delete_by` int DEFAULT NULL,
  PRIMARY KEY (`activity_id`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_log`
--

LOCK TABLES `activity_log` WRITE;
/*!40000 ALTER TABLE `activity_log` DISABLE KEYS */;
INSERT INTO `activity_log` VALUES (1,1,'LOGIN','User logged into the system','127.0.0.1','2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(2,1,'CREATE_ORDER','Created order #ORD-2024-001','127.0.0.1','2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(3,2,'LOGIN','User logged into the system','127.0.0.1','2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(4,2,'UPDATE_ORDER','Updated order status to SHIPPED','127.0.0.1','2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(5,3,'LOGIN','User logged into the system','127.0.0.1','2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(6,3,'CREATE_CUSTOMER','Created new customer account','127.0.0.1','2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(7,1,'PERMISSION_RESET','Full permissions reset and setup completed','127.0.0.1','2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(8,1,'UPDATE','Actualizó monto total en el pedido #ORD-2024-003','::1','2025-03-12 13:15:35','2025-03-13 01:15:35',NULL,NULL,NULL,NULL),(9,1,'VIEW_ORDER_REPORT','Viewed order reports','::1','2025-03-12 13:41:55','2025-03-13 01:41:55',NULL,NULL,NULL,NULL),(10,1,'VIEW_ORDER_REPORT','Viewed order reports','::1','2025-03-12 13:42:21','2025-03-13 01:42:21',NULL,NULL,NULL,NULL),(11,1,'VIEW_CUSTOMER_REPORT','Viewed customer reports','::1','2025-03-12 13:42:25','2025-03-13 01:42:25',NULL,NULL,NULL,NULL),(12,1,'VIEW_ORDER_REPORT','Viewed order reports','::1','2025-03-12 13:42:53','2025-03-13 01:42:53',NULL,NULL,NULL,NULL),(13,1,'VIEW_CUSTOMER_REPORT','Viewed customer reports','::1','2025-03-12 13:47:40','2025-03-13 01:47:40',NULL,NULL,NULL,NULL),(14,1,'VIEW_ORDER_REPORT','Viewed order reports','::1','2025-03-12 13:47:53','2025-03-13 01:47:53',NULL,NULL,NULL,NULL),(15,1,'VIEW_CUSTOMER_REPORT','Viewed customer reports','::1','2025-03-12 13:50:00','2025-03-13 01:50:00',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `activity_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configurations`
--

DROP TABLE IF EXISTS `configurations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `configurations` (
  `id_configuration` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `value` text COLLATE utf8mb4_general_ci,
  `key_id` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `input` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `required` tinyint NOT NULL DEFAULT '0',
  `icon` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ordering` int DEFAULT '0',
  `enabled` tinyint NOT NULL DEFAULT '1',
  `active` tinyint NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `delete_by` int DEFAULT NULL,
  PRIMARY KEY (`id_configuration`),
  UNIQUE KEY `key_id_unique` (`key_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configurations`
--

LOCK TABLES `configurations` WRITE;
/*!40000 ALTER TABLE `configurations` DISABLE KEYS */;
INSERT INTO `configurations` VALUES (1,'Email Remitente','nahuelbalsasbtta@gmail.com','email_remitente','email',1,'fa-envelope',1,1,1,'Email address used as sender for system emails','2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(2,'Email Soporte','support@lanube.com','email_soporte','email',1,'fa-envelope',2,1,1,'Support email address','2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(3,'Email Administrador','operaciones@d-unit.world','email_admin','email',1,'fa-envelope',3,1,1,'Administrator email for notifications','2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(4,'Email QA','qa@lanube.com','email_qa','email',1,'fa-envelope',4,1,1,'QA team email for testing','2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(5,'Nombre Sistema','La Nube','nombre_sistema','text',1,'fa-cloud',5,1,1,'System name displayed in emails and interface','2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(6,'URL Sistema','http://localhost:8000','url_sistema','text',1,'fa-link',6,1,1,'Base URL of the system','2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(7,'Captcha Site Key','6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI','captcha_site_key','text',1,'fa-shield-alt',7,1,1,'Google reCAPTCHA site key','2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(8,'Captcha Secret Key','6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe','captcha_secret_key','text',1,'fa-key',8,1,1,'Google reCAPTCHA secret key','2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `configurations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `country_id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(3) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `capital` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `province` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `area` decimal(10,2) DEFAULT NULL,
  `population` int DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`country_id`),
  UNIQUE KEY `code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'ARG','Argentina','Buenos Aires','Buenos Aires',2780400.00,45195774,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(2,'BRA','Brasil','Brasilia','Distrito Federal',8515770.00,214300000,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(3,'CHL','Chile','Santiago','Santiago',756102.00,19458000,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(4,'URY','Uruguay','Montevideo','Montevideo',176215.00,3473730,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(5,'PRY','Paraguay','Asunción','Asunción',406752.00,7132538,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(6,'PER','Perú','Lima','Lima',1285216.00,32971846,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(7,'COL','Colombia','Bogotá','Cundinamarca',1141748.00,51520000,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(8,'ECU','Ecuador','Quito','Pichincha',283561.00,17800000,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(9,'BOL','Bolivia','La Paz','La Paz',1098581.00,11800000,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(10,'VEN','Venezuela','Caracas','Distrito Capital',916445.00,28200000,1,'2025-03-13 00:49:45','2025-03-13 00:49:45');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_shipping_credentials`
--

DROP TABLE IF EXISTS `customer_shipping_credentials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_shipping_credentials` (
  `credential_id` int NOT NULL AUTO_INCREMENT,
  `store_order_id` int DEFAULT NULL,
  `customer_id` int NOT NULL,
  `code_postal` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country_code` varchar(3) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `province_code` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `postal_code` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `province` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`credential_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_shipping_credentials_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_shipping_credentials`
--

LOCK TABLES `customer_shipping_credentials` WRITE;
/*!40000 ALTER TABLE `customer_shipping_credentials` DISABLE KEYS */;
INSERT INTO `customer_shipping_credentials` VALUES (1,NULL,1,NULL,'ARG','BA','Buenos Aires','Av. Corrientes',1,'2025-03-13 00:49:45','2025-03-13 00:49:45','Av. Corrientes 1234','1000','Buenos Aires'),(2,NULL,1,NULL,'ARG','BA','Buenos Aires','Av. Santa Fe',1,'2025-03-13 00:49:45','2025-03-13 00:49:45','Av. Santa Fe 5678','1001','Buenos Aires'),(3,NULL,2,NULL,'ARG','BA','Buenos Aires','Av. Cabildo',1,'2025-03-13 00:49:45','2025-03-13 00:49:45','Av. Cabildo 2000','1002','Buenos Aires'),(4,NULL,3,NULL,'ARG','CBA','Córdoba','Av. Colón',1,'2025-03-13 00:49:45','2025-03-13 00:49:45','Av. Colón 1234','5000','Córdoba'),(5,NULL,4,NULL,'BRA','SP','São Paulo','Rua Augusta',1,'2025-03-13 00:49:45','2025-03-13 00:49:45','Rua Augusta 567','01000','São Paulo'),(6,NULL,4,NULL,'BRA','SP','São Paulo','Av. Paulista',1,'2025-03-13 00:49:45','2025-03-13 00:49:45','Av. Paulista 890','01310','São Paulo'),(7,NULL,5,NULL,'BRA','SP','São Paulo','Av. Brigadeiro',1,'2025-03-13 00:49:45','2025-03-13 00:49:45','Av. Brigadeiro 1500','01450','São Paulo'),(8,NULL,6,NULL,'BRA','RJ','Rio de Janeiro','Av. Atlântica',1,'2025-03-13 00:49:45','2025-03-13 00:49:45','Av. Atlântica 500','22010','Rio de Janeiro'),(9,NULL,7,NULL,'CHL','STG','Santiago','Av. Providencia',1,'2025-03-13 00:49:45','2025-03-13 00:49:45','Av. Providencia 789','7500000','Santiago'),(10,NULL,8,NULL,'CHL','STG','Santiago','Av. Las Condes',1,'2025-03-13 00:49:45','2025-03-13 00:49:45','Av. Las Condes 1234','7550000','Santiago'),(11,NULL,9,NULL,'URY','MVD','Montevideo','Av. 18 de Julio',1,'2025-03-13 00:49:45','2025-03-13 00:49:45','Av. 18 de Julio 456','11000','Montevideo'),(12,NULL,10,NULL,'URY','MVD','Montevideo','Av. Brasil',1,'2025-03-13 00:49:45','2025-03-13 00:49:45','Av. Brasil 789','11300','Montevideo'),(13,NULL,10,NULL,'URY','MVD','Montevideo','Rambla República',1,'2025-03-13 00:49:45','2025-03-13 00:49:45','Rambla República 1000','11500','Montevideo');
/*!40000 ALTER TABLE `customer_shipping_credentials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `surname` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `province` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `location` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `code_confirmation` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type_user_id` int DEFAULT NULL,
  `status_code_confirmation` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `postal_code` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country_id` int NOT NULL,
  `province_id` int DEFAULT NULL,
  `destination_id` int DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `delete_by` int DEFAULT NULL,
  `social_reason` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fiscal_identifier` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `person_contact` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `business_hours` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `email_unique` (`email`),
  KEY `customers_country_id_fk` (`country_id`),
  KEY `customers_province_id_fk` (`province_id`),
  KEY `customers_destination_id_fk` (`destination_id`),
  CONSTRAINT `customers_country_id_fk` FOREIGN KEY (`country_id`) REFERENCES `countries` (`country_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `customers_destination_id_fk` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`destination_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `customers_province_id_fk` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`province_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Empresa A',NULL,'cbfdac6008f9cab4083784cbd1874f76618d2a97','Av. Corrientes 1234',NULL,NULL,'+54911111111','contacto@empresaa.com',NULL,2,NULL,NULL,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL,'Empresa A S.A.','30123456789','Juan Pérez','Lun-Vie 9-18hs'),(2,'Comercial BA',NULL,'cbfdac6008f9cab4083784cbd1874f76618d2a97','Av. Santa Fe 4321',NULL,NULL,'+54911222222','ventas@comercialba.com',NULL,2,NULL,NULL,1,1,2,1,'2025-03-13 00:49:45','2025-03-12 13:02:59',NULL,NULL,1,NULL,'Comercial Buenos Aires SRL','309876543214','Pedro Gomez','Lun-Vie 8-20hs, Sab 9-13hs'),(3,'Distribuidora Córdoba',NULL,'cbfdac6008f9cab4083784cbd1874f76618d2a97','Av. Colón 1234',NULL,NULL,'+54351333333','ventas@distcordoba.com',NULL,3,NULL,NULL,1,2,5,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL,'Distribuidora Córdoba SA','30456789012','Ana Martinez','Lun-Vie 8:30-18hs'),(4,'Comercial B',NULL,'cbfdac6008f9cab4083784cbd1874f76618d2a97','Rua Augusta 567',NULL,NULL,'+55922222222','ventas@comercialb.com',NULL,2,NULL,NULL,2,5,12,0,'2025-03-13 00:49:45','2025-03-13 00:53:40',NULL,NULL,NULL,NULL,'Comercial B Ltda.','15789456320','Maria Silva','Lun-Sab 8-20hs'),(5,'Importadora SP',NULL,'cbfdac6008f9cab4083784cbd1874f76618d2a97','Av. Paulista 1000',NULL,NULL,'+55911444444','contato@importadorasp.com',NULL,2,NULL,NULL,2,5,13,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL,'Importadora São Paulo Ltda.','14725836901','João Santos','Seg-Sex 9-18hs'),(6,'Distribuidora Rio',NULL,'cbfdac6008f9cab4083784cbd1874f76618d2a97','Av. Atlântica 500',NULL,NULL,'+55921555555','vendas@distrio.com',NULL,3,NULL,NULL,2,6,15,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL,'Distribuidora Rio de Janeiro Ltda.','12369874510','Roberto Oliveira','Seg-Sab 8-19hs'),(7,'Distribuidora C',NULL,'cbfdac6008f9cab4083784cbd1874f76618d2a97','Av. Providencia 789',NULL,NULL,'+56933333333','pedidos@distribuidorac.com',NULL,3,NULL,NULL,3,9,19,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL,'Distribuidora C SpA','76951357852','Carlos González','Lun-Vie 8:30-17:30hs'),(8,'Comercial Santiago',NULL,'cbfdac6008f9cab4083784cbd1874f76618d2a97','Av. Las Condes 1234',NULL,NULL,'+56944444444','ventas@comercialsantiago.com',NULL,2,NULL,NULL,3,9,20,1,'2025-03-13 00:49:45','2025-03-12 13:20:48',NULL,NULL,1,NULL,'Comercial Santiago SpA','761472583691','Patricia Muñoz','Lun-Vie 9-18:30hs'),(9,'Importadora D',NULL,'cbfdac6008f9cab4083784cbd1874f76618d2a97','Av. 18 de Julio 456',NULL,NULL,'+59844444444','compras@importadorad.com',NULL,2,NULL,NULL,4,12,21,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL,'Importadora D E.I.R.L','20147258369','Ana Torres','Lun-Vie 9-19hs, Sab 9-13hs'),(10,'Distribuidora MVD',NULL,'cbfdac6008f9cab4083784cbd1874f76618d2a97','Av. Brasil 789',NULL,NULL,'+59855555555','ventas@distmvd.com',NULL,3,NULL,NULL,4,12,22,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL,'Distribuidora Montevideo S.A.','21987654321','Diego Rodriguez','Lun-Vie 9-18hs');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `destinations`
--

DROP TABLE IF EXISTS `destinations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `destinations` (
  `destination_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `province_id` int NOT NULL,
  `postal_code` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`destination_id`),
  UNIQUE KEY `postal_code_unique` (`postal_code`),
  KEY `destinations_ibfk_1` (`province_id`),
  CONSTRAINT `destinations_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`province_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `destinations`
--

LOCK TABLES `destinations` WRITE;
/*!40000 ALTER TABLE `destinations` DISABLE KEYS */;
INSERT INTO `destinations` VALUES (1,'Buenos Aires Centro',1,'1000',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(2,'Buenos Aires Norte',1,'1001',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(3,'Buenos Aires Sur',1,'1002',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(4,'La Plata Centro',1,'1900',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(5,'Córdoba Centro',2,'5000',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(6,'Córdoba Norte',2,'5001',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(7,'Villa Carlos Paz',2,'5152',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(8,'Rosario Centro',3,'2000',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(9,'Santa Fe Capital',3,'3000',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(10,'Mendoza Centro',4,'5500',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(11,'Godoy Cruz',4,'5501',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(12,'São Paulo Centro',5,'01000',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(13,'São Paulo Oeste',5,'05000',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(14,'Guarulhos',5,'07000',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(15,'Rio Centro',6,'20000',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(16,'Copacabana',6,'22000',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(17,'Niterói',6,'24000',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(18,'Santiago Centro',9,'8320000',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(19,'Providencia',9,'7500000',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(20,'Las Condes',9,'7550000',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(21,'Montevideo Centro',12,'11000',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(22,'Pocitos',12,'11300',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(23,'Carrasco',12,'11500',1,'2025-03-13 00:49:45','2025-03-13 00:49:45');
/*!40000 ALTER TABLE `destinations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_logs`
--

DROP TABLE IF EXISTS `email_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_logs` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `template_id` int DEFAULT NULL,
  `recipient` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `error_message` text COLLATE utf8mb4_general_ci,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `delete_by` int DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `template_id` (`template_id`),
  CONSTRAINT `email_logs_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `email_templates` (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_logs`
--

LOCK TABLES `email_logs` WRITE;
/*!40000 ALTER TABLE `email_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `email_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_templates` (
  `template_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `variables` text COLLATE utf8mb4_general_ci,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `delete_by` int DEFAULT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_templates`
--

LOCK TABLES `email_templates` WRITE;
/*!40000 ALTER TABLE `email_templates` DISABLE KEYS */;
INSERT INTO `email_templates` VALUES (1,'Customer Registration','Bienvenido a La Nube - Confirmación de registro','Estimado/a {customer_name},\n\nGracias por registrarse en La Nube. Su cuenta ha sido creada exitosamente.\n\nDetalles de su cuenta:\nEmail: {email}\nEmpresa: {enterprise}\n\nPuede acceder al sistema usando su email y contraseña.\n\nSaludos cordiales,\nEquipo de La Nube','{\"customer_name\":\"\",\"email\":\"\",\"enterprise\":\"\"}',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(2,'Admin Registration Notification','Nuevo registro de cliente','Se ha registrado un nuevo cliente en el sistema.\n\nDetalles:\nEmpresa: {enterprise}\nContacto: {customer_name}\nEmail: {email}\n\nPor favor, verifique la información y active los tokens correspondientes.','{\"customer_name\":\"\",\"email\":\"\",\"enterprise\":\"\"}',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `email_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs` (
  `id_faq` int NOT NULL AUTO_INCREMENT,
  `question` text COLLATE utf8mb4_general_ci NOT NULL,
  `answer` text COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order` int DEFAULT '0',
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_faq`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

LOCK TABLES `faqs` WRITE;
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
INSERT INTO `faqs` VALUES (1,'¿Cuál es el tiempo de entrega estándar?','El tiempo de entrega estándar es de 48 horas. Sin embargo, también ofrecemos un servicio express de 24 horas por un costo adicional.',NULL,0,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(2,'¿Qué áreas geográficas cubren?','Actualmente cubrimos toda el área metropolitana de Montevideo y zonas aledañas. Consulta nuestro mapa de cobertura para más detalles.',NULL,0,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(3,'¿Cómo puedo rastrear mi envío?','Puedes rastrear tu envío ingresando el número de seguimiento en nuestra plataforma web o aplicación móvil. También recibirás actualizaciones por email.',NULL,0,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(4,'¿Qué sucede si no hay nadie para recibir el paquete?','Si no hay nadie para recibir el paquete, dejaremos un aviso de visita. El destinatario tendrá 5 días corridos para recoger el envío en nuestro centro logístico.',NULL,0,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(5,'¿Cuál es el peso máximo permitido?','Aceptamos paquetes de hasta 40kg. Para envíos más pesados, contáctanos para una cotización especial.',NULL,0,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(6,'¿Cómo debo embalar mi paquete?','Recomendamos usar cajas resistentes, material de relleno para proteger el contenido y cinta adhesiva de calidad. El paquete debe estar bien sellado y etiquetado.',NULL,0,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(7,'¿Qué formas de pago aceptan?','Aceptamos tarjetas de crédito, débito, transferencias bancarias y pagos en efectivo. Para clientes corporativos ofrecemos crédito previa evaluación.',NULL,0,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(8,'¿Ofrecen seguro para los envíos?','Sí, todos nuestros envíos incluyen un seguro básico. También ofrecemos seguros adicionales para envíos de mayor valor.',NULL,0,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(9,'¿Cómo puedo contratar sus servicios?','Puedes registrarte en nuestra plataforma web, completar el formulario de registro y comenzar a utilizar nuestros servicios inmediatamente.',NULL,0,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(10,'¿Tienen servicio de almacenamiento?','Sí, ofrecemos servicios de almacenamiento en nuestras bodegas desde 10m² hasta 50m², con vigilancia 24/7 y control de inventario.',NULL,0,1,'2025-03-13 00:49:45','2025-03-13 00:49:45');
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups` (
  `id_group` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `delete_by` int DEFAULT NULL,
  PRIMARY KEY (`id_group`),
  UNIQUE KEY `name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'admin','Administrator',1,'2025-03-13 00:49:13','2025-03-13 00:49:13',NULL,NULL,NULL,NULL),(2,'admin.test','Administrator',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(3,'operator.test','System Operator',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(4,'manager.test','System Manager',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image_gallery`
--

DROP TABLE IF EXISTS `image_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `image_gallery` (
  `image_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `file_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order` int DEFAULT '0',
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `delete_by` int DEFAULT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image_gallery`
--

LOCK TABLES `image_gallery` WRITE;
/*!40000 ALTER TABLE `image_gallery` DISABLE KEYS */;
/*!40000 ALTER TABLE `image_gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login_attempts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `login` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `id_user` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `login_attempts_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
INSERT INTO `login_attempts` VALUES (1,'127.0.0.1','admin.test',1741794585,1),(2,'127.0.0.1','operator.test',1741794585,2),(3,'127.0.0.1','manager.test',1741794585,3),(4,'::1','admin',2025,1),(5,'::1','admin',2025,1),(6,'::1','admin',2025,1),(7,'::1','admin',2025,1),(8,'::1','admin',2025,1),(9,'::1','admin',2025,1);
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts_errors`
--

DROP TABLE IF EXISTS `login_attempts_errors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login_attempts_errors` (
  `id_attemp` int NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `login` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `delete_by` int DEFAULT NULL,
  PRIMARY KEY (`id_attemp`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `login_attempts_errors_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts_errors`
--

LOCK TABLES `login_attempts_errors` WRITE;
/*!40000 ALTER TABLE `login_attempts_errors` DISABLE KEYS */;
INSERT INTO `login_attempts_errors` VALUES (1,'127.0.0.1','wrong_user',1741794585,NULL,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(2,'127.0.0.1','invalid',1741794585,NULL,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(3,'127.0.0.1','admin',1741794585,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(4,'127.0.0.1','admin.test',1741794585,2,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(5,'127.0.0.1','operator.test',1741794585,3,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `login_attempts_errors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_errors`
--

DROP TABLE IF EXISTS `login_errors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login_errors` (
  `id_login` int NOT NULL AUTO_INCREMENT,
  `user` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_login`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_errors`
--

LOCK TABLES `login_errors` WRITE;
/*!40000 ALTER TABLE `login_errors` DISABLE KEYS */;
INSERT INTO `login_errors` VALUES (1,'failed_user1','wrong_pass123','2025-03-13 00:49:45','192.168.1.100'),(2,'invalid_admin','incorrect456','2025-03-13 00:49:45','192.168.1.101'),(3,'wrong_login','test789','2025-03-13 00:49:45','192.168.1.102'),(4,'blocked_user','blocked123','2025-03-13 00:49:45','192.168.1.103'),(5,'unknown_user','unknown456','2025-03-13 00:49:45','192.168.1.104');
/*!40000 ALTER TABLE `login_errors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id_menu` int NOT NULL AUTO_INCREMENT,
  `description` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int DEFAULT '1',
  `parent` int DEFAULT '0',
  `iconpath` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `dashboard` tinyint NOT NULL DEFAULT '0',
  `order` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `delete_by` int DEFAULT NULL,
  PRIMARY KEY (`id_menu`),
  KEY `parent` (`parent`),
  CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menus` (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'Root','#',1,NULL,'fas fa-sitemap',1,0,0,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(2,'Customer Management','ecommerce/customers',1,1,'fas fa-users',1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(3,'Order Management','ecommerce/orders',1,1,'fas fa-shopping-cart',1,1,2,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(4,'Tariff Management','ecommerce/tariff',1,1,'fas fa-dollar-sign',1,1,3,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(5,'Location Management','ecommerce/locations',1,1,'fas fa-map-marker-alt',1,1,4,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(6,'User Management','backend/users',1,1,'fas fa-user-shield',1,1,5,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(7,'System Configuration','backend/configuraciones',1,1,'fas fa-cogs',1,1,6,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(8,'Reports','backend/reports',1,1,'fas fa-chart-bar',1,1,7,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(9,'Authentication','backend/auth',1,1,'fas fa-lock',1,1,8,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(10,'Other Utilities','backend/utilities',1,1,'fas fa-tools',1,1,9,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(11,'List Customers','ecommerce/customers',1,2,'fas fa-list',1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(12,'Add Customer','ecommerce/customers/add',1,2,'fas fa-user-plus',1,1,2,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(13,'Edit Customer','ecommerce/customers/edit',1,2,'fas fa-edit',1,1,3,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(14,'Customer Tokens','ecommerce/customers/tokens',1,2,'fas fa-key',1,1,4,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(15,'Generate Token','ecommerce/customers/generateToken',1,2,'fas fa-plus-circle',1,1,5,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(16,'Revoke Token','ecommerce/customers/revokeToken',1,2,'fas fa-minus-circle',1,1,6,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(17,'List Orders','ecommerce/orders',1,3,'fas fa-list',1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(18,'View Order','ecommerce/orders/view',1,3,'fas fa-eye',1,1,2,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(19,'Edit Order','ecommerce/orders/edit',1,3,'fas fa-edit',1,1,3,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(20,'Update Status','ecommerce/orders/status',1,3,'fas fa-sync',1,1,4,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(21,'List Tariffs','ecommerce/tariff',1,4,'fas fa-list',1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(22,'Add Tariff','ecommerce/tariff/add',1,4,'fas fa-plus',1,1,2,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(23,'Edit Tariff','ecommerce/tariff/edit',1,4,'fas fa-edit',1,1,3,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(24,'Countries','ecommerce/countries',1,5,'fas fa-globe',1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(25,'Provinces','ecommerce/provinces',1,5,'fas fa-map',1,1,2,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(26,'Destinations','ecommerce/destinations',1,5,'fas fa-location-arrow',1,1,3,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(27,'List Users','backend/users',1,6,'fas fa-list',1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(28,'Add User','backend/users/add',1,6,'fas fa-user-plus',1,1,2,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(29,'Edit User','backend/users/edit',1,6,'fas fa-user-edit',1,1,3,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(30,'Change Password','backend/users/change_password',1,6,'fas fa-key',1,1,4,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(31,'View Configurations','backend/configuraciones',1,7,'fas fa-list',1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(32,'Edit Configuration','backend/configuraciones/edit',1,7,'fas fa-edit',1,1,2,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(33,'Order Reports','backend/reports/orders',1,8,'fas fa-file-alt',1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(34,'Customer Reports','backend/reports/customers',1,8,'fas fa-users',1,1,2,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(35,'Activity Logs','backend/reports/activity',1,8,'fas fa-history',1,1,3,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(36,'Login','backend/auth/login',1,9,'fas fa-sign-in-alt',1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(37,'Logout','backend/auth/logout',1,9,'fas fa-sign-out-alt',1,1,2,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(38,'Forgot Password','backend/auth/forgot_password',1,9,'fas fa-unlock',1,1,3,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(39,'Activity Logs','backend/auditoria',1,10,'fas fa-clipboard-list',1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(40,'System Logs','backend/logs',1,10,'fas fa-file-alt',1,1,2,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(41,'Database Backup','backend/backup',1,10,'fas fa-database',1,1,3,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opciones_variables`
--

DROP TABLE IF EXISTS `opciones_variables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `opciones_variables` (
  `opcion_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `value` text COLLATE utf8mb4_general_ci,
  `description` text COLLATE utf8mb4_general_ci,
  `order` int DEFAULT '0',
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `delete_by` int DEFAULT NULL,
  PRIMARY KEY (`opcion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opciones_variables`
--

LOCK TABLES `opciones_variables` WRITE;
/*!40000 ALTER TABLE `opciones_variables` DISABLE KEYS */;
/*!40000 ALTER TABLE `opciones_variables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `order_item_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `delete_by` int DEFAULT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,1,1,130.00,130.00,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(2,2,2,2,77.50,155.00,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(3,3,3,1,200.00,200.00,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(4,4,4,3,120.00,360.00,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `tariff_id` int NOT NULL,
  `status_id` int NOT NULL,
  `order_number` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `tracking_number` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `items` text COLLATE utf8mb4_general_ci,
  `client` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shipping_data` text COLLATE utf8mb4_general_ci,
  `postal_code` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `volume` decimal(10,3) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_number_unique` (`order_number`),
  KEY `customer_id` (`customer_id`),
  KEY `tariff_id` (`tariff_id`),
  KEY `status_id` (`status_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`tariff_id`) REFERENCES `tariff` (`tariff_id`),
  CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,1,1,'ORD-2024-001',130.00,'TRK001','{\"items\":[{\"name\":\"Product 1\",\"quantity\":1}]}','Empresa A','Pedido 1','{\"address\":\"Av. Corrientes 1234\",\"city\":\"Buenos Aires\"}','1000',2.00,0.016,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(2,2,3,2,'ORD-2024-002',155.00,'TRK002','{\"items\":[{\"name\":\"Product 2\",\"quantity\":2}]}','Comercial B','Pedido 2','{\"address\":\"Rua Augusta 567\",\"city\":\"São Paulo\"}','01000',5.00,0.036,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(3,3,5,3,'ORD-2024-003',222.00,'TRK00366','{\"items\":[{\"name\":\"Product 3\",\"quantity\":1}]}','Distribuidora C','Pedido 3','{\"address\":\"Av. Providencia 789\",\"city\":\"Santiago\"}','1000',15.00,0.360,1,'2025-03-13 00:49:45','2025-03-13 01:31:06'),(4,2,7,4,'ORD-2024-004',360.00,'TRK0045','{\"items\":[{\"name\":\"Product 4\",\"quantity\":3}]}','Importadora D','Pedido 4','{\"address\":\"Av. 18 de Julio 456\",\"city\":\"Montevideo\"}','1000',25.00,0.360,1,'2025-03-13 00:49:45','2025-03-13 01:03:15'),(5,1,9,1,'ORD-20250312-a10e9d8c',0.00,NULL,'[{\"long\":1,\"high\":0.5,\"width\":1,\"weight\":10,\"qty\":1}]','Empresa CE','Av. Corrientes 1234','{\"store\":{\"name\":\"Test Store\"},\"email\":\"contacto@empresaa.com\",\"province\":\"Buenos Aires\",\"city\":\"Buenos Aires\",\"address\":\"Av. Corrientes 1234\",\"telephone\":\"+54933333333\"}','1000',10.00,0.500,1,'2025-03-13 01:45:04','2025-03-13 01:45:04');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id_permission` int NOT NULL AUTO_INCREMENT,
  `id_group` int NOT NULL,
  `id_menu` int NOT NULL,
  `read` tinyint NOT NULL DEFAULT '0',
  `insert` tinyint NOT NULL DEFAULT '0',
  `update` tinyint NOT NULL DEFAULT '0',
  `delete` tinyint NOT NULL DEFAULT '0',
  `export` tinyint NOT NULL DEFAULT '0',
  `print` tinyint NOT NULL DEFAULT '0',
  `invoice` tinyint NOT NULL DEFAULT '0',
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `delete_by` int DEFAULT NULL,
  PRIMARY KEY (`id_permission`),
  KEY `id_group` (`id_group`),
  KEY `id_menu` (`id_menu`),
  CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id_group`),
  CONSTRAINT `permissions_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menus` (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,1,1,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(2,1,2,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(3,1,3,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(4,1,4,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(5,1,5,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(6,1,6,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(7,1,7,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(8,1,8,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(9,1,9,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(10,1,10,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(11,1,11,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(12,1,12,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(13,1,13,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(14,1,14,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(15,1,15,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(16,1,16,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(17,1,17,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(18,1,18,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(19,1,19,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(20,1,20,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(21,1,21,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(22,1,22,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(23,1,23,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(24,1,24,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(25,1,25,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(26,1,26,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(27,1,27,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(28,1,28,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(29,1,29,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(30,1,30,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(31,1,31,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(32,1,32,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(33,1,33,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(34,1,34,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(35,1,35,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(36,1,36,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(37,1,37,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(38,1,38,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(39,1,39,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(40,1,40,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(41,1,41,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(64,1,39,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(65,1,40,1,1,1,1,1,1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_categories`
--

DROP TABLE IF EXISTS `product_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `parent_id` int DEFAULT NULL,
  `order` int DEFAULT '0',
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `delete_by` int DEFAULT NULL,
  PRIMARY KEY (`category_id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `product_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `product_categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_categories`
--

LOCK TABLES `product_categories` WRITE;
/*!40000 ALTER TABLE `product_categories` DISABLE KEYS */;
INSERT INTO `product_categories` VALUES (1,'Electronics','Electronic devices and accessories',NULL,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(2,'Clothing','Apparel and fashion items',NULL,2,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(3,'Home & Garden','Home improvement and garden supplies',NULL,3,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(4,'Books','Books and publications',NULL,4,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(5,'Smartphones','Mobile phones and accessories',1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(6,'Laptops','Portable computers',1,2,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(7,'Tablets','Tablet devices',1,3,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(8,'Men\'s Wear','Clothing for men',2,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(9,'Women\'s Wear','Clothing for women',2,2,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(10,'Children\'s Wear','Clothing for children',2,3,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `product_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_media`
--

DROP TABLE IF EXISTS `product_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_media` (
  `media_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `file_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `is_primary` tinyint NOT NULL DEFAULT '0',
  `order` int DEFAULT '0',
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `delete_by` int DEFAULT NULL,
  PRIMARY KEY (`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_media`
--

LOCK TABLES `product_media` WRITE;
/*!40000 ALTER TABLE `product_media` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provinces`
--

DROP TABLE IF EXISTS `provinces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `provinces` (
  `province_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `country_id` int NOT NULL,
  `population` int DEFAULT NULL,
  `area` decimal(10,2) DEFAULT NULL,
  `capital` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `capprovince` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`province_id`),
  UNIQUE KEY `code_unique` (`code`),
  KEY `provinces_ibfk_1` (`country_id`),
  CONSTRAINT `provinces_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`country_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provinces`
--

LOCK TABLES `provinces` WRITE;
/*!40000 ALTER TABLE `provinces` DISABLE KEYS */;
INSERT INTO `provinces` VALUES (1,'Buenos Aires',1,17541141,307571.00,'La Plata','Buenos Aires','BA',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(2,'Córdoba',1,3760450,165321.00,'Córdoba','Córdoba','CBA',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(3,'Santa Fe',1,3194537,133007.00,'Santa Fe','Rosario','SF',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(4,'Mendoza',1,1990338,148827.00,'Mendoza','Mendoza','MZA',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(5,'São Paulo',2,46289333,248222.00,'São Paulo','São Paulo','SP',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(6,'Rio de Janeiro',2,17366189,43696.00,'Rio de Janeiro','Rio de Janeiro','RJ',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(7,'Minas Gerais',2,21411923,586528.00,'Belo Horizonte','Belo Horizonte','MG',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(8,'Rio Grande do Sul',2,11422973,281748.00,'Porto Alegre','Porto Alegre','RS',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(9,'Santiago',3,8125072,15403.00,'Santiago','Santiago','STG',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(10,'Valparaíso',3,1960170,16396.00,'Valparaíso','Valparaíso','VAL',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(11,'Concepción',3,2037414,12145.00,'Concepción','Concepción','CON',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(12,'Montevideo',4,1381228,530.00,'Montevideo','Montevideo','MVD',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(13,'Canelones',4,520187,4536.00,'Canelones','Canelones','CAN',1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(14,'Maldonados',4,164300,4793.00,'Maldonado','Maldonado','MALDO',1,'2025-03-13 00:49:45','2025-03-13 01:21:26');
/*!40000 ALTER TABLE `provinces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `statuses` (
  `status_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `delete_by` int DEFAULT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statuses`
--

LOCK TABLES `statuses` WRITE;
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;
INSERT INTO `statuses` VALUES (1,'Pendiente','Orden recién creada',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(2,'Confirmado','Orden confirmada y en proceso',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(3,'En preparación','Orden siendo preparada en almacén',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(4,'En tránsito','Paquete en camino',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(5,'En distribución','Paquete en proceso de entrega final',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(6,'Entregado','Paquete entregado al destinatario',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(7,'Cancelado','Orden cancelada',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(8,'Devuelto','Paquete devuelto al remitente',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(9,'Retenido','Paquete retenido en aduana',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(10,'Extraviado','Paquete extraviado en tránsito',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tariff`
--

DROP TABLE IF EXISTS `tariff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tariff` (
  `tariff_id` int NOT NULL AUTO_INCREMENT,
  `destination_id` int NOT NULL,
  `country_id` int NOT NULL,
  `province_id` int NOT NULL,
  `tariff_price` decimal(10,2) NOT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `volume` decimal(10,3) DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `delete_by` int DEFAULT NULL,
  PRIMARY KEY (`tariff_id`),
  KEY `destination_id` (`destination_id`),
  KEY `country_id` (`country_id`),
  KEY `province_id` (`province_id`),
  CONSTRAINT `tariff_ibfk_1` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`destination_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tariff_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `countries` (`country_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `tariff_ibfk_3` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`province_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tariff`
--

LOCK TABLES `tariff` WRITE;
/*!40000 ALTER TABLE `tariff` DISABLE KEYS */;
INSERT INTO `tariff` VALUES (1,1,1,1,130.00,2.00,0.016,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(2,1,1,1,160.00,2.00,0.016,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(3,1,1,1,155.00,5.00,0.036,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(4,1,1,1,185.00,5.00,0.036,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(5,1,1,1,200.00,20.00,0.360,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(6,1,1,1,230.00,20.00,0.360,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(7,1,1,1,360.00,30.00,0.360,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(8,1,1,1,390.00,30.00,0.360,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(9,1,1,1,750.00,40.00,0.500,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(10,5,1,2,980.00,40.00,0.500,1,'2025-03-13 00:49:45','2025-03-13 01:21:16',NULL,NULL,1,NULL),(11,1,1,1,80.00,0.00,0.000,1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tariff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_usuario` (
  `tipo_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `create_by` int DEFAULT NULL,
  `update_by` int DEFAULT NULL,
  `delete_by` int DEFAULT NULL,
  PRIMARY KEY (`tipo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_usuario`
--

LOCK TABLES `tipo_usuario` WRITE;
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` VALUES (1,'Individual','Cliente individual o persona física',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(2,'Empresa','Cliente empresarial o persona jurídica',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(3,'Distribuidor','Distribuidor autorizado',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL),(4,'Mayorista','Cliente mayorista',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `token_customers`
--

DROP TABLE IF EXISTS `token_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `token_customers` (
  `token_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token_dev` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`token_id`),
  UNIQUE KEY `token_unique` (`token`),
  UNIQUE KEY `token_dev_unique` (`token_dev`),
  KEY `token_customer_id_fk` (`customer_id`),
  CONSTRAINT `token_customer_id_fk` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token_customers`
--

LOCK TABLES `token_customers` WRITE;
/*!40000 ALTER TABLE `token_customers` DISABLE KEYS */;
INSERT INTO `token_customers` VALUES (1,1,'tk_empresaa_04709916404f9ec49fecc3b6ec2237d019d8a965a3b39f9752d2989abecfcebd','Dev-tk_empresaa_0f08f02bdab956eb7455a0607a3b2dd3fdfa3ceefbcec0a683063983bf799261',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL),(2,2,'tk_comercialba_b196596af7e29c604a205088aa60dc8fbe13311e00efa6ba61bdde1fae22c226','Dev-tk_comercialba_bdf0133ffa1a3e1749e2bb38664b9ca15f7ad30eb2753be546ca4965c7d91e32',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL),(3,3,'tk_distcordoba_7ee75108c6ec6276e9ebb8101d0e847c3ab1b12bd57b00820a9d2ec9002e4d74','Dev-tk_distcordoba_6732fc6bfc5574994d3c71f09cfa612b1f4c9a273f207302b0af3763e3d3cfc3',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL),(4,4,'tk_comercialb_69949048ae7fd441efaa4a2b66f112258eb6dd726591cfc3ff58d21ab2d21944','Dev-tk_comercialb_921cd6463ec5dcca7c0e8e8c1c3bd33026e197741ba83d9b83fb89e869edddef',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL),(5,5,'tk_importadorasp_9d4ce38caea27ca678701d5641beb4df4ab5a2df986331b2a3a60810645f9979','Dev-tk_importadorasp_62a41289c5e98fb99887c6672e0768303a0976c2ad1bd717904e8de75b7da254',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL),(6,6,'tk_distrio_8e0ac1ec89539bfd8d4be063fddb5fd67bf83603efc553aa3c15d156ed591332','Dev-tk_distrio_cfda1aab0ae3917b74fe7a6752f70a6178d38abf0a6ee41a3d7590f47337f4df',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL),(7,7,'tk_distribuidorac_f6e503f556c6e1ae340f2992422d327149bf517c726d83c69b07ded1b7f2679e','Dev-tk_distribuidorac_d110c799db93900d10cf18c6dd735ab6ca68f19198c83473aa59133075b3d443',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL),(8,8,'tk_comercialsantiago_d160a98f97784798ea84f6a141106e6a2dcfe9a70efdbc4d72ca15f40e805424','Dev-tk_comercialsantiago_79db54a4623abe37f2c001f88f93e6b7711c61d9c1d06dcf666b8cc48d0e882a',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL),(9,9,'tk_importadorad_a2f56068fc5ca0434822939aa63de35990b937f97e9b8c7887d378558b0a411c','Dev-tk_importadorad_1b8cf0dbc9e6fe0b50c57f884b33a7a4c1bba6114060ab0cb6888b4d61878662',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL),(10,10,'tk_distmvd_6987f026924fdc7fcdc101641f55f63d3369695666d73dab3737baf8f6eaf7a8','Dev-tk_distmvd_20ae05e4f018f0d48041a83d1abd2638668256cae2e507d9946acd5507933ac7',1,'2025-03-13 00:49:45','2025-03-13 00:49:45',NULL);
/*!40000 ALTER TABLE `token_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(254) COLLATE utf8mb4_general_ci NOT NULL,
  `activation_selector` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `activation_code` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `forgotten_password_selector` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `forgotten_password_code` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `forgotten_password_time` int DEFAULT NULL,
  `remember_selector` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `remember_code` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_on` int NOT NULL,
  `last_login` int DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `surname` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_ip` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_activity` int DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `group_id` int DEFAULT NULL,
  `type_user_id` int DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'127.0.0.1','admin','053eec822aa69ba0f9913b6fe835dd2e98731ca6','admin_salt','admin@admin.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1741794553,1741800250,1,'Admin','User',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'127.0.0.1','admin1','9e88a735c1eb094d5e77a97130c41dc4b385e9ec','salt1','admin1@lanube.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1741794553,NULL,1,'Admin','User 1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'127.0.0.1','admin2','dc9df7089f57b8c92946e84a323450f1e3f61cf0','salt2','admin2@lanube.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1741794553,NULL,1,'Admin','User 2',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'127.0.0.1','admin3','12e8d07a57a5a46845cc1c079938862cf328f7ed','salt3','admin3@lanube.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1741794553,NULL,1,'Admin','User 3',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'127.0.0.1','admin.test','7a55af6c3ff32d017c435a5b2425ee9a0c3bd8e2','salt_test1','admin.test@lanube.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1741794585,NULL,1,'Admin','User','La Nube','+54911111111',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,'127.0.0.1','operator.test','8edea145de8845c51df6d7f30ed90876ad7c786c','salt_test2','operator.test@lanube.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1741794585,NULL,1,'Operator','User','La Nube','+54922222222',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,'127.0.0.1','manager.test','aa9317083de5fe4e5f1de64ee81edbdd054766b2','salt_test3','manager.test@lanube.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1741794585,NULL,1,'Manager','User','La Nube','+54933333333',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,'127.0.0.1','admin4','2b38b5bb3eea822efff59f04d33c348175f6239a','salt_test4','admin4@lanube.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1741794585,NULL,1,'Admin','User 4','La Nube','+54944444444',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,'127.0.0.1','admin5','6c7c98b97cd5a4fffd2ea8d9737dd94382f4c6b0','salt_test5','admin5@lanube.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1741794585,NULL,1,'Admin','User 51','La Nube','+549555555551','',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_groups` (
  `id_user` int NOT NULL,
  `id_group` int NOT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`,`id_group`),
  KEY `id_group` (`id_group`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `users_groups_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  CONSTRAINT `users_groups_ibfk_2` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id_group`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_groups`
--

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` VALUES (1,1,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(2,1,1,'2025-03-13 00:49:13','2025-03-13 00:49:13'),(3,1,1,'2025-03-13 00:49:13','2025-03-13 00:49:13'),(4,1,1,'2025-03-13 00:49:13','2025-03-13 00:49:13'),(5,2,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(6,3,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(7,4,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(8,2,1,'2025-03-13 00:49:45','2025-03-13 00:49:45'),(9,2,1,'2025-03-13 01:21:38','2025-03-13 01:21:38');
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-14 14:42:44
