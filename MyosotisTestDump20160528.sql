-- MySQL dump 10.13  Distrib 5.6.29, for debian-linux-gnu (x86_64)
--
-- Host: aoshido.com.ar    Database: aoshidoc_prod
-- ------------------------------------------------------
-- Server version	5.5.49-cll

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
-- Table structure for table `Bug`
--

DROP TABLE IF EXISTS `Bug`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Bug` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contenido` varchar(600) COLLATE utf8_unicode_ci NOT NULL,
  `respuesta` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Activo` tinyint(1) NOT NULL,
  `IdUser` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DC1F9F4F9C28DE1` (`IdUser`),
  CONSTRAINT `FK_DC1F9F4F9C28DE1` FOREIGN KEY (`IdUser`) REFERENCES `fos_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Bug`
--

LOCK TABLES `Bug` WRITE;
/*!40000 ALTER TABLE `Bug` DISABLE KEYS */;
INSERT INTO `Bug` VALUES (1,'Falta que se pueda ver toda la respuesta',NULL,'Reported',1,1);
/*!40000 ALTER TABLE `Bug` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Carrera`
--

DROP TABLE IF EXISTS `Carrera`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Carrera` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Carrera`
--

LOCK TABLES `Carrera` WRITE;
/*!40000 ALTER TABLE `Carrera` DISABLE KEYS */;
INSERT INTO `Carrera` VALUES (1,'Ingenieria en sistemas de información',1),(2,'TEST PRE CODECEPTION',1),(3,'test',1),(4,'test',1),(5,'test',1),(6,'test',1);
/*!40000 ALTER TABLE `Carrera` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Examen`
--

DROP TABLE IF EXISTS `Examen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Examen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creada` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Examen`
--

LOCK TABLES `Examen` WRITE;
/*!40000 ALTER TABLE `Examen` DISABLE KEYS */;
/*!40000 ALTER TABLE `Examen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Materia`
--

DROP TABLE IF EXISTS `Materia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Materia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `AnioCarrera` int(11) NOT NULL,
  `Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Materia`
--

LOCK TABLES `Materia` WRITE;
/*!40000 ALTER TABLE `Materia` DISABLE KEYS */;
INSERT INTO `Materia` VALUES (1,'Sistemas Operativos',3,1);
/*!40000 ALTER TABLE `Materia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MateriasCarreras`
--

DROP TABLE IF EXISTS `MateriasCarreras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MateriasCarreras` (
  `materia_id` int(11) NOT NULL,
  `carrera_id` int(11) NOT NULL,
  PRIMARY KEY (`materia_id`,`carrera_id`),
  KEY `IDX_65FA4F33B54DBBCB` (`materia_id`),
  KEY `IDX_65FA4F33C671B40F` (`carrera_id`),
  CONSTRAINT `FK_65FA4F33C671B40F` FOREIGN KEY (`carrera_id`) REFERENCES `Carrera` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_65FA4F33B54DBBCB` FOREIGN KEY (`materia_id`) REFERENCES `Materia` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MateriasCarreras`
--

LOCK TABLES `MateriasCarreras` WRITE;
/*!40000 ALTER TABLE `MateriasCarreras` DISABLE KEYS */;
INSERT INTO `MateriasCarreras` VALUES (1,1);
/*!40000 ALTER TABLE `MateriasCarreras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pregunta`
--

DROP TABLE IF EXISTS `Pregunta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pregunta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Contenido` longtext COLLATE utf8_unicode_ci NOT NULL,
  `VecesVista` int(11) NOT NULL,
  `VecesAcertada` int(11) NOT NULL,
  `Activo` tinyint(1) NOT NULL,
  `creada` datetime NOT NULL,
  `IdUser` int(11) DEFAULT NULL,
  `IdExamen` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_579683A1F9C28DE1` (`IdUser`),
  KEY `IDX_579683A1CB2B4520` (`IdExamen`),
  CONSTRAINT `FK_579683A1CB2B4520` FOREIGN KEY (`IdExamen`) REFERENCES `Examen` (`id`),
  CONSTRAINT `FK_579683A1F9C28DE1` FOREIGN KEY (`IdUser`) REFERENCES `fos_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pregunta`
--

LOCK TABLES `Pregunta` WRITE;
/*!40000 ALTER TABLE `Pregunta` DISABLE KEYS */;
INSERT INTO `Pregunta` VALUES (1,'<p>Tengo un disco que gira a 7200rpm, con 512 sectores por pista, 20 pistas por plato....</p>',3,3,1,'2016-05-17 20:55:17',1,NULL),(2,'<p>Defina <strong><em>Page fault</em></strong></p>',1,1,1,'2016-05-17 21:00:35',1,NULL),(3,'<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris a viverra neque, eu lobortis libero. Vivamus vulputate mauris in mi imperdiet pharetra. Nulla dictum nisi justo, non aliquam mauris ultricies nec. Cras cursus dui at enim varius consectetur. Vestibulum venenatis faucibus ex, maximus posuere urna pulvinar in. Morbi eget leo blandit, sagittis diam sit amet, malesuada diam. Sed dui lacus, varius quis gravida vel, pellentesque at purus. Proin luctus gravida nisl, mollis gravida lorem dapibus eu. Proin cursus, lectus tempor aliquet mollis, nulla sapien dictum libero, nec molestie leo risus sed neque. Etiam tempor, nunc in congue malesuada, magna velit luctus sapien, ac consectetur eros leo vitae sem. Nunc lacus diam, laoreet quis elit eget, scelerisque sollicitudin sem. Mauris rhoncus tincidunt libero, ut malesuada sapien sodales ac. Suspendisse potenti. Sed varius nibh nec mi ultrices laoreet. Proin pellentesque massa sem, in scelerisque risus tincidunt pellentesque.</p>\r\n\r\n<p>Vivamus ligula massa, auctor at mi quis, ultrices vehicula libero. Pellentesque facilisis lectus non erat dapibus, eu placerat massa rutrum. Vestibulum sodales sem et quam varius, in luctus dui auctor. Morbi non malesuada lacus. Mauris faucibus nisl et massa tempus, sed accumsan mauris aliquet. Vivamus eget vestibulum nunc. Quisque rutrum metus at libero pretium, id venenatis felis sollicitudin. Fusce interdum quis neque non molestie. Aliquam erat volutpat. Mauris tempor metus vitae lectus ullamcorper, scelerisque ultricies lectus tempor. Curabitur ac risus ut urna egestas lobortis molestie et ex. Aliquam elementum, sapien quis ornare interdum, lacus eros tristique massa, a euismod lectus lectus ut tellus.</p>\r\n\r\n<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',2,1,1,'2016-05-17 21:07:42',1,NULL);
/*!40000 ALTER TABLE `Pregunta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PreguntasTemas`
--

DROP TABLE IF EXISTS `PreguntasTemas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PreguntasTemas` (
  `pregunta_id` int(11) NOT NULL,
  `tema_id` int(11) NOT NULL,
  PRIMARY KEY (`pregunta_id`,`tema_id`),
  KEY `IDX_DD241CA131A5801E` (`pregunta_id`),
  KEY `IDX_DD241CA1A64A8A17` (`tema_id`),
  CONSTRAINT `FK_DD241CA1A64A8A17` FOREIGN KEY (`tema_id`) REFERENCES `Tema` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_DD241CA131A5801E` FOREIGN KEY (`pregunta_id`) REFERENCES `Pregunta` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PreguntasTemas`
--

LOCK TABLES `PreguntasTemas` WRITE;
/*!40000 ALTER TABLE `PreguntasTemas` DISABLE KEYS */;
INSERT INTO `PreguntasTemas` VALUES (1,1),(2,1),(2,2),(3,3);
/*!40000 ALTER TABLE `PreguntasTemas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Respuesta`
--

DROP TABLE IF EXISTS `Respuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Respuesta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Contenido` longtext COLLATE utf8_unicode_ci NOT NULL,
  `Correcta` tinyint(1) NOT NULL,
  `Activo` tinyint(1) NOT NULL,
  `Aceptada` tinyint(1) NOT NULL DEFAULT '0',
  `creada` datetime NOT NULL,
  `IdPregunta` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EE9F474DB21EC87C` (`IdPregunta`),
  CONSTRAINT `FK_EE9F474DB21EC87C` FOREIGN KEY (`IdPregunta`) REFERENCES `Pregunta` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Respuesta`
--

LOCK TABLES `Respuesta` WRITE;
/*!40000 ALTER TABLE `Respuesta` DISABLE KEYS */;
INSERT INTO `Respuesta` VALUES (1,'<p>Verdadero</p>',1,1,0,'2016-05-17 20:56:47',1),(2,'<p>Falso</p>',0,1,0,'2016-05-17 20:57:03',1),(3,'<p>A&nbsp;<strong>page fault</strong>&nbsp;(sometimes called #PF, PF or hard&nbsp;<strong>fault</strong>&nbsp;[a]) is a type of interrupt, called trap, raised by computer hardware when a running program accesses a memory<strong>page</strong>&nbsp;that is mapped into the virtual address space, but not actually loaded into main memory.</p>',1,1,0,'2016-05-17 21:01:17',2),(4,'<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris a viverra neque, eu lobortis libero. Vivamus vulputate mauris in mi imperdiet pharetra. Nulla dictum nisi justo, non aliquam mauris ultricies nec. Cras cursus dui at enim varius consectetur. Vestibulum venenatis faucibus ex, maximus posuere urna pulvinar in. Morbi eget leo blandit, sagittis diam sit amet, malesuada diam. Sed dui lacus, varius quis gravida vel, pellentesque at purus. Proin luctus gravida nisl, mollis gravida lorem dapibus eu. Proin cursus, lectus tempor aliquet mollis, nulla sapien dictum libero, nec molestie leo risus sed neque. Etiam tempor, nunc in congue malesuada, magna velit luctus sapien, ac consectetur eros leo vitae sem. Nunc lacus diam, laoreet quis elit eget, scelerisque sollicitudin sem. Mauris rhoncus tincidunt libero, ut malesuada sapien sodales ac. Suspendisse potenti. Sed varius nibh nec mi ultrices laoreet. Proin pellentesque massa sem, in scelerisque risus tincidunt pellentesque.</p>',1,1,0,'2016-05-17 21:18:21',3),(5,'<p>Vivamus ligula massa, auctor at mi quis, ultrices vehicula libero. Pellentesque facilisis lectus non erat dapibus, eu placerat massa rutrum. Vestibulum sodales sem et quam varius, in luctus dui auctor. Morbi non malesuada lacus. Mauris faucibus nisl et massa tempus, sed accumsan mauris aliquet. Vivamus eget vestibulum nunc. Quisque rutrum metus at libero pretium, id venenatis felis sollicitudin. Fusce interdum quis neque non molestie. Aliquam erat volutpat. Mauris tempor metus vitae lectus ullamcorper, scelerisque ultricies lectus tempor. Curabitur ac risus ut urna egestas lobortis molestie et ex. Aliquam elementum, sapien quis ornare interdum, lacus eros tristique massa, a euismod lectus lectus ut tellus.</p>',0,1,0,'2016-05-17 21:18:41',3),(6,'<p>Vivamus ligula massa, auctor at mi quis, ultrices vehicula libero. Pellentesque facilisis lectus non erat dapibus, eu placerat massa rutrum. Vestibulum sodales sem et quam varius, in luctus dui auctor. Morbi non malesuada lacus. Mauris faucibus nisl et massa tempus, sed accumsan mauris aliquet. Vivamus eget vestibulum nunc. Quisque rutrum metus at libero pretium, id venenatis felis sollicitudin. Fusce interdum quis neque non molestie. Aliquam erat volutpat. Mauris tempor metus vitae lectus ullamcorper, scelerisque ultricies lectus tempor. Curabitur ac risus ut urna egestas lobortis molestie et ex. Aliquam elementum, sapien quis ornare interdum, lacus eros tristique massa, a euismod lectus lectus ut tellus.</p>',0,1,0,'2016-05-17 21:18:43',3),(7,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:02',3),(8,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:06',3),(9,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:08',3),(10,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:09',3),(11,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:12',3),(12,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:16',3),(13,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:19',3),(14,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:21',3),(15,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:25',3),(16,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:27',3),(17,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:30',3),(18,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:33',3),(19,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:36',3),(20,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:39',3),(21,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:43',3),(22,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:46',3),(23,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:49',3),(24,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:55',3),(25,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:19:57',3),(26,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:20:00',3),(27,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:20:03',3),(28,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:20:06',3),(29,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:20:09',3),(30,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:20:12',3),(31,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:20:15',3),(32,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:20:18',3),(33,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:20:22',3),(34,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:20:24',3),(35,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:20:27',3),(36,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:20:30',3),(37,'<p>Nullam blandit a elit eu interdum. Vivamus posuere bibendum ex, bibendum dapibus tortor imperdiet dignissim. Nunc lacinia mauris purus, eu interdum ligula venenatis eget. Etiam vel ipsum a magna faucibus tempus. Cras sit amet faucibus arcu. Praesent eget justo in velit placerat condimentum quis quis magna. Ut tincidunt tincidunt fringilla. Proin neque sem, iaculis ut lacus vel, faucibus maximus augue.</p>',0,1,0,'2016-05-17 21:20:33',3);
/*!40000 ALTER TABLE `Respuesta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tema`
--

DROP TABLE IF EXISTS `Tema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `Activo` tinyint(1) NOT NULL,
  `IdMateria` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C1D10A06FFB8BBD5` (`IdMateria`),
  CONSTRAINT `FK_C1D10A06FFB8BBD5` FOREIGN KEY (`IdMateria`) REFERENCES `Materia` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tema`
--

LOCK TABLES `Tema` WRITE;
/*!40000 ALTER TABLE `Tema` DISABLE KEYS */;
INSERT INTO `Tema` VALUES (1,'Disco',1,1),(2,'Memoria',1,1),(3,'I/O',1,1);
/*!40000 ALTER TABLE `Tema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fos_user`
--

DROP TABLE IF EXISTS `fos_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fos_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fos_user`
--

LOCK TABLES `fos_user` WRITE;
/*!40000 ALTER TABLE `fos_user` DISABLE KEYS */;
INSERT INTO `fos_user` VALUES (1,'Aoshido','aoshido','Aoshido@Gmail.com','aoshido@gmail.com',1,'t93pkkrm66so8w84s88wgk48wwkoswo','Aoshido{t93pkkrm66so8w84s88wgk48wwkoswo}','2016-05-28 04:48:51',0,0,NULL,NULL,NULL,'a:2:{i:0;s:12:\"ROLE_STUDENT\";i:1;s:16:\"ROLE_SUPER_ADMIN\";}',0,NULL);
/*!40000 ALTER TABLE `fos_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-28 10:03:43
