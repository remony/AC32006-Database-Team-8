<?php
$result = getDatabase()->execute("
    /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
    /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
    /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
    /*!40101 SET NAMES utf8 */;
    /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
    /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
    /*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


    # Dump of table cameras
    # ------------------------------------------------------------

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
      `date_of_birth` date NOT NULL,
      `gender` enum('male','female') NOT NULL,
      `province_id` int(11) NOT NULL,
      `country_id` int(11) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `fk_customers_provinces_idx` (`province_id`),
      KEY `fk_customers_countries_idx` (`country_id`),
      CONSTRAINT `fk_customers_countries` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
      CONSTRAINT `fk_customers_provinces` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`)
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
    ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;



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



    # Dump of table provinces
    # ------------------------------------------------------------

    CREATE TABLE `provinces` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(45) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



    # Dump of table sales
    # ------------------------------------------------------------

    CREATE TABLE `sales` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `date_purchased` date NOT NULL COMMENT 'When was the camera bought',
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
      `province_id` int(11) NOT NULL,
      `country_id` int(11) NOT NULL,
      PRIMARY KEY (`id`),
      KEY `fk_store_provinces_idx` (`province_id`),
      KEY `fk_store_countries_idx` (`country_id`),
      CONSTRAINT `fk_store_countries` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
      CONSTRAINT `fk_stores_provinces` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`)
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
      `access_token` varchar(64) DEFAULT '',
      PRIMARY KEY (`id`),
      KEY `fk_USERS_GROUPS1_idx` (`id_group`),
      CONSTRAINT `fk_users_groups` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

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
