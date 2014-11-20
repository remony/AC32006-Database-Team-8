<?php
$result = getDatabase()->execute("
    /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
    /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
    /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
    /*!40101 SET NAMES utf8 */;
    /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
    /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
    /*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

    CREATE TABLE `cameras` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `brand` varchar(20) NOT NULL,
      `model_name` varchar(20) NOT NULL,
      `price` int(11) NOT NULL,
      `battery_type` varchar(45) NOT NULL,
      `megapixels` int(11) NOT NULL,
      `can_do_video` tinyint(1) NOT NULL,
      `has_flash` tinyint(1) NOT NULL,
      `resolution` int(11) NOT NULL,
      `type_id` int(11) NOT NULL,
      `storage_id` int(11) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `fk_cameras_type_idx` (`type_id`),
      KEY `fk_cameras_storage_idx` (`storage_id`),
      KEY `price` (`price`),
      CONSTRAINT `fk_cameras_storage` FOREIGN KEY (`storage_id`) REFERENCES `storage` (`id`),
      CONSTRAINT `fk_cameras_type` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



    # Dump of table countries
    # ------------------------------------------------------------

    CREATE TABLE `countries` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(45) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



    # Dump of table customer_has_hobby
    # ------------------------------------------------------------

    CREATE TABLE `customer_has_hobby` (
      `customer_id` int(10) unsigned NOT NULL,
      `hobby_id` int(10) unsigned NOT NULL,
      PRIMARY KEY (`customer_id`,`hobby_id`),
      KEY `fk_customers_has_hobby_hobby_idx` (`hobby_id`),
      KEY `fk_customers_has_hobby_customers_idx` (`customer_id`),
      CONSTRAINT `fk_customer_has_hobby_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
      CONSTRAINT `fk_customer_has_hobby_hobby` FOREIGN KEY (`hobby_id`) REFERENCES `hobby` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



    # Dump of table customer_has_profession
    # ------------------------------------------------------------

    CREATE TABLE `customer_has_profession` (
      `customer_id` int(10) unsigned NOT NULL,
      `profession_id` int(10) unsigned NOT NULL,
      PRIMARY KEY (`customer_id`,`profession_id`),
      KEY `fk_CUSTOMERS_has_PROFESSION_PROFESSION1_idx` (`profession_id`),
      KEY `fk_customers_has_profession_customers_idx` (`customer_id`),
      CONSTRAINT `fk_customer_has_profession_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
      CONSTRAINT `fk_customer_has_profession_profession` FOREIGN KEY (`profession_id`) REFERENCES `profession` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



    # Dump of table customers
    # ------------------------------------------------------------

    CREATE TABLE `customers` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `first_name` varchar(20) NOT NULL,
      `last_name` varchar(20) NOT NULL,
      `date_of_birth` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `gender` enum('male','female') NOT NULL,
      `country_id` int(11) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `fk_customers_countries_idx` (`country_id`),
      CONSTRAINT `fk_customers_countries` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



    # Dump of table groups
    # ------------------------------------------------------------

    CREATE TABLE `groups` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(45) NOT NULL,
      `read` tinyint(1) NOT NULL DEFAULT '0',
      `write` tinyint(1) NOT NULL DEFAULT '0',
      `delete` tinyint(1) NOT NULL DEFAULT '0',
      `update` tinyint(1) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



    # Dump of table hobby
    # ------------------------------------------------------------

    CREATE TABLE `hobby` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `title` varchar(45) NOT NULL COMMENT 'The name of the customers hobby. (Swimming, photography, etc.)\n',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



    # Dump of table lens
    # ------------------------------------------------------------

    CREATE TABLE `lens` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `type` varchar(45) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



    # Dump of table profession
    # ------------------------------------------------------------

    CREATE TABLE `profession` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `title` varchar(45) NOT NULL COMMENT 'The title of the profession (Photographer)',
      `salary` int(11) NOT NULL COMMENT 'Avg of how much earning',
      `years` int(11) NOT NULL COMMENT 'How many years worked in area',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



    # Dump of table sales
    # ------------------------------------------------------------

    CREATE TABLE `sales` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `date_purchased` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'When was the camera bought',
      `camera_id` int(11) NOT NULL,
      `store_id` int(11) NOT NULL,
      `customer_id` int(10) unsigned NOT NULL,
      PRIMARY KEY (`id`),
      KEY `fk_sales_stores_idx` (`store_id`),
      KEY `fk_sales_customers_idx` (`customer_id`),
      KEY `fk_sales_cameras_idx` (`camera_id`),
      CONSTRAINT `fk_sales_cameras` FOREIGN KEY (`camera_id`) REFERENCES `cameras` (`id`),
      CONSTRAINT `fk_sales_customers` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
      CONSTRAINT `fk_sales_stores` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



    # Dump of table storage
    # ------------------------------------------------------------

    CREATE TABLE `storage` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(45) NOT NULL COMMENT 'Type\n- Compact\n- GoPro\n- DLSR\n- Bridge\n- Disposable\n- Mirror',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



    # Dump of table stores
    # ------------------------------------------------------------

    CREATE TABLE `stores` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(45) NOT NULL COMMENT 'Name of the store.',
      `brand` varchar(45) NOT NULL,
      `size` int(11) NOT NULL COMMENT 'The size of the store in square meeting.',
      `quantity` int(11) NOT NULL,
      `quantity_sold` int(11) NOT NULL,
      `country_id` int(11) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `fk_store_countries_idx` (`country_id`),
      CONSTRAINT `fk_store_countries` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



    # Dump of table type
    # ------------------------------------------------------------

    CREATE TABLE `type` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(20) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



    # Dump of table type_has_lens
    # ------------------------------------------------------------

    CREATE TABLE `type_has_lens` (
      `type_id` int(11) NOT NULL,
      `lens_id` int(11) NOT NULL,
      PRIMARY KEY (`type_id`,`lens_id`),
      KEY `fk_type_has_lens_lens_idx` (`lens_id`),
      KEY `fk_type_has_lens_type_idx` (`type_id`),
      CONSTRAINT `fk_type_has_lens_lens` FOREIGN KEY (`lens_id`) REFERENCES `lens` (`id`),
      CONSTRAINT `fk_type_has_lens_type` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



    # Dump of table users
    # ------------------------------------------------------------

    CREATE TABLE `users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `username` varchar(45) NOT NULL,
      `password` varchar(45) NOT NULL,
      `id_group` int(11) NOT NULL,
      `access_token` varchar(64) DEFAULT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `username` (`username`),
      KEY `fk_USERS_GROUPS1_idx` (`id_group`),
      CONSTRAINT `fk_users_groups` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    /*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
    /*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
    /*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
    /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
    /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
    /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
");

$result = getDatabase()->execute("
    /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
    /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
    /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
    /*!40101 SET NAMES utf8 */;
    /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
    /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
    /*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

    CREATE PROCEDURE `sessionUser`(access_token VARCHAR(64))
    BEGIN
        SELECT `users`.`id`, `users`.`username`, `users`.`access_token`, `groups`.`name` 'group_name', `groups`.`read`, `groups`.`write`, `groups`.`delete`, `groups`.`update` FROM users
        INNER JOIN `groups` ON `users`.`id_group` = `groups`.`id`
        WHERE `users`.`access_token` = access_token;
    END;;

    /*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
    /*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
    /*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
    /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
    /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
    /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
");

$result = getDatabase()->execute("
    /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
    /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
    /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
    /*!40101 SET NAMES utf8 */;
    /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
    /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
    /*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

    CREATE PROCEDURE `signIn`(username VARCHAR(20), pass VARCHAR(64))
    BEGIN
        DECLARE user_id			BIGINT(10)	DEFAULT 0;
        DECLARE db_pass			VARCHAR(64)	DEFAULT '';
        DECLARE random			VARCHAR(64)	DEFAULT '';
        DECLARE access_token	VARCHAR(64)	DEFAULT '';

        SET user_id = (SELECT `users`.`id` FROM `users` WHERE `users`.`username` LIKE username);
        SET db_pass = (SELECT `users`.`password` FROM `users` WHERE `users`.`username` LIKE username);

        IF db_pass = sha1(pass) THEN
            SELECT `users`.`access_token` FROM `users` WHERE `users`.`username` = username INTO access_token;

            IF access_token = '' THEN
                SELECT concat('AC32006 - ', username, ' - ', FLOOR((RAND() * 900000000))) INTO random;
                SELECT sha1(random) INTO access_token;
            END IF;

            UPDATE `users` SET `users`.`access_token` = access_token WHERE `users`.`username` = username;
        ELSE
            select null INTO access_token;
        END IF;

        SELECT `users`.`id`, `users`.`username`, `users`.`access_token`, `groups`.`name` 'group_name', `groups`.`read`, `groups`.`write`, `groups`.`delete`, `groups`.`update` FROM users
        INNER JOIN `groups` ON `users`.`id_group` = `groups`.`id`
        WHERE `users`.`access_token` = access_token;
    END;;

    /*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
    /*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
    /*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
    /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
    /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
    /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
");

$result = getDatabase()->execute("
    /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
    /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
    /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
    /*!40101 SET NAMES utf8 */;
    /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
    /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
    /*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

    CREATE PROCEDURE `registerUser`(theUsername VARCHAR(20), thePassword VARCHAR(64))
    BEGIN
        DECLARE db_pass			VARCHAR(64)	DEFAULT '';
        DECLARE random			VARCHAR(64)	DEFAULT '';
        DECLARE access_token	VARCHAR(64)	DEFAULT '';
        DECLARE group_id		INT(11)	DEFAULT 0;

        DECLARE CONTINUE HANDLER FOR 1062 SELECT 'duplicate key occurred' AS 'error';
        DECLARE CONTINUE HANDLER FOR 1452 SELECT 'invalid group selected' AS 'error';
        DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SELECT 'unknown error detected' AS 'error';

        SELECT concat('AC32006 - ', theUsername, ' - ', FLOOR((RAND() * 900000000))) INTO random;
        SELECT sha1(random) INTO access_token;

        INSERT INTO users (`username`, `password`, `id_group`, `access_token`) VALUES (theUsername, sha1(thePassword), group_id, access_token);

        SELECT `users`.`id`, `users`.`username`, `users`.`access_token`, `groups`.`name` 'group_name', `groups`.`read`, `groups`.`write`, `groups`.`delete`, `groups`.`update` FROM users
        INNER JOIN `groups` ON `users`.`id_group` = `groups`.`id`
        WHERE `users`.`access_token` = access_token;
    END;;

    /*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
    /*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
    /*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
    /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
    /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
    /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
");

$result = getDatabase()->execute("
    /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
    /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
    /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
    /*!40101 SET NAMES utf8 */;
    /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
    /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
    /*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

    INSERT INTO `groups` (`id`, `name`, `read`, `write`, `delete`, `update`)
    VALUES
    (0, 'client', 1, 0, 0, 0),
    (1, 'admins', 1, 1, 1, 1),
    (2, 'manager', 1, 1, 0, 1),
    (3, 'employee', 1, 1, 0, 0);

    /*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
    /*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
    /*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
    /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
    /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
    /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
");

$result = getDatabase()->execute("
    /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
    /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
    /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
    /*!40101 SET NAMES utf8 */;
    /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
    /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
    /*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

    INSERT INTO `countries` (`id`, `name`)
    VALUES
	(1, 'Andorra'),
	(2, 'United Arab Emirates'),
	(3, 'Afghanistan'),
	(4, 'Antigua and Barbuda'),
	(5, 'Anguilla'),
	(6, 'Albania'),
	(7, 'Armenia'),
	(8, 'Angola'),
	(9, 'Antarctica'),
	(10, 'Argentina'),
	(11, 'American Samoa'),
	(12, 'Austria'),
	(13, 'Australia'),
	(14, 'Aruba'),
	(15, 'Aland Islands'),
	(16, 'Azerbaijan'),
	(17, 'Bosnia and Herzegovina'),
	(18, 'Barbados'),
	(19, 'Bangladesh'),
	(20, 'Belgium'),
	(21, 'Burkina Faso'),
	(22, 'Bulgaria'),
	(23, 'Bahrain'),
	(24, 'Burundi'),
	(25, 'Benin'),
	(26, 'Saint Barthelemy'),
	(27, 'Bermuda'),
	(28, 'Brunei'),
	(29, 'Bolivia'),
	(30, 'Bonaire, Saint Eustatius and Saba '),
	(31, 'Brazil'),
	(32, 'Bahamas'),
	(33, 'Bhutan'),
	(34, 'Bouvet Island'),
	(35, 'Botswana'),
	(36, 'Belarus'),
	(37, 'Belize'),
	(38, 'Canada'),
	(39, 'Cocos Islands'),
	(40, 'Democratic Republic of the Congo'),
	(41, 'Central African Republic'),
	(42, 'Republic of the Congo'),
	(43, 'Switzerland'),
	(44, 'Ivory Coast'),
	(45, 'Cook Islands'),
	(46, 'Chile'),
	(47, 'Cameroon'),
	(48, 'China'),
	(49, 'Colombia'),
	(50, 'Costa Rica'),
	(51, 'Cuba'),
	(52, 'Cape Verde'),
	(53, 'Curacao'),
	(54, 'Christmas Island'),
	(55, 'Cyprus'),
	(56, 'Czech Republic'),
	(57, 'Germany'),
	(58, 'Djibouti'),
	(59, 'Denmark'),
	(60, 'Dominica'),
	(61, 'Dominican Republic'),
	(62, 'Algeria'),
	(63, 'Ecuador'),
	(64, 'Estonia'),
	(65, 'Egypt'),
	(66, 'Western Sahara'),
	(67, 'Eritrea'),
	(68, 'Spain'),
	(69, 'Ethiopia'),
	(70, 'Finland'),
	(71, 'Fiji'),
	(72, 'Falkland Islands'),
	(73, 'Micronesia'),
	(74, 'Faroe Islands'),
	(75, 'France'),
	(76, 'Gabon'),
	(77, 'United Kingdom'),
	(78, 'Grenada'),
	(79, 'Georgia'),
	(80, 'French Guiana'),
	(81, 'Guernsey'),
	(82, 'Ghana'),
	(83, 'Gibraltar'),
	(84, 'Greenland'),
	(85, 'Gambia'),
	(86, 'Guinea'),
	(87, 'Guadeloupe'),
	(88, 'Equatorial Guinea'),
	(89, 'Greece'),
	(90, 'South Georgia and the South Sandwich Islands'),
	(91, 'Guatemala'),
	(92, 'Guam'),
	(93, 'Guinea-Bissau'),
	(94, 'Guyana'),
	(95, 'Hong Kong'),
	(96, 'Heard Island and McDonald Islands'),
	(97, 'Honduras'),
	(98, 'Croatia'),
	(99, 'Haiti'),
	(100, 'Hungary'),
	(101, 'Indonesia'),
	(102, 'Ireland'),
	(103, 'Israel'),
	(104, 'Isle of Man'),
	(105, 'India'),
	(106, 'British Indian Ocean Territory'),
	(107, 'Iraq'),
	(108, 'Iran'),
	(109, 'Iceland'),
	(110, 'Italy'),
	(111, 'Jersey'),
	(112, 'Jamaica'),
	(113, 'Jordan'),
	(114, 'Japan'),
	(115, 'Kenya'),
	(116, 'Kyrgyzstan'),
	(117, 'Cambodia'),
	(118, 'Kiribati'),
	(119, 'Comoros'),
	(120, 'Saint Kitts and Nevis'),
	(121, 'North Korea'),
	(122, 'South Korea'),
	(123, 'Kosovo'),
	(124, 'Kuwait'),
	(125, 'Cayman Islands'),
	(126, 'Kazakhstan'),
	(127, 'Laos'),
	(128, 'Lebanon'),
	(129, 'Saint Lucia'),
	(130, 'Liechtenstein'),
	(131, 'Sri Lanka'),
	(132, 'Liberia'),
	(133, 'Lesotho'),
	(134, 'Lithuania'),
	(135, 'Luxembourg'),
	(136, 'Latvia'),
	(137, 'Libya'),
	(138, 'Morocco'),
	(139, 'Monaco'),
	(140, 'Moldova'),
	(141, 'Montenegro'),
	(142, 'Saint Martin'),
	(143, 'Madagascar'),
	(144, 'Marshall Islands'),
	(145, 'Macedonia'),
	(146, 'Mali'),
	(147, 'Myanmar'),
	(148, 'Mongolia'),
	(149, 'Macao'),
	(150, 'Northern Mariana Islands'),
	(151, 'Martinique'),
	(152, 'Mauritania'),
	(153, 'Montserrat'),
	(154, 'Malta'),
	(155, 'Mauritius'),
	(156, 'Maldives'),
	(157, 'Malawi'),
	(158, 'Mexico'),
	(159, 'Malaysia'),
	(160, 'Mozambique'),
	(161, 'Namibia'),
	(162, 'New Caledonia'),
	(163, 'Niger'),
	(164, 'Norfolk Island'),
	(165, 'Nigeria'),
	(166, 'Nicaragua'),
	(167, 'Netherlands'),
	(168, 'Norway'),
	(169, 'Nepal'),
	(170, 'Nauru'),
	(171, 'Niue'),
	(172, 'New Zealand'),
	(173, 'Oman'),
	(174, 'Panama'),
	(175, 'Peru'),
	(176, 'French Polynesia'),
	(177, 'Papua New Guinea'),
	(178, 'Philippines'),
	(179, 'Pakistan'),
	(180, 'Poland'),
	(181, 'Saint Pierre and Miquelon'),
	(182, 'Pitcairn'),
	(183, 'Puerto Rico'),
	(184, 'Palestinian Territory'),
	(185, 'Portugal'),
	(186, 'Palau'),
	(187, 'Paraguay'),
	(188, 'Qatar'),
	(189, 'Reunion'),
	(190, 'Romania'),
	(191, 'Serbia'),
	(192, 'Russia'),
	(193, 'Rwanda'),
	(194, 'Saudi Arabia'),
	(195, 'Solomon Islands'),
	(196, 'Seychelles'),
	(197, 'Sudan'),
	(198, 'South Sudan'),
	(199, 'Sweden'),
	(200, 'Singapore'),
	(201, 'Saint Helena'),
	(202, 'Slovenia'),
	(203, 'Svalbard and Jan Mayen'),
	(204, 'Slovakia'),
	(205, 'Sierra Leone'),
	(206, 'San Marino'),
	(207, 'Senegal'),
	(208, 'Somalia'),
	(209, 'Suriname'),
	(210, 'Sao Tome and Principe'),
	(211, 'El Salvador'),
	(212, 'Sint Maarten'),
	(213, 'Syria'),
	(214, 'Swaziland'),
	(215, 'Turks and Caicos Islands'),
	(216, 'Chad'),
	(217, 'French Southern Territories'),
	(218, 'Togo'),
	(219, 'Thailand'),
	(220, 'Tajikistan'),
	(221, 'Tokelau'),
	(222, 'East Timor'),
	(223, 'Turkmenistan'),
	(224, 'Tunisia'),
	(225, 'Tonga'),
	(226, 'Turkey'),
	(227, 'Trinidad and Tobago'),
	(228, 'Tuvalu'),
	(229, 'Taiwan'),
	(230, 'Tanzania'),
	(231, 'Ukraine'),
	(232, 'Uganda'),
	(233, 'United States Minor Outlying Islands'),
	(234, 'United States'),
	(235, 'Uruguay'),
	(236, 'Uzbekistan'),
	(237, 'Vatican'),
	(238, 'Saint Vincent and the Grenadines'),
	(239, 'Venezuela'),
	(240, 'British Virgin Islands'),
	(241, 'U.S. Virgin Islands'),
	(242, 'Vietnam'),
	(243, 'Vanuatu'),
	(244, 'Wallis and Futuna'),
	(245, 'Samoa'),
	(246, 'Yemen'),
	(247, 'Mayotte'),
	(248, 'South Africa'),
	(249, 'Zambia'),
	(250, 'Zimbabwe'),
	(251, 'Serbia and Montenegro'),
	(252, 'Netherlands Antilles');

    /*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
    /*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
    /*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
    /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
    /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
    /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

    /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=1 */;
");

$result = getDatabase() -> execute ("
    /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
    /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
    /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
    /*!40101 SET NAMES utf8 */;
    /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
    /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
    /*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

    create or replace view `detailed_sales` as select
       `sales`.`id` AS `id`,
       `sales`.`date_purchased` AS `date_purchased`,
       `cameras`.`brand` AS `brand`,
       `cameras`.`model_name` AS `model_name`,
       `cameras`.`price` AS `price`,
       `cameras`.`battery_type` AS `battery_type`,
       `cameras`.`megapixels` AS `megapixels`,
       `cameras`.`can_do_video` AS `can_do_video`,
       `cameras`.`has_flash` AS `has_flash`,
       `cameras`.`resolution` AS `resolution`,
       `stores`.`name` AS `name`,
       `stores`.`brand` AS `store_brand`,
       `stores`.`size` AS `size`,
       `stores`.`quantity` AS `quantity`,
       `stores`.`quantity_sold` AS `quantity_sold`,
       `customers`.`id` AS `customer_id`,
       `customers`.`first_name` AS `first_name`,
       `customers`.`last_name` AS `last_name`,
       `customers`.`date_of_birth` AS `date_of_birth`,
       `customers`.`gender` AS `gender`,
       `countries`.`name` AS `country`
    FROM `sales`
    left outer join `cameras` on `cameras`.`id` = `sales`.`camera_id`
    left outer join `stores` on `stores`.`id` = `sales`.`store_id`
    left outer join  `customers` on `customers`.`id` = `sales`.`customer_id`
    left outer join `countries` on `countries`.`id` = `customers`.`country_id`;

    /*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
    /*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
    /*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
    /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
    /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
    /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

    /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=1 */;
");


$result = getDatabase() -> execute ("
    create or replace view `detailed_sales` as SELECT
       `sales`.`id` AS `id`,
       `sales`.`date_purchased` AS `date_purchased`,
       `cameras`.`brand` AS `brand`,
       `cameras`.`model_name` AS `model_name`,
       `cameras`.`price` AS `price`,
       `cameras`.`battery_type` AS `battery_type`,
       `cameras`.`megapixels` AS `megapixels`,
       `cameras`.`can_do_video` AS `can_do_video`,
       `cameras`.`has_flash` AS `has_flash`,
       `cameras`.`resolution` AS `resolution`,
       `stores`.`name` AS `name`,
       `stores`.`brand` AS `store_brand`,
       `stores`.`size` AS `size`,
       `customers`.`id` AS `customer_id`,
       `customers`.`first_name` AS `first_name`,
       `customers`.`last_name` AS `last_name`,
       `customers`.`date_of_birth` AS `date_of_birth`,
       `customers`.`gender` AS `gender`,
       `countries`.`name` AS `country`
    FROM ((((`sales` join `cameras` on((`cameras`.`id` = `sales`.`camera_id`))) join `stores` on((`stores`.`id` = `sales`.`store_id`))) join `customers` on((`customers`.`id` = `sales`.`customer_id`))) join `countries` on((`countries`.`id` = `stores`.`country_id`)));

    create or replace view `sales_statistics_countries` as SELECT countries.Name
    as 'country', SUM(cameras.price) AS TotalAmount, COUNT(sales.id) AS NumberOfSales FROM cameras
    INNER JOIN sales ON sales.camera_id = cameras.id
    JOIN stores ON stores.id = sales.store_id
    JOIN countries ON countries.id = stores.country_id
    GROUP BY countries.Name;

    create or replace view `sales_statistics_dates` as SELECT
    STR_TO_DATE(sales.`date_purchased`, '%d-%m-%Y')as 'date',
    SUM(cameras.price) AS total_amount, COUNT(sales.id) AS number_of_sales FROM cameras
    INNER JOIN sales ON sales.id = cameras.id
    JOIN customers ON customers.id = sales.customer_id
    GROUP BY sales.`date_purchased`;

    create or replace view `camera_types_top` AS
    SELECT type.id 'type_id', `type`.`name` AS `TypeOfCamera`,
    sum(`cameras`.`price`) AS `TotalAmount`,
    count(`sales`.`id`) AS `NumberOfsales`,
    `stores`.`country_id` AS `country`
    FROM (((`sales`
    join `cameras` on((`cameras`.`id` = `sales`.`camera_id`)))
    join `type` on((`type`.`id` = `cameras`.`type_id`)))
    join `stores` on((`stores`.`id` = `sales`.`store_id`)))
    group by `type`.`name`
    having COUNT(sales.id) NOT LIKE 0

    UNION

    SELECT type.id 'type_id', `type`.Name as TypeOfCamera, null AS TotalAmount, COUNT(sales.id) AS NumberOfsales, `stores`.`country_id` AS `country`
    FROM type
    LEFT OUTER JOIN cameras ON cameras.type_id = `type`.id
    LEFT OUTER JOIN `sales` ON sales.camera_id = cameras.id
    LEFT OUTER JOIN stores ON stores.id = sales.store_id
    GROUP BY `type`.Name
    having COUNT(sales.id) LIKE 0;

    create or replace view `cameras_top` AS select
    concat(cameras.brand, ' ', cameras.model_name) 'camera',
    sum(`cameras`.`price`) 'earnings',
    count(sales.id) 'sales',
    countries.id 'country' from countries
    inner join stores on stores.`country_id` = countries.id
    inner join sales on sales.store_id = stores.id
    inner join cameras on cameras.id = sales.camera_id
    group by country, camera
    order by country, sales desc;

    create or replace view `brands` as SELECT DISTINCT brand FROM `cameras`;
    create or replace view `custom_cameras` as SELECT id, price, brand FROM `cameras`;
    create or replace view `sales_per_brand_per_month` as select
    str_to_date(`sales`.`date_purchased`,'%d-%m-%Y') 'date',
    date_format(str_to_date(`sales`.`date_purchased`,'%d-%m-%Y'),'%M') AS `month`,
    `brands`.`brand` AS `brand`,
    count(`cameras`.`id`) AS `sales`,
    sum(`cameras`.`price`) AS `earnings`
	FROM ((`sales` join `brands`)
	left join `custom_cameras` `cameras` on(((`cameras`.`id` = `sales`.`camera_id`)
	and (`cameras`.`brand` = `brands`.`brand`))))
	group by `month`,`brands`.`brand`;

    create or replace view `professions_most_used` as
    SELECT profession.title as profession, concat(cameras.brand, ' ', cameras.model_name) AS camera, COUNT(sales.id) AS sales
    FROM cameras
    INNER
        JOIN sales
         ON sales.camera_id = cameras.id
        JOIN customers
         ON customers.id = sales.customer_id
        JOIN customer_has_profession
         ON customer_has_profession.customer_id = customers.id
        JOIN profession
         ON profession.id = customer_has_profession.profession_id
    GROUP BY concat(cameras.brand, ' ', cameras.model_name)
    ORDER BY profession DESC;

    create or replace view `hobbies_most_used` as
    SELECT hobby.name as hobby, concat(cameras.brand, ' ', cameras.model_name) AS camera, COUNT(sales.id) AS sales
    FROM cameras
    INNER
        JOIN sales
         ON sales.camera_id = cameras.id
        JOIN customers
         ON customers.id = sales.customer_id
        JOIN customer_has_hobby
         ON customer_has_hobby.customer_id = customers.id
        JOIN hobby
         ON hobby.id = customer_has_hobby.hobby_id
    GROUP BY concat(cameras.brand, ' ', cameras.model_name)
    ORDER BY hobby DESC;

    create or replace view `detailed_cameras` as
    select `cameras`.`brand` 'brand', `cameras`.`model_name` 'model', `cameras`.`price`, `cameras`.`battery_type` 'battery', `cameras`.`megapixels`, `cameras`.`can_do_video` 'video', `cameras`.`has_flash` 'flash', `cameras`.`resolution`, `type`.`name` 'type', `storage`.`name` 'storage', (select count(`id`) from `sales` where `camera_id` = `cameras`.`id`) as 'sales' from `cameras`
    inner join `type` on `type`.`id` = `cameras`.`type_id`
    inner join `storage` on `storage`.`id` = `cameras`.`storage_id`
    order by sales desc;

    // Popular Features View
    create or replace view `popular_features` as select
    avg(cameras.price) 'average_price',
    min(cameras.price) 'min_price',
    max(cameras.price) 'max_price',

    (SELECT type.`name` FROM cameras
    INNER JOIN sales ON sales.camera_id = cameras.id
    INNER JOIN type ON cameras.`type_id` = type.`id`
    group by cameras.`type_id`
    order by count(cameras.id) desc
    limit 1) 'type',

    (SELECT cameras.`megapixels` FROM cameras
    INNER JOIN sales ON sales.camera_id = cameras.id
    group by cameras.`megapixels`
    order by count(cameras.id) desc
    limit 1) 'megapixels',

    (SELECT cameras.`resolution` FROM cameras
    INNER JOIN sales ON sales.camera_id = cameras.id
    group by cameras.`resolution`
    order by count(cameras.id) desc
    limit 1) 'resolution',

    (SELECT cameras.`has_flash` FROM cameras
    INNER JOIN sales ON sales.camera_id = cameras.id
    group by cameras.`has_flash`
    order by count(cameras.id) desc
    limit 1) 'flash',

    (SELECT cameras.`can_do_video` FROM cameras
    INNER JOIN sales ON sales.camera_id = cameras.id
    group by cameras.`can_do_video`
    order by count(cameras.id) desc
    limit 1) 'video',

    (SELECT cameras.battery_type FROM cameras
    INNER JOIN sales ON sales.camera_id = cameras.id
    group by battery_type
    order by count(cameras.id) desc
    limit 1) 'battery',

    (SELECT cameras.brand FROM cameras
    INNER JOIN sales ON sales.camera_id = cameras.id
    group by brand
    order by count(cameras.id) desc
    limit 1) 'brand'

    from sales
    inner join cameras on cameras.id = sales.camera_id;
");
