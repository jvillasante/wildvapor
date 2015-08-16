-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.25a - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             8.0.0.4396
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for wildvapor
DROP DATABASE IF EXISTS `wildvapor`;
CREATE DATABASE IF NOT EXISTS `wildvapor` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `wildvapor`;


-- Dumping structure for table wildvapor.accessories_kits
DROP TABLE IF EXISTS `accessories_kits`;
CREATE TABLE IF NOT EXISTS `accessories_kits` (
  `kit_id` int(10) unsigned NOT NULL,
  `accessory_id` int(10) unsigned NOT NULL,
  `quantity` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`kit_id`,`accessory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table for the many to many association between accessories and kits.\r\nOne Kit have many accessories and one accessory can be included in many kits.';

-- Dumping data for table wildvapor.accessories_kits: ~14 rows (approximately)
DELETE FROM `accessories_kits`;
/*!40000 ALTER TABLE `accessories_kits` DISABLE KEYS */;
INSERT INTO `accessories_kits` (`kit_id`, `accessory_id`, `quantity`) VALUES
	(15, 6, 1),
	(15, 9, 1),
	(15, 10, 1),
	(16, 6, 1),
	(16, 9, 1),
	(16, 10, 1),
	(16, 11, 1),
	(16, 12, 1),
	(17, 1, 1),
	(17, 7, 2),
	(17, 9, 1),
	(17, 10, 2),
	(17, 11, 2),
	(17, 12, 1);
/*!40000 ALTER TABLE `accessories_kits` ENABLE KEYS */;


-- Dumping structure for table wildvapor.attribute
DROP TABLE IF EXISTS `attribute`;
CREATE TABLE IF NOT EXISTS `attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'E.g. Strength, Size',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='stores attributes such as Size and Color';

-- Dumping data for table wildvapor.attribute: ~4 rows (approximately)
DELETE FROM `attribute`;
/*!40000 ALTER TABLE `attribute` DISABLE KEYS */;
INSERT INTO `attribute` (`id`, `name`) VALUES
	(1, 'Flavour'),
	(2, 'Strength'),
	(3, 'Color'),
	(4, 'Resistance');
/*!40000 ALTER TABLE `attribute` ENABLE KEYS */;


-- Dumping structure for table wildvapor.attribute_value
DROP TABLE IF EXISTS `attribute_value`;
CREATE TABLE IF NOT EXISTS `attribute_value` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attribute_id` int(10) unsigned NOT NULL,
  `value` varchar(100) NOT NULL COMMENT 'E.g. 10ml',
  PRIMARY KEY (`id`),
  KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COMMENT='stores values such as 10ml or 24mg';

-- Dumping data for table wildvapor.attribute_value: ~54 rows (approximately)
DELETE FROM `attribute_value`;
/*!40000 ALTER TABLE `attribute_value` DISABLE KEYS */;
INSERT INTO `attribute_value` (`id`, `attribute_id`, `value`) VALUES
	(1, 1, 'Twisted Java'),
	(2, 1, 'Mountain Dew'),
	(3, 1, 'Hypnotic'),
	(4, 1, 'Strawberry Lemonade'),
	(5, 1, 'Watermelon'),
	(6, 1, 'Honeydew Melon'),
	(7, 1, 'Georgia Peach'),
	(8, 1, 'Banana Cream'),
	(9, 1, 'Circus Cotton Candy'),
	(10, 1, 'French Vanilla'),
	(11, 1, 'Vanilla Bean Ice Cream'),
	(12, 1, 'Green Apple'),
	(13, 1, 'Sweet Strawberry'),
	(14, 1, 'Crazy Rainbow'),
	(15, 1, 'Bubblegum'),
	(16, 1, 'Sweet Watermelon'),
	(17, 1, 'Tutti Frutti'),
	(18, 1, 'Red Hots'),
	(19, 1, 'Orange Creamsicle'),
	(20, 1, 'Island Getaway'),
	(21, 1, 'Tobacco / M-Boro'),
	(22, 1, 'Tobacco / Benson Hedges'),
	(23, 1, 'Tobacco / Crazy Hump'),
	(24, 1, 'Tobacco / Cuban Cigar'),
	(25, 1, 'Tobacco / Pall Mall'),
	(26, 1, 'Tobacco / M-Boro Special Blend'),
	(27, 1, 'Tobacco / M-Boro House Blend'),
	(28, 1, 'Tobacco / RY4'),
	(29, 1, 'Menthol / Altoids'),
	(30, 1, 'Menthol / Crazy Chill'),
	(31, 1, 'Menthol / Crazy Freeze'),
	(32, 1, 'Menthol / Extreme Ice'),
	(33, 1, 'Menthol / M-Boro Menthol'),
	(34, 1, 'Menthol / Extreme Ice'),
	(35, 1, 'Menthol / Nuport'),
	(36, 1, 'Menthol / Kool'),
	(37, 2, '0mg per milimeter'),
	(38, 2, '6mg per milimeter'),
	(39, 2, '12mg per milimeter'),
	(40, 2, '18mg per milimeter'),
	(41, 2, '24mg per milimeter'),
	(42, 3, 'Blue'),
	(43, 3, 'Green'),
	(44, 3, 'Black'),
	(45, 3, 'Yellow'),
	(46, 3, 'Red'),
	(47, 3, 'White'),
	(48, 3, 'Magenta'),
	(49, 3, 'Pink'),
	(50, 3, 'Orange'),
	(51, 3, 'Brown'),
	(52, 4, '1.8 Ohms'),
	(53, 4, '2.4 Ohms'),
	(54, 4, '2.8 Ohms');
/*!40000 ALTER TABLE `attribute_value` ENABLE KEYS */;


-- Dumping structure for table wildvapor.carts
DROP TABLE IF EXISTS `carts`;
CREATE TABLE IF NOT EXISTS `carts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` char(32) NOT NULL,
  `quantity` tinyint(3) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `attributes` text,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8 COMMENT='Table for the shopping cart.';

-- Dumping data for table wildvapor.carts: ~2 rows (approximately)
DELETE FROM `carts`;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;


-- Dumping structure for table wildvapor.categories
DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table wildvapor.categories: ~3 rows (approximately)
DELETE FROM `categories`;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`, `description`) VALUES
	(1, 'accessories', 'This are the accessories'),
	(2, 'eliquids', 'This are the eliquids'),
	(3, 'kits', 'This are our Starter Kits');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;


-- Dumping structure for table wildvapor.eliquids_kits
DROP TABLE IF EXISTS `eliquids_kits`;
CREATE TABLE IF NOT EXISTS `eliquids_kits` (
  `kit_id` int(10) NOT NULL,
  `eliquid_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table wildvapor.eliquids_kits: ~3 rows (approximately)
DELETE FROM `eliquids_kits`;
/*!40000 ALTER TABLE `eliquids_kits` DISABLE KEYS */;
INSERT INTO `eliquids_kits` (`kit_id`, `eliquid_id`, `quantity`) VALUES
	(15, 13, 1),
	(16, 14, 1),
	(17, 14, 1);
/*!40000 ALTER TABLE `eliquids_kits` ENABLE KEYS */;


-- Dumping structure for table wildvapor.orders
DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` char(32) NOT NULL,
  `total` decimal(7,2) unsigned DEFAULT NULL,
  `tax` decimal(7,2) unsigned DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='Table for the user orders.';

-- Dumping data for table wildvapor.orders: ~6 rows (approximately)
DELETE FROM `orders`;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `user_id`, `total`, `tax`, `order_date`) VALUES
	(1, 'a42fc1cce9b2632b68467e14b60af5b9', 184.00, 12.04, '2013-08-07 12:05:01'),
	(2, 'a42fc1cce9b2632b68467e14b60af5b9', 27.81, 1.82, '2013-08-07 12:12:07'),
	(3, 'a42fc1cce9b2632b68467e14b60af5b9', 106.99, 7.00, '2013-08-07 12:22:40'),
	(4, 'a42fc1cce9b2632b68467e14b60af5b9', 27.81, 1.82, '2013-08-07 13:54:13'),
	(5, 'a42fc1cce9b2632b68467e14b60af5b9', 27.81, 1.82, '2013-08-07 13:57:29'),
	(6, 'a42fc1cce9b2632b68467e14b60af5b9', 94.12, 6.16, '2013-08-07 14:12:36');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;


-- Dumping structure for table wildvapor.order_contents
DROP TABLE IF EXISTS `order_contents`;
CREATE TABLE IF NOT EXISTS `order_contents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `quantity` tinyint(3) unsigned NOT NULL,
  `price_per` decimal(5,2) unsigned NOT NULL,
  `attributes` varchar(1000) DEFAULT NULL,
  `ship_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='Table for the contents of one order';

-- Dumping data for table wildvapor.order_contents: ~10 rows (approximately)
DELETE FROM `order_contents`;
/*!40000 ALTER TABLE `order_contents` DISABLE KEYS */;
INSERT INTO `order_contents` (`id`, `order_id`, `product_id`, `quantity`, `price_per`, `attributes`, `ship_date`) VALUES
	(1, 1, 5, 1, 35.99, NULL, NULL),
	(2, 1, 7, 1, 25.99, NULL, NULL),
	(3, 1, 13, 1, 9.99, '[Flavour: Red Hots], [Strength: 12mg per milimeter]', NULL),
	(4, 1, 17, 1, 99.99, '[1 x AC to USB wall adapter.], [2 x 1100 mAh battery.], [1 x USB charger for battery.], [2 x Atomizer with 1.8 Ohms coil .], [2 x Extra Coil.], [1 x Leather Case.], [1 x Wild 30ml e-liquid bottle. Flavour: Circus Cotton Candy Strength: 24mg per milimeter]', NULL),
	(8, 2, 7, 1, 25.99, NULL, NULL),
	(9, 3, 17, 1, 99.99, '[1 x AC to USB wall adapter.], [2 x 1100 mAh battery.], [1 x USB charger for battery.], [2 x Atomizer with 1.8 Ohms coil .], [2 x Extra Coil.], [1 x Leather Case.], [1 x Wild 30ml e-liquid bottle. Flavour: Red Hots Strength: 18mg per milimeter]', NULL),
	(10, 4, 7, 1, 25.99, NULL, NULL),
	(11, 5, 7, 1, 25.99, NULL, NULL),
	(12, 6, 7, 3, 25.99, NULL, NULL),
	(13, 6, 13, 1, 9.99, '[Flavour: Green Apple], [Strength: 12mg per milimeter]', NULL);
/*!40000 ALTER TABLE `order_contents` ENABLE KEYS */;


-- Dumping structure for table wildvapor.products
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` tinytext NOT NULL,
  `image` varchar(100) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `stock` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  FULLTEXT KEY `name_description` (`name`,`description`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- Dumping data for table wildvapor.products: 17 rows
DELETE FROM `products`;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `image`, `price`, `stock`, `created`) VALUES
	(1, 1, 'AC to USB wall adapter', 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'accessory01.jpg', 5.99, 10, '2013-07-25 17:44:22'),
	(2, 1, 'Lanyard', 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'accessory02.jpg', 5.99, 10, '2013-07-25 17:44:22'),
	(3, 1, 'Replaceable Coil', 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'accessory03.jpg', 4.99, 10, '2013-07-25 17:44:22'),
	(4, 1, '12V car to USB adapter', 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'accessory01.jpg', 5.99, 10, '2013-07-25 17:44:22'),
	(5, 1, '1100 mAh variable voltage battery with LCD screen', 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'accessory02.jpg', 35.99, 9, '2013-07-25 17:44:22'),
	(6, 1, '900 mAh battery', 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'accessory03.jpg', 19.99, 10, '2013-07-25 17:44:22'),
	(7, 1, '1100 mAh battery', 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'accessory01.jpg', 25.99, 5, '2013-07-25 17:44:22'),
	(8, 1, 'Atomizer with replaceable coil + ring adapter', 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'accessory02.jpg', 19.99, 10, '2013-07-25 17:44:22'),
	(9, 1, 'USB charger for battery', 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'accessory03.jpg', 9.99, 10, '2013-07-25 17:44:22'),
	(10, 1, 'Atomizer with 1.8 Ohms coil ', 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'accessory01.jpg', 9.99, 10, '2013-07-25 19:04:22'),
	(11, 1, 'Extra Coil', 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'accessory02.jpg', 9.99, 10, '2013-07-25 19:09:34'),
	(12, 1, 'Leather Case', 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'accessory03.jpg', 9.99, 10, '2013-07-25 19:10:49'),
	(13, 2, 'Wild 10ml e-liquid bottle ', 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'eliquid01.jpg', 9.99, 8, '2013-07-27 10:24:52'),
	(14, 2, 'Wild 30ml e-liquid bottle', 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'eliquid01.jpg', 15.99, 10, '2013-07-27 10:25:35'),
	(15, 3, 'Smoky Wild', 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'kit01.jpg', 39.99, 10, '2013-07-25 17:47:12'),
	(16, 3, 'Wild Vapor', 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'kit02.jpg', 59.99, 10, '2013-07-25 17:47:12'),
	(17, 3, 'Big Vapor', 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'kit03.jpg', 99.99, 8, '2013-07-25 17:47:12');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;


-- Dumping structure for table wildvapor.product_attribute
DROP TABLE IF EXISTS `product_attribute`;
CREATE TABLE IF NOT EXISTS `product_attribute` (
  `product_id` int(10) unsigned NOT NULL,
  `attribute_value_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`product_id`,`attribute_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='associates attribute values to products\r\n';

-- Dumping data for table wildvapor.product_attribute: ~92 rows (approximately)
DELETE FROM `product_attribute`;
/*!40000 ALTER TABLE `product_attribute` DISABLE KEYS */;
INSERT INTO `product_attribute` (`product_id`, `attribute_value_id`) VALUES
	(2, 42),
	(2, 43),
	(2, 44),
	(2, 45),
	(2, 46),
	(2, 47),
	(2, 48),
	(2, 49),
	(2, 50),
	(2, 51),
	(13, 1),
	(13, 2),
	(13, 3),
	(13, 4),
	(13, 5),
	(13, 6),
	(13, 7),
	(13, 8),
	(13, 9),
	(13, 10),
	(13, 11),
	(13, 12),
	(13, 13),
	(13, 14),
	(13, 15),
	(13, 16),
	(13, 17),
	(13, 18),
	(13, 19),
	(13, 20),
	(13, 21),
	(13, 22),
	(13, 23),
	(13, 24),
	(13, 25),
	(13, 26),
	(13, 27),
	(13, 28),
	(13, 29),
	(13, 30),
	(13, 31),
	(13, 32),
	(13, 33),
	(13, 34),
	(13, 35),
	(13, 36),
	(13, 37),
	(13, 38),
	(13, 39),
	(13, 40),
	(13, 41),
	(14, 1),
	(14, 2),
	(14, 3),
	(14, 4),
	(14, 5),
	(14, 6),
	(14, 7),
	(14, 8),
	(14, 9),
	(14, 10),
	(14, 11),
	(14, 12),
	(14, 13),
	(14, 14),
	(14, 15),
	(14, 16),
	(14, 17),
	(14, 18),
	(14, 19),
	(14, 20),
	(14, 21),
	(14, 22),
	(14, 23),
	(14, 24),
	(14, 25),
	(14, 26),
	(14, 27),
	(14, 28),
	(14, 29),
	(14, 30),
	(14, 31),
	(14, 32),
	(14, 33),
	(14, 34),
	(14, 35),
	(14, 36),
	(14, 37),
	(14, 38),
	(14, 39),
	(14, 40),
	(14, 41);
/*!40000 ALTER TABLE `product_attribute` ENABLE KEYS */;


-- Dumping structure for table wildvapor.reviews
DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `rating` tinyint(1) unsigned NOT NULL,
  `review` mediumtext NOT NULL,
  `reviewer_name` varchar(100) NOT NULL,
  `reviewer_email` varchar(100) NOT NULL,
  `review_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `review_date` (`review_date`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Dumping data for table wildvapor.reviews: ~17 rows (approximately)
DELETE FROM `reviews`;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` (`id`, `product_id`, `rating`, `review`, `reviewer_name`, `reviewer_email`, `review_date`) VALUES
	(3, 7, 4, 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'Julio C. Villasante', 'jvillasantegomez@gmail.com', '2013-07-31 12:28:47'),
	(4, 7, 3, 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'Alejandro GÃ³mez', 'jvillasantegomez@gmail.com', '2013-07-31 12:28:55'),
	(5, 7, 5, 'Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'Glenda', 'gpinariesco@gmail.com', '2013-07-31 12:47:47'),
	(6, 4, 2, 'Nice product, But can be better.', 'Julio C. Villasante', 'jvillasantegomez@gmail.com', '2013-07-31 15:06:18'),
	(7, 17, 2, 'This is a great product for starters. Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula. Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula. Vivamus orci sem, consectetur ut vestibulum a, semper ac dui. Aenean tellus nisl, commodo eu aliquet ut, pulvinar ut sapien. Praesent sollicitudin, nibh nec mattis lobortis, dui massa eleifend magna, eget consequat risus felis dignissim ligula.', 'Julio C. Villasante', 'jvillasantegomez@gmail.com', '2013-07-31 15:14:14'),
	(8, 13, 5, 'this is a very great prod', 'kylie', 'ggg@ff.com', '2013-07-31 15:26:42'),
	(9, 13, 3, 'not so good', 'r6ur', 'de@cuu.com', '2013-07-31 15:30:58'),
	(10, 13, 2, 'ddd', 'xcds', 'w@gg.cu', '2013-07-31 15:34:46'),
	(11, 5, 4, 'fdsadfasdf', 'Julio', 'jvillasantegomez@gmail.com', '2013-07-31 15:38:04'),
	(12, 13, 3, 'sfsfsf', 's', 's@ss.com', '2013-07-31 15:39:32'),
	(13, 5, 4, 'fdsafasdfasdf', 'Julio', 'jvillasantegomez@gmail.com', '2013-07-31 15:41:54'),
	(14, 13, 4, 'sdfja asd;fha; sdfasd;fasdf', 'Julio', 'jvillasantegomez@gmail.com', '2013-07-31 15:43:39'),
	(15, 13, 1, 'chachacha', 'a', 'a@c.com', '2013-07-31 15:46:32'),
	(16, 7, 4, 'sdfasdfasdfasdf', 'Julio C. Villasante', 'jvillasantegomez@gmail.com', '2013-08-01 15:32:19'),
	(17, 7, 4, 'dfsafasdf', 'Alejandro GÃ³mez', 'gpinariesco@gmail.com', '2013-08-02 08:59:39'),
	(18, 17, 4, 'fdasfasdfasdf', 'Alejandro GÃ³mez', 'jvillasantegomez@gmail.com', '2013-08-02 12:23:42'),
	(19, 17, 3, 'fdsadfasdf', 'Julio César', 'jvillasantegomez@gmail.com', '2013-08-05 20:24:20');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;


-- Dumping structure for table wildvapor.review_ratings
DROP TABLE IF EXISTS `review_ratings`;
CREATE TABLE IF NOT EXISTS `review_ratings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `review_id` int(10) unsigned NOT NULL,
  `helpful` tinyint(1) unsigned NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `review_id` (`review_id`),
  KEY `date_entered` (`date_entered`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Dumping data for table wildvapor.review_ratings: ~14 rows (approximately)
DELETE FROM `review_ratings`;
/*!40000 ALTER TABLE `review_ratings` DISABLE KEYS */;
INSERT INTO `review_ratings` (`id`, `review_id`, `helpful`, `date_entered`) VALUES
	(1, 3, 1, '2013-07-31 12:28:47'),
	(2, 4, 1, '2013-07-31 12:28:55'),
	(3, 4, 1, '2013-07-31 12:34:35'),
	(4, 5, 1, '2013-07-31 12:47:47'),
	(5, 6, 1, '2013-07-31 15:06:18'),
	(6, 7, 1, '2013-07-31 15:14:14'),
	(7, 8, 1, '2013-07-31 15:26:42'),
	(8, 9, 1, '2013-07-31 15:30:58'),
	(9, 10, 1, '2013-07-31 15:34:46'),
	(10, 11, 1, '2013-07-31 15:38:04'),
	(11, 12, 1, '2013-07-31 15:39:32'),
	(12, 13, 1, '2013-07-31 15:41:54'),
	(13, 14, 1, '2013-07-31 15:43:39'),
	(14, 15, 1, '2013-07-31 15:46:32');
/*!40000 ALTER TABLE `review_ratings` ENABLE KEYS */;


-- Dumping structure for table wildvapor.sales
DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `price` decimal(5,2) unsigned DEFAULT NULL,
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COMMENT='Table for the products that are on sale.';

-- Dumping data for table wildvapor.sales: ~17 rows (approximately)
DELETE FROM `sales`;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` (`id`, `product_id`, `price`, `start_date`, `end_date`) VALUES
	(18, 1, NULL, '2013-07-30 19:09:15', NULL),
	(19, 2, NULL, '2013-07-30 19:09:15', NULL),
	(20, 3, NULL, '2013-07-30 19:09:15', NULL),
	(21, 4, NULL, '2013-07-30 19:09:15', NULL),
	(22, 5, NULL, '2013-07-30 19:09:15', NULL),
	(23, 6, NULL, '2013-07-30 19:09:15', NULL),
	(24, 7, NULL, '2013-07-30 19:09:15', NULL),
	(25, 8, NULL, '2013-07-30 19:09:15', NULL),
	(26, 9, NULL, '2013-07-30 19:09:15', NULL),
	(27, 10, NULL, '2013-07-30 19:09:15', NULL),
	(28, 11, NULL, '2013-07-30 19:09:15', NULL),
	(29, 12, NULL, '2013-07-30 19:09:15', NULL),
	(30, 13, NULL, '2013-07-30 19:09:15', NULL),
	(31, 14, NULL, '2013-07-30 19:09:15', NULL),
	(32, 15, NULL, '2013-07-30 19:09:15', NULL),
	(33, 16, NULL, '2013-07-30 19:09:15', NULL),
	(34, 17, NULL, '2013-07-30 19:09:15', NULL);
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;


-- Dumping structure for table wildvapor.states
DROP TABLE IF EXISTS `states`;
CREATE TABLE IF NOT EXISTS `states` (
  `abbreviation` varchar(2) NOT NULL,
  `state` varchar(80) NOT NULL,
  PRIMARY KEY (`abbreviation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='US States Table.';

-- Dumping data for table wildvapor.states: ~51 rows (approximately)
DELETE FROM `states`;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` (`abbreviation`, `state`) VALUES
	('AK', 'Alaska'),
	('AL', 'Alabama'),
	('AR', 'Arkansas'),
	('AZ', 'Arizona'),
	('CA', 'California'),
	('CO', 'Colorado'),
	('CT', 'Connecticut'),
	('DC', 'District of Columbia'),
	('DE', 'Delaware'),
	('FL', 'Florida'),
	('GA', 'Georgia'),
	('HI', 'Hawaii'),
	('IA', 'Iowa'),
	('ID', 'Idaho'),
	('IL', 'Illinois'),
	('IN', 'Indiana'),
	('KS', 'Kansas'),
	('KY', 'Kentucky'),
	('LA', 'Louisiana'),
	('MA', 'Massachusetts'),
	('MD', 'Maryland'),
	('ME', 'Maine'),
	('MI', 'Michigan'),
	('MN', 'Minnesota'),
	('MO', 'Missouri'),
	('MS', 'Mississippi'),
	('MT', 'Montana'),
	('NC', 'North Carolina'),
	('ND', 'North Dakota'),
	('NE', 'Nebraska'),
	('NH', 'New Hampshire'),
	('NJ', 'New Jersey'),
	('NM', 'New Mexico'),
	('NV', 'Nevada'),
	('NY', 'New York'),
	('OH', 'Ohio'),
	('OK', 'Oklahoma'),
	('OR', 'Oregon'),
	('PA', 'Pennsylvania'),
	('RI', 'Rhode Island'),
	('SC', 'South Carolina'),
	('SD', 'South Dakota'),
	('TN', 'Tennessee'),
	('TX', 'Texas'),
	('UT', 'Utah'),
	('VA', 'Virginia'),
	('VT', 'Vermont'),
	('WA', 'Washington'),
	('WI', 'Wisconsin'),
	('WV', 'West Virginia'),
	('WY', 'Wyoming');
/*!40000 ALTER TABLE `states` ENABLE KEYS */;


-- Dumping structure for table wildvapor.transactions
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `type` varchar(20) NOT NULL,
  `amount` decimal(7,2) unsigned NOT NULL,
  `response_code` tinyint(1) unsigned NOT NULL,
  `response_reason` tinytext NOT NULL,
  `transaction_id` bigint(20) unsigned NOT NULL,
  `response_text` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table for the transactions.';

-- Dumping data for table wildvapor.transactions: ~0 rows (approximately)
DELETE FROM `transactions`;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;


-- Dumping structure for table wildvapor.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` char(32) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email` varchar(80) NOT NULL,
  `username` varchar(30) NOT NULL,
  `type` enum('member','admin') NOT NULL,
  `password` varchar(64) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address1` varchar(80) DEFAULT NULL,
  `address2` varchar(80) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `zip_code` mediumint(5) unsigned zerofill DEFAULT NULL,
  `country` varchar(20) DEFAULT 'US',
  `state` char(2) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `username` (`username`),
  KEY `password` (`password`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table for the users.';

-- Dumping data for table wildvapor.users: ~2 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `username`, `type`, `password`, `phone`, `address1`, `address2`, `city`, `zip_code`, `country`, `state`, `created`, `modified`) VALUES
	('7479bdd914b326e8ac54d39ebcbdda7d', 'Glenda', 'Pina', 'gpinariesco@gmail.com', 'gpina', 'member', '43b66fbeb772db2e81bb5bfe29d2da2f9ff8348ac725a69c45f014e4c5ffc4a9', '1234567890', '15 entre 78 y 80', '15 y 78', 'C. Habana', 10400, 'US', 'AK', '2013-08-08 08:37:45', '2013-08-08 08:37:45'),
	('a42fc1cce9b2632b68467e14b60af5b9', 'Julio Cesar', 'Villasante', 'jvillasantegomez@gmail.com', 'jvillasante', 'member', '43b66fbeb772db2e81bb5bfe29d2da2f9ff8348ac725a69c45f014e4c5ffc4a9', '123 456 7890', NULL, NULL, NULL, NULL, NULL, NULL, '2013-08-07 10:02:42', '2013-08-07 10:02:42');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for table wildvapor.wishlists
DROP TABLE IF EXISTS `wishlists`;
CREATE TABLE IF NOT EXISTS `wishlists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` char(32) DEFAULT NULL,
  `quantity` tinyint(3) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `attributes` varchar(1000) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Table for the wishlists.';

-- Dumping data for table wildvapor.wishlists: ~2 rows (approximately)
DELETE FROM `wishlists`;
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
INSERT INTO `wishlists` (`id`, `user_id`, `quantity`, `product_id`, `attributes`, `date_created`, `date_modified`) VALUES
	(1, 'a42fc1cce9b2632b68467e14b60af5b9', 1, 17, '[1 x AC to USB wall adapter.], [2 x 1100 mAh battery.], [1 x USB charger for battery.], [2 x Atomizer with 1.8 Ohms coil .], [2 x Extra Coil.], [1 x Leather Case.], [1 x Wild 30ml e-liquid bottle. Flavour: Twisted Java Strength: 12mg per milimeter]', '2013-08-07 14:14:55', NULL),
	(2, 'a42fc1cce9b2632b68467e14b60af5b9', 1, 7, NULL, '2013-08-07 14:15:01', NULL);
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
