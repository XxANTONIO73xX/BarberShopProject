-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)
--
-- Host: localhost    Database: barberiadb
-- ------------------------------------------------------
-- Server version	8.0.28

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
-- Table structure for table `administradores`
--

DROP TABLE IF EXISTS `administradores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administradores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `correo` varchar(80) NOT NULL,
  `telefono` varchar(13) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo_UNIQUE` (`correo`),
  UNIQUE KEY `telefono_UNIQUE` (`telefono`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administradores`
--

LOCK TABLES `administradores` WRITE;
/*!40000 ALTER TABLE `administradores` DISABLE KEYS */;
INSERT INTO `administradores` VALUES (1,'admin','admin','admin','666','666');
/*!40000 ALTER TABLE `administradores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barberias`
--

DROP TABLE IF EXISTS `barberias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barberias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `dirección` text NOT NULL,
  `telefono` varchar(13) NOT NULL,
  `correo` varchar(80) NOT NULL,
  `horario` text NOT NULL,
  `estado` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `telefono_UNIQUE` (`telefono`),
  UNIQUE KEY `correo_UNIQUE` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barberias`
--

LOCK TABLES `barberias` WRITE;
/*!40000 ALTER TABLE `barberias` DISABLE KEYS */;
INSERT INTO `barberias` VALUES (1,'la x','calle x','xxxxx','xxxxx','xxxxx','xxxxx');
/*!40000 ALTER TABLE `barberias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barberos`
--

DROP TABLE IF EXISTS `barberos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barberos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apodo` varchar(20) DEFAULT NULL,
  `apellidos` varchar(50) NOT NULL,
  `correo` varchar(80) NOT NULL,
  `telefono` varchar(13) NOT NULL,
  `password` varchar(45) NOT NULL,
  `idBarberia` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `telefono_UNIQUE` (`telefono`),
  UNIQUE KEY `correo_UNIQUE` (`correo`),
  KEY `fk_barbero_barberia_idx` (`idBarberia`),
  CONSTRAINT `fk_barbero_barberia` FOREIGN KEY (`idBarberia`) REFERENCES `barberias` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barberos`
--

LOCK TABLES `barberos` WRITE;
/*!40000 ALTER TABLE `barberos` DISABLE KEYS */;
INSERT INTO `barberos` VALUES (1,'jose','srufo','ibarra','papap','xxxxx','asjlkajds',1);
/*!40000 ALTER TABLE `barberos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `citas`
--

DROP TABLE IF EXISTS `citas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `citas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` varchar(60) NOT NULL,
  `idCliente` int DEFAULT NULL,
  `idCorte` int DEFAULT NULL,
  `idBarbero` int DEFAULT NULL,
  `idBarberia` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cita_cliente_idx` (`idCliente`),
  KEY `fk_cita_corte_idx` (`idCorte`),
  KEY `fk_cita_barbero_idx` (`idBarbero`),
  KEY `fk_cita_barberia_idx` (`idBarberia`),
  CONSTRAINT `fk_cita_barberia` FOREIGN KEY (`idBarberia`) REFERENCES `barberias` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_cita_barbero` FOREIGN KEY (`idBarbero`) REFERENCES `barberos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_cita_cliente` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_cita_corte` FOREIGN KEY (`idCorte`) REFERENCES `cortes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citas`
--

LOCK TABLES `citas` WRITE;
/*!40000 ALTER TABLE `citas` DISABLE KEYS */;
INSERT INTO `citas` VALUES (2,'2022-04-05','10:00:00','Pendiente',1,1,1,1);
/*!40000 ALTER TABLE `citas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `correo` varchar(80) DEFAULT NULL,
  `telefono` varchar(13) NOT NULL,
  `password` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `telefono_UNIQUE` (`telefono`),
  UNIQUE KEY `correo_UNIQUE` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'jesus','navarrete','jesus@gmail.com','6221444556','spoonme876');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cortes`
--

DROP TABLE IF EXISTS `cortes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cortes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) DEFAULT NULL,
  `visualización` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cortes`
--

LOCK TABLES `cortes` WRITE;
/*!40000 ALTER TABLE `cortes` DISABLE KEYS */;
INSERT INTO `cortes` VALUES (1,'fade','debe ver');
/*!40000 ALTER TABLE `cortes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-05 22:27:08
