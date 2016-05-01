-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: wive
-- ------------------------------------------------------
-- Server version	5.5.27

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
-- Table structure for table `ems`
--

DROP TABLE IF EXISTS `ems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ems` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weight` varchar(200) NOT NULL,
  `price` decimal(7,2) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ems`
--

LOCK TABLES `ems` WRITE;
/*!40000 ALTER TABLE `ems` DISABLE KEYS */;
/*!40000 ALTER TABLE `ems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_order`
--

DROP TABLE IF EXISTS `shop_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_date` datetime NOT NULL,
  `payment_date` datetime DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'wait' COMMENT 'สถานะของ order ',
  `shipping_method` varchar(50) DEFAULT NULL,
  `total_price` decimal(7,2) unsigned NOT NULL,
  `remark` mediumint(8) unsigned DEFAULT NULL,
  `flag_del` tinyint(1) NOT NULL DEFAULT '0',
  `billing_address_id` int(10) unsigned DEFAULT NULL,
  `billing_firstname` varchar(50) DEFAULT NULL,
  `billing_lastname` varchar(50) DEFAULT NULL,
  `billing_address` mediumtext,
  `billing_tambon` varchar(100) DEFAULT NULL,
  `billing_amphoe` varchar(100) DEFAULT NULL,
  `billing_province` varchar(100) DEFAULT NULL,
  `billing_postalcode` varchar(100) DEFAULT NULL,
  `billing_tel_num` varchar(10) DEFAULT NULL,
  `billing_fax_num` varchar(10) DEFAULT NULL,
  `shipping_address_id` int(10) unsigned DEFAULT NULL,
  `shipping_firstname` varchar(50) DEFAULT NULL,
  `shipping_lastname` varchar(50) DEFAULT NULL,
  `shipping_address` mediumtext,
  `shipping_tambon` varchar(100) DEFAULT NULL,
  `shipping_amphoe` varchar(100) DEFAULT NULL,
  `shipping_province` varchar(100) DEFAULT NULL,
  `shipping_postalcode` varchar(100) DEFAULT NULL,
  `shipping_tel_num` varchar(10) DEFAULT NULL,
  `shipping_fax_num` varchar(10) DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_user_id` (`user_id`),
  KEY `order_billing_address_id` (`billing_address_id`),
  KEY `order_shipping_address_id` (`shipping_address_id`),
  CONSTRAINT `order_billing_address_id` FOREIGN KEY (`billing_address_id`) REFERENCES `shop_user_address` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `order_shipping_address_id` FOREIGN KEY (`shipping_address_id`) REFERENCES `shop_user_address` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `order_user_id` FOREIGN KEY (`user_id`) REFERENCES `wive_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_order`
--

LOCK TABLES `shop_order` WRITE;
/*!40000 ALTER TABLE `shop_order` DISABLE KEYS */;
INSERT INTO `shop_order` VALUES (94,'2016-05-01 11:15:13',NULL,'wait','mail',31.00,NULL,0,37,'customer','customer','address','address','address','address','11211','021455878','',37,'customer','customer','address','address','address','address','11211','021455878','',40),(95,'2016-05-01 11:15:16',NULL,'wait','mail',31.00,NULL,0,38,'customer','customer','address','address','address','address','11211','021455878','',38,'customer','customer','address','address','address','address','11211','021455878','',40),(96,'2016-05-01 11:15:16',NULL,'wait','mail',31.00,NULL,0,39,'customer','customer','address','address','address','address','11211','021455878','',39,'customer','customer','address','address','address','address','11211','021455878','',40),(97,'2016-05-01 11:15:16',NULL,'wait','mail',31.00,NULL,0,40,'customer','customer','address','address','address','address','11211','021455878','',40,'customer','customer','address','address','address','address','11211','021455878','',40),(98,'2016-05-01 11:15:16',NULL,'wait','mail',31.00,NULL,0,41,'customer','customer','address','address','address','address','11211','021455878','',41,'customer','customer','address','address','address','address','11211','021455878','',40),(99,'2016-05-01 11:15:17',NULL,'wait','mail',31.00,NULL,0,42,'customer','customer','address','address','address','address','11211','021455878','',42,'customer','customer','address','address','address','address','11211','021455878','',40),(100,'2016-05-01 11:15:25',NULL,'wait','mail',31.00,NULL,0,43,'customer','customer','address','address','address','address','11211','021455878','',43,'customer','customer','address','address','address','address','11211','021455878','',40),(101,'2016-05-01 11:16:01',NULL,'wait','mail',31.00,NULL,0,44,'customer','customer','address','address','address','address','11211','021455878','',44,'customer','customer','address','address','address','address','11211','021455878','',40),(102,'2016-05-01 11:16:07',NULL,'wait','mail',31.00,NULL,0,45,'customer','customer','address','address','address','address','11211','021455878','',45,'customer','customer','address','address','address','address','11211','021455878','',40),(103,'2016-05-01 11:16:16',NULL,'wait','mail',31.00,NULL,0,46,'customer','customer','address','address','address','address','11211','021455878','',46,'customer','customer','address','address','address','address','11211','021455878','',40),(104,'2016-05-01 11:21:48',NULL,'wait','mail',31.00,NULL,0,37,'customer','customer','address','address','address','address','11211','021455878','',37,'customer','customer','address','address','address','address','11211','021455878','',40);
/*!40000 ALTER TABLE `shop_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_order_item`
--

DROP TABLE IF EXISTS `shop_order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_order_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quantity` int(10) unsigned NOT NULL,
  `present_price` decimal(7,2) unsigned NOT NULL,
  `lot_id` int(10) DEFAULT NULL,
  `tracking_code` varchar(100) DEFAULT NULL,
  `remark` mediumtext,
  `flag_del` tinyint(1) NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  `product_des` text,
  PRIMARY KEY (`id`),
  KEY `order_item_order_id` (`order_id`),
  KEY `order_item_product_id` (`product_id`),
  CONSTRAINT `order_item_order_id` FOREIGN KEY (`order_id`) REFERENCES `shop_order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `order_item_product_id` FOREIGN KEY (`product_id`) REFERENCES `shop_product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_order_item`
--

LOCK TABLES `shop_order_item` WRITE;
/*!40000 ALTER TABLE `shop_order_item` DISABLE KEYS */;
INSERT INTO `shop_order_item` VALUES (86,1,11.00,NULL,NULL,NULL,0,887,94,NULL),(87,1,11.00,NULL,NULL,NULL,0,887,95,NULL),(88,1,11.00,NULL,NULL,NULL,0,887,96,NULL),(89,1,11.00,NULL,NULL,NULL,0,887,97,NULL),(90,1,11.00,NULL,NULL,NULL,0,887,98,NULL),(91,1,11.00,NULL,NULL,NULL,0,887,99,NULL),(92,1,11.00,NULL,NULL,NULL,0,887,100,NULL),(93,1,11.00,NULL,NULL,NULL,0,887,101,NULL),(95,1,11.00,NULL,NULL,NULL,0,887,102,NULL),(97,1,11.00,NULL,NULL,NULL,0,887,103,NULL),(99,1,11.00,NULL,NULL,NULL,0,887,104,NULL);
/*!40000 ALTER TABLE `shop_order_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_order_item_lot`
--

DROP TABLE IF EXISTS `shop_order_item_lot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_order_item_lot` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shipment_cost` double(7,2) unsigned NOT NULL,
  `deliver_date` datetime NOT NULL,
  `deliver_price` double(7,2) unsigned NOT NULL,
  `tracking_code` varchar(20) NOT NULL,
  `order_item_id` int(10) unsigned NOT NULL DEFAULT '0',
  `product_lot_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_shop_order_item_lot_shop_order_item` (`order_item_id`),
  KEY `FK_shop_order_item_lot_shop_product_lot` (`product_lot_id`),
  CONSTRAINT `FK_shop_order_item_lot_shop_order_item` FOREIGN KEY (`order_item_id`) REFERENCES `shop_order_item` (`id`),
  CONSTRAINT `FK_shop_order_item_lot_shop_product_lot` FOREIGN KEY (`product_lot_id`) REFERENCES `shop_product_lot` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ลบทิ้ง ไม่ใช้แล้วเพราะ 1 order_item มีได้แค่ lot เดียวแล้ว';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_order_item_lot`
--

LOCK TABLES `shop_order_item_lot` WRITE;
/*!40000 ALTER TABLE `shop_order_item_lot` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_order_item_lot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_order_item_option`
--

DROP TABLE IF EXISTS `shop_order_item_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_order_item_option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `options` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `order_item_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_item_option_order_item_id` (`order_item_id`),
  CONSTRAINT `order_item_option_order_item_id` FOREIGN KEY (`order_item_id`) REFERENCES `shop_order_item` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_order_item_option`
--

LOCK TABLES `shop_order_item_option` WRITE;
/*!40000 ALTER TABLE `shop_order_item_option` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_order_item_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_payment`
--

DROP TABLE IF EXISTS `shop_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `money` decimal(7,2) unsigned NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_date` datetime NOT NULL,
  `detail` mediumtext NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_user_id` (`user_id`),
  KEY `payment_order_id` (`order_id`),
  CONSTRAINT `payment_order_id` FOREIGN KEY (`order_id`) REFERENCES `shop_order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `payment_user_id` FOREIGN KEY (`user_id`) REFERENCES `wive_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_payment`
--

LOCK TABLES `shop_payment` WRITE;
/*!40000 ALTER TABLE `shop_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_product`
--

DROP TABLE IF EXISTS `shop_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_code` varchar(10) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `detail` longtext,
  `image` varchar(255) DEFAULT NULL,
  `cost` decimal(7,2) unsigned NOT NULL,
  `price` decimal(7,2) unsigned NOT NULL,
  `quantity` int(11) unsigned NOT NULL,
  `unit` varchar(20) NOT NULL COMMENT 'หน่วยของสินค้า เช่น ตัว, ชิ้น',
  `full_price` decimal(7,2) DEFAULT NULL,
  `weight` decimal(7,2) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `options` varchar(50) NOT NULL DEFAULT 'normal',
  `add_date` datetime NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'ระบุ status ว่าสินค้าจะให้วางขายหรือไม่ ',
  `flag_del` tinyint(1) NOT NULL DEFAULT '0',
  `owner_id` int(11) unsigned NOT NULL,
  `owner_type` varchar(10) NOT NULL,
  `product_category_id` int(11) unsigned DEFAULT NULL,
  `type2` varchar(50) DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_product_category_id` (`product_category_id`),
  CONSTRAINT `product_product_category_id` FOREIGN KEY (`product_category_id`) REFERENCES `shop_product_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=889 DEFAULT CHARSET=utf8 COMMENT='owner_id : เก็บ user id ของ c2c และ เก็บ supplier id ของ b2c';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_product`
--

LOCK TABLES `shop_product` WRITE;
/*!40000 ALTER TABLE `shop_product` DISABLE KEYS */;
INSERT INTO `shop_product` VALUES (887,NULL,'Pork','Pork','','',0.00,11.00,100,'ชิ้น',NULL,NULL,'0','0',NULL,'normal','2016-05-01 11:05:41',1,0,39,'b2c',NULL,NULL,NULL),(888,NULL,'Chicken','Chicken','<div>\n	This is the best chicken.</div>\n','',0.00,99.00,0,'ชิ้น',NULL,NULL,'0','0',NULL,'normal','2016-05-01 11:20:44',1,0,40,'c2c',NULL,NULL,NULL);
/*!40000 ALTER TABLE `shop_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_product_category`
--

DROP TABLE IF EXISTS `shop_product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_product_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `flag_del` tinyint(1) NOT NULL DEFAULT '0',
  `product_category_id` int(11) unsigned DEFAULT NULL,
  `product_category_top_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_category_product_category_id` (`product_category_id`),
  KEY `FK_shop_product_category_shop_product_category_top` (`product_category_top_id`),
  CONSTRAINT `FK_shop_product_category_shop_product_category_top` FOREIGN KEY (`product_category_top_id`) REFERENCES `shop_product_category_top` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `product_category_product_category_id` FOREIGN KEY (`product_category_id`) REFERENCES `shop_product_category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_product_category`
--

LOCK TABLES `shop_product_category` WRITE;
/*!40000 ALTER TABLE `shop_product_category` DISABLE KEYS */;
INSERT INTO `shop_product_category` VALUES (15,'Meat','Meat',0,NULL,3);
/*!40000 ALTER TABLE `shop_product_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_product_category_top`
--

DROP TABLE IF EXISTS `shop_product_category_top`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_product_category_top` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `flag_del` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_product_category_top`
--

LOCK TABLES `shop_product_category_top` WRITE;
/*!40000 ALTER TABLE `shop_product_category_top` DISABLE KEYS */;
INSERT INTO `shop_product_category_top` VALUES (3,'Food','Food',0);
/*!40000 ALTER TABLE `shop_product_category_top` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_product_gallery`
--

DROP TABLE IF EXISTS `shop_product_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_product_gallery` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `flag_del` tinyint(4) NOT NULL DEFAULT '0',
  `product_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_gallery_product_id` (`product_id`),
  CONSTRAINT `product_gallery_product_id` FOREIGN KEY (`product_id`) REFERENCES `shop_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_product_gallery`
--

LOCK TABLES `shop_product_gallery` WRITE;
/*!40000 ALTER TABLE `shop_product_gallery` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_product_gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_product_lot`
--

DROP TABLE IF EXISTS `shop_product_lot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_product_lot` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `flag_del` tinyint(4) NOT NULL DEFAULT '0',
  `purchase_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_lot_purchase_id` (`purchase_id`),
  CONSTRAINT `product_lot_purchase_id` FOREIGN KEY (`purchase_id`) REFERENCES `shop_purchase` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_product_lot`
--

LOCK TABLES `shop_product_lot` WRITE;
/*!40000 ALTER TABLE `shop_product_lot` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_product_lot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_product_media`
--

DROP TABLE IF EXISTS `shop_product_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_product_media` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `detail` longtext,
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  `add_date` datetime NOT NULL,
  `flag_del` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `product_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_media_user_id` (`user_id`),
  KEY `product_media_product_id` (`product_id`),
  CONSTRAINT `product_media_product_id` FOREIGN KEY (`product_id`) REFERENCES `shop_product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `product_media_user_id` FOREIGN KEY (`user_id`) REFERENCES `wive_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_product_media`
--

LOCK TABLES `shop_product_media` WRITE;
/*!40000 ALTER TABLE `shop_product_media` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_product_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_product_option`
--

DROP TABLE IF EXISTS `shop_product_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_product_option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `options` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_shop_product_option_shop_product` (`product_id`),
  CONSTRAINT `FK_shop_product_option_shop_product` FOREIGN KEY (`product_id`) REFERENCES `shop_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_product_option`
--

LOCK TABLES `shop_product_option` WRITE;
/*!40000 ALTER TABLE `shop_product_option` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_product_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_product_qa`
--

DROP TABLE IF EXISTS `shop_product_qa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_product_qa` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(100) NOT NULL,
  `answer` longtext,
  `score` int(11) NOT NULL COMMENT 'เก็บ score ของ qa ค่าอาจติดลบ',
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  `add_date` datetime NOT NULL,
  `flag_del` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `product_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_qa_product_id` (`product_id`),
  KEY `product_qa_user_id` (`user_id`),
  CONSTRAINT `product_qa_user_id` FOREIGN KEY (`user_id`) REFERENCES `wive_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `product_qa_product_id` FOREIGN KEY (`product_id`) REFERENCES `shop_product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_product_qa`
--

LOCK TABLES `shop_product_qa` WRITE;
/*!40000 ALTER TABLE `shop_product_qa` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_product_qa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_product_review`
--

DROP TABLE IF EXISTS `shop_product_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_product_review` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `detail` longtext,
  `overall_rating` tinyint(1) unsigned NOT NULL COMMENT 'rating ของคนเขียน review 1-5',
  `money_rating` tinyint(1) unsigned NOT NULL,
  `expectation_rating` tinyint(1) unsigned NOT NULL,
  `approve` tinyint(1) NOT NULL DEFAULT '0',
  `add_date` datetime NOT NULL,
  `flag_del` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `product_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_review_user_id` (`user_id`),
  KEY `product_review_product_id` (`product_id`),
  CONSTRAINT `product_review_product_id` FOREIGN KEY (`product_id`) REFERENCES `shop_product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `product_review_user_id` FOREIGN KEY (`user_id`) REFERENCES `wive_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_product_review`
--

LOCK TABLES `shop_product_review` WRITE;
/*!40000 ALTER TABLE `shop_product_review` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_product_review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_purchase`
--

DROP TABLE IF EXISTS `shop_purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_purchase` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_date` datetime DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'no_receive',
  `create_date` datetime NOT NULL,
  `supplier_id` int(10) unsigned DEFAULT NULL,
  `supplier_name` varchar(50) DEFAULT NULL,
  `supplier_contact_firstname` varchar(50) DEFAULT NULL,
  `supplier_contact_lastname` varchar(50) DEFAULT NULL,
  `supplier_address` longtext,
  `supplier_tambon` varchar(50) DEFAULT NULL,
  `supplier_amphoe` varchar(50) DEFAULT NULL,
  `supplier_province` varchar(50) DEFAULT NULL,
  `supplier_postalcode` varchar(50) DEFAULT NULL,
  `supplier_phone_number1` varchar(50) DEFAULT NULL,
  `supplier_phone_number2` varchar(50) DEFAULT NULL,
  `supplier_fax_number1` varchar(50) DEFAULT NULL,
  `supplier_fax_number2` varchar(50) DEFAULT NULL,
  `supplier_email` varchar(50) DEFAULT NULL,
  `supplier_website` varchar(50) DEFAULT NULL,
  `supplier_detail` longtext,
  `user_id` int(10) unsigned NOT NULL,
  `flag_del` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `shop_purchase_user_id` (`user_id`),
  CONSTRAINT `shop_purchase_user_id` FOREIGN KEY (`user_id`) REFERENCES `wive_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_purchase`
--

LOCK TABLES `shop_purchase` WRITE;
/*!40000 ALTER TABLE `shop_purchase` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_purchase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_purchase_item`
--

DROP TABLE IF EXISTS `shop_purchase_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_purchase_item` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `deliver_date` date DEFAULT NULL,
  `payment_price` decimal(7,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `flag_del` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `purchase_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shop_purchase_id_purchase_id` (`purchase_id`),
  CONSTRAINT `shop_purchase_id_purchase_id` FOREIGN KEY (`purchase_id`) REFERENCES `shop_purchase` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_purchase_item`
--

LOCK TABLES `shop_purchase_item` WRITE;
/*!40000 ALTER TABLE `shop_purchase_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_purchase_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_supplier`
--

DROP TABLE IF EXISTS `shop_supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_supplier` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `contact_firstname` varchar(50) DEFAULT NULL,
  `contact_lastname` varchar(50) DEFAULT NULL,
  `address` longtext NOT NULL,
  `tambon` varchar(100) NOT NULL,
  `amphoe` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `postalcode` varchar(10) NOT NULL,
  `phone_number1` varchar(10) DEFAULT NULL,
  `phone_number2` varchar(10) DEFAULT NULL,
  `fax_number1` varchar(10) DEFAULT NULL,
  `fax_number2` varchar(10) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `detail` longtext,
  `add_date` datetime NOT NULL,
  `flag_del` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supplier_user_id` (`user_id`),
  CONSTRAINT `supplier_user_id` FOREIGN KEY (`user_id`) REFERENCES `wive_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_supplier`
--

LOCK TABLES `shop_supplier` WRITE;
/*!40000 ALTER TABLE `shop_supplier` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_user_address`
--

DROP TABLE IF EXISTS `shop_user_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_user_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address` mediumtext NOT NULL,
  `tambon` varchar(100) NOT NULL,
  `amphoe` varchar(100) NOT NULL DEFAULT '0',
  `province` varchar(100) NOT NULL DEFAULT '0',
  `postalcode` varchar(100) DEFAULT '0',
  `tel_num` varchar(10) NOT NULL,
  `fax_num` varchar(10) DEFAULT NULL,
  `flag_del` tinyint(3) unsigned DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_address_user_id` (`user_id`),
  CONSTRAINT `user_address_user_id` FOREIGN KEY (`user_id`) REFERENCES `wive_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_user_address`
--

LOCK TABLES `shop_user_address` WRITE;
/*!40000 ALTER TABLE `shop_user_address` DISABLE KEYS */;
INSERT INTO `shop_user_address` VALUES (37,'customer','customer','address','address','address','address','11211','021455878','',0,40),(38,'customer','customer','address','address','address','address','11211','021455878','',0,40),(39,'customer','customer','address','address','address','address','11211','021455878','',0,40),(40,'customer','customer','address','address','address','address','11211','021455878','',0,40),(41,'customer','customer','address','address','address','address','11211','021455878','',0,40),(42,'customer','customer','address','address','address','address','11211','021455878','',0,40),(43,'customer','customer','address','address','address','address','11211','021455878','',0,40),(44,'customer','customer','address','address','address','address','11211','021455878','',0,40),(45,'customer','customer','address','address','address','address','11211','021455878','',0,40),(46,'customer','customer','address','address','address','address','11211','021455878','',0,40);
/*!40000 ALTER TABLE `shop_user_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_user_profile`
--

DROP TABLE IF EXISTS `shop_user_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_user_profile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `identity_number` varchar(13) DEFAULT NULL,
  `address` longtext,
  `tambon` varchar(100) DEFAULT NULL,
  `amphoe` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `postalcode` varchar(10) DEFAULT NULL,
  `tel_num` varchar(10) DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_profile_user_id` (`user_id`),
  CONSTRAINT `user_profile_user_id` FOREIGN KEY (`user_id`) REFERENCES `wive_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_user_profile`
--

LOCK TABLES `shop_user_profile` WRITE;
/*!40000 ALTER TABLE `shop_user_profile` DISABLE KEYS */;
INSERT INTO `shop_user_profile` VALUES (38,'1100800532977','0','0','0','0','0','0245578922',39),(39,'1100800532977','0','0','0','0','0','023558974',40);
/*!40000 ALTER TABLE `shop_user_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_user_shop`
--

DROP TABLE IF EXISTS `shop_user_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_user_shop` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `tel_num` varchar(10) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `description` mediumtext,
  `promotion` mediumtext,
  `instruction` mediumtext,
  `user_address_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_shop_user_id` (`user_id`),
  KEY `user_shop_user_address_id` (`user_address_id`),
  CONSTRAINT `user_shop_user_address_id` FOREIGN KEY (`user_address_id`) REFERENCES `shop_user_address` (`id`),
  CONSTRAINT `user_shop_user_id` FOREIGN KEY (`user_id`) REFERENCES `wive_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_user_shop`
--

LOCK TABLES `shop_user_shop` WRITE;
/*!40000 ALTER TABLE `shop_user_shop` DISABLE KEYS */;
INSERT INTO `shop_user_shop` VALUES (5,NULL,'','0245578922','','','','',NULL,39);
/*!40000 ALTER TABLE `shop_user_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wive_user`
--

DROP TABLE IF EXISTS `wive_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wive_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `level` varchar(20) NOT NULL DEFAULT 'user',
  `regis_date` datetime NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `flag_del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wive_user`
--

LOCK TABLES `wive_user` WRITE;
/*!40000 ALTER TABLE `wive_user` DISABLE KEYS */;
INSERT INTO `wive_user` VALUES (39,'mac@mac.com','140c1f12feeb2c52dfbeb2da6066a73a','mac','mac','kittipat','admin','2016-05-01 10:59:44',1,0),(40,'customer@customer.com','91ec1f9324753048c0096d036a694f86','customer','customer','ok','user','2016-05-01 11:06:49',1,0);
/*!40000 ALTER TABLE `wive_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-01 11:23:59
