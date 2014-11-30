CREATE DATABASE  IF NOT EXISTS `researchdatabase` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `researchdatabase`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: researchdatabase
-- ------------------------------------------------------
-- Server version	5.6.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient` (
  `ID` int(11) NOT NULL,
  `Healthcare_No` varchar(10) NOT NULL,
  `Weight` double DEFAULT NULL,
  `Height` double DEFAULT NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT `FK_person_patient_id` FOREIGN KEY (`ID`) REFERENCES `person` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` VALUES (1,'63423-5345',60,170),(5,'42312-4236',100,175),(7,'13748-3745',50,155),(8,'24846-8563',70,190);
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_health_issues`
--

DROP TABLE IF EXISTS `patient_health_issues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient_health_issues` (
  `ID` int(11) NOT NULL,
  `Issues` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`,`Issues`),
  CONSTRAINT `patient_health_issues_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `patient` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_health_issues`
--

LOCK TABLES `patient_health_issues` WRITE;
/*!40000 ALTER TABLE `patient_health_issues` DISABLE KEYS */;
INSERT INTO `patient_health_issues` VALUES (1,'Bronchitis'),(1,'Pnemonia'),(5,'Asthma'),(5,'Atrial Fibrulation'),(7,'Allergy: Cat Hair'),(7,'Asthma'),(8,'Fibromyalgia'),(8,'Mitrial Leakage');
/*!40000 ALTER TABLE `patient_health_issues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_medications`
--

DROP TABLE IF EXISTS `patient_medications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient_medications` (
  `ID` int(11) NOT NULL,
  `Medications` varchar(32) NOT NULL,
  PRIMARY KEY (`ID`,`Medications`),
  CONSTRAINT `patient_medications_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `patient` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_medications`
--

LOCK TABLES `patient_medications` WRITE;
/*!40000 ALTER TABLE `patient_medications` DISABLE KEYS */;
INSERT INTO `patient_medications` VALUES (1,'Advil'),(1,'Cepacor'),(5,'Atavan'),(5,'Beta Blockers'),(7,'Adderal'),(7,'Medical Marijuana '),(8,'Caffiene'),(8,'Viagra');
/*!40000 ALTER TABLE `patient_medications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Birthday` date DEFAULT NULL,
  `Gender` char(1) DEFAULT NULL,
  `Name` varchar(32) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Emergency_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_person_emergency_id` (`Emergency_ID`),
  CONSTRAINT `FK_person_emergency_id` FOREIGN KEY (`Emergency_ID`) REFERENCES `person` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person`
--

LOCK TABLES `person` WRITE;
/*!40000 ALTER TABLE `person` DISABLE KEYS */;
INSERT INTO `person` VALUES (1,'1943-12-01','m','Gregory One','432-123-5363','235 BlahBlooh Lane NW Calgary AB',NULL,4),(2,'1993-11-05','f','Jane Two','352-125-3518','35 Sunset Avenue NE||Calgary|Canada','JaneTwo@gmail.com',NULL),(3,'1976-03-02','M','Philip Three','346-223-8463','28 EagleRidge Way SE Calgary AB','PhilipThree@live.ca',NULL),(4,'1983-09-01','F','Alexandra Four','302-315-1234','3523 Hollyander Road SW Calgary Alberta','AlexandraFour@gmail.com',NULL),(5,'1947-12-03','M','Jose Five','325-345-3424','54 Jefferson Drive NE Calgary AB','JoseFive@gmail.com',3),(6,'2000-12-03','M','Marco Six','327-573-3853','43 Asdf Way NW Calgary AB','MarcoSix@gmail.com',NULL),(7,'1993-10-01','F','Jillian Seven','432-325-1235','180 Newhampton Street NE Calgary AB','JillianSeven@gmail.com',6),(8,'1997-07-08','M','Andrew Eight','423-235-1237','283 Hotcross Lane SE Calgary AB','AndrewEight@gmail.com',NULL),(9,'2013-12-10','f','MinYeun Nine','324-424-8123','234 Holiday Road NE|Unit 1206|Calgary|Canada','MinYeunNine@gmail.com',NULL),(10,'1958-07-16','m','Reshawn Ten','234-629-3842','32 Jasper Way NW||Vancouver|Canada','ReshawnTen@gmail.com',NULL),(18,'1999-10-10','m','Silus Kovats','432-485-4848','123 Hello World|Accessing the double|HOHOHO|Alaska','kvats#@gmail.com',4),(19,'1994-05-04','m','Austin Toyoda','604-765-5911','3820 Brentwood Rd Nw|Unit 1207|Calgary|Canada','jat2980@hotmail.com',NULL);
/*!40000 ALTER TABLE `person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `results`
--

DROP TABLE IF EXISTS `results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `results` (
  `ID` int(11) NOT NULL,
  `Study_Name` varchar(32) NOT NULL,
  `Patient_Number` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`,`Study_Name`,`Patient_Number`),
  KEY `Study_Name` (`Study_Name`),
  KEY `Patient_Number` (`Patient_Number`),
  CONSTRAINT `results_ibfk_1` FOREIGN KEY (`Study_Name`) REFERENCES `study` (`Name`),
  CONSTRAINT `results_ibfk_2` FOREIGN KEY (`Patient_Number`) REFERENCES `patient` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `results`
--

LOCK TABLES `results` WRITE;
/*!40000 ALTER TABLE `results` DISABLE KEYS */;
INSERT INTO `results` VALUES (1,'Cardiovascular Imaging',1,'2014-11-03','Positive, Improved, got clear image of blah dede blah blah blah'),(2,'Cardiovascular Imaging',5,'2014-11-11','Negative, Increased weighted barred image of blah de blah blah balah'),(3,'Respiratory Volumes',7,'2014-11-15','12\r\n23\r\n43\r\n22\r\n10'),(4,'Cardiovascular Imaging',8,'2014-11-23','20\r\n40\r\n55\r\n44\r\n21');
/*!40000 ALTER TABLE `results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `study`
--

DROP TABLE IF EXISTS `study`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `study` (
  `Name` varchar(32) NOT NULL,
  `Budget` int(11) DEFAULT NULL,
  `End_Date` date DEFAULT NULL,
  `Start_Date` date NOT NULL,
  `Supervisor_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Name`),
  KEY `FK_user_supervisor_id` (`Supervisor_ID`),
  CONSTRAINT `FK_user_supervisor_id` FOREIGN KEY (`Supervisor_ID`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `study`
--

LOCK TABLES `study` WRITE;
/*!40000 ALTER TABLE `study` DISABLE KEYS */;
INSERT INTO `study` VALUES ('Cardiovascular Imaging',200000,'2015-01-01','2013-10-02',9),('Respiratory Volumes',100000,'2015-05-07','2014-08-26',9);
/*!40000 ALTER TABLE `study` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type`
--

DROP TABLE IF EXISTS `type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type` (
  `Result_ID` int(11) NOT NULL,
  `Study_Name` varchar(32) NOT NULL,
  `Patient_Number` int(11) NOT NULL,
  `Type` varchar(32) NOT NULL,
  PRIMARY KEY (`Result_ID`,`Type`,`Study_Name`,`Patient_Number`),
  KEY `Study_Name` (`Study_Name`),
  KEY `Patient_Number` (`Patient_Number`),
  CONSTRAINT `type_ibfk_1` FOREIGN KEY (`Result_ID`) REFERENCES `results` (`ID`),
  CONSTRAINT `type_ibfk_2` FOREIGN KEY (`Study_Name`) REFERENCES `study` (`Name`),
  CONSTRAINT `type_ibfk_3` FOREIGN KEY (`Patient_Number`) REFERENCES `patient` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type`
--

LOCK TABLES `type` WRITE;
/*!40000 ALTER TABLE `type` DISABLE KEYS */;
INSERT INTO `type` VALUES (1,'Cardiovascular Imaging',1,'String'),(2,'Cardiovascular Imaging',5,'String'),(3,'Respiratory Volumes',7,'int[]'),(4,'Respiratory Volumes',8,'int[]');
/*!40000 ALTER TABLE `type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `Username` varchar(10) NOT NULL,
  `Password` varchar(60) NOT NULL,
  `Type_Flag` char(1) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_person_id` FOREIGN KEY (`id`) REFERENCES `person` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (2,'Jane2','$2y$10$ZhXk/Mrt66brh7umkLMWseFvRHVuo5baNdznTx7bce4hyP/p5RPMC','A'),(9,'MinYeun9','$2y$10$herjnN7jvHSvOg4U9Hz0PewGTjG4Ly9QWvqI/15G3mgtJJ.q9yqnu','M'),(10,'Reshawn10','$2y$10$nwIwZKY6MN6eWTXcHzj9MOYIuQ3u4Gc0wEe8aQD6Pl.HAt6n1y5hW','R'),(18,'silas','$2y$10$7PV1P7qLF3ncqXXPUcRguuG1YBUpkEeAtTRZROJG5QR6HKZLLD.Vm','A'),(19,'ajtoyoda','$2y$10$z22KcOxAJJSLjIFsXgbj5uRueFvpSxV473b10SsSSALM1GzQlBqdi','A');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `view_edit`
--

DROP TABLE IF EXISTS `view_edit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `view_edit` (
  `Study_Name` varchar(32) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `canWrite` bit(1) NOT NULL,
  `canRead` bit(1) NOT NULL,
  PRIMARY KEY (`Study_Name`,`User_ID`),
  KEY `User_ID` (`User_ID`),
  CONSTRAINT `FK_user_user_id` FOREIGN KEY (`User_ID`) REFERENCES `user` (`id`),
  CONSTRAINT `view_edit_ibfk_1` FOREIGN KEY (`Study_Name`) REFERENCES `study` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `view_edit`
--

LOCK TABLES `view_edit` WRITE;
/*!40000 ALTER TABLE `view_edit` DISABLE KEYS */;
INSERT INTO `view_edit` VALUES ('Cardiovascular Imaging',2,'\0',''),('Cardiovascular Imaging',9,'',''),('Cardiovascular Imaging',10,'',''),('Cardiovascular Imaging',18,'','\0'),('Cardiovascular Imaging',19,'',''),('Respiratory Volumes',2,'\0',''),('Respiratory Volumes',9,'',''),('Respiratory Volumes',10,'',''),('Respiratory Volumes',18,'','\0'),('Respiratory Volumes',19,'','');
/*!40000 ALTER TABLE `view_edit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `works_on`
--

DROP TABLE IF EXISTS `works_on`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `works_on` (
  `Assistant_ID` int(11) NOT NULL,
  `Study_Name` varchar(32) NOT NULL,
  PRIMARY KEY (`Assistant_ID`,`Study_Name`),
  KEY `Study_Name` (`Study_Name`),
  CONSTRAINT `FK_user_assistant_id` FOREIGN KEY (`Assistant_ID`) REFERENCES `user` (`id`),
  CONSTRAINT `works_on_ibfk_2` FOREIGN KEY (`Study_Name`) REFERENCES `study` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `works_on`
--

LOCK TABLES `works_on` WRITE;
/*!40000 ALTER TABLE `works_on` DISABLE KEYS */;
INSERT INTO `works_on` VALUES (9,'Cardiovascular Imaging'),(10,'Cardiovascular Imaging'),(9,'Respiratory Volumes');
/*!40000 ALTER TABLE `works_on` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-11-30 11:19:34
