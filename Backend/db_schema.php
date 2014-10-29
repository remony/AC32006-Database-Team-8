<?php
$result = getDatabase()->execute("
    SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
    SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
    SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

    -- -----------------------------------------------------
    -- Schema test
    -- -----------------------------------------------------
    CREATE SCHEMA IF NOT EXISTS `AC32006_Database_Team_10` ;
    USE `AC32006_Database_Team_10` ;

    -- -----------------------------------------------------
    -- Table `AC32006_Database_Team_10`.`TYPE`
    -- -----------------------------------------------------
    CREATE TABLE IF NOT EXISTS `AC32006_Database_Team_10`.`TYPE` (
      `idType` INT NOT NULL AUTO_INCREMENT,
      `Name` VARCHAR(20) NOT NULL,
      PRIMARY KEY (`idType`))
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `AC32006_Database_Team_10`.`STORAGE`
    -- -----------------------------------------------------
    CREATE TABLE IF NOT EXISTS `AC32006_Database_Team_10`.`STORAGE` (
      `idStorage` INT NOT NULL AUTO_INCREMENT,
      `Name` VARCHAR(45) NOT NULL COMMENT 'Type\n- Compact\n- GoPro\n- DLSR\n- Bridge\n- Disposable\n- Mirror',
      PRIMARY KEY (`idStorage`))
    ENGINE = InnoDB;

    -- -----------------------------------------------------
    -- Table `AC32006_Database_Team_10`.`CAMERAS`
    -- -----------------------------------------------------
    CREATE TABLE IF NOT EXISTS `AC32006_Database_Team_10`.`CAMERAS` (
      `idCameras` INT NOT NULL AUTO_INCREMENT,
      `Brand` VARCHAR(20) NOT NULL,
      `Model_name` VARCHAR(20) NOT NULL,
      `Price` INT NOT NULL,
      `Battery_type` VARCHAR(45) NOT NULL,
      `MegaPixels` INT NOT NULL,
      `canDoVideo` TINYINT(1) NOT NULL,
      `hasFlash` TINYINT(1) NOT NULL,
      `Resolution` INT NOT NULL,
      `TYPE_idType` INT NOT NULL,
      `STORAGE_idStorage` INT NOT NULL,
      PRIMARY KEY (`idCameras`),
      CONSTRAINT `fk_CAMERAS_TYPE1`
        FOREIGN KEY (`TYPE_idType`)
        REFERENCES `AC32006_Database_Team_10`.`TYPE` (`idType`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
      CONSTRAINT `fk_CAMERAS_STORAGE1`
        FOREIGN KEY (`STORAGE_idStorage`)
        REFERENCES `AC32006_Database_Team_10`.`STORAGE` (`idStorage`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;

    CREATE INDEX `Price` USING BTREE ON `AC32006_Database_Team_10`.`CAMERAS` (`Price` ASC);

    CREATE INDEX `fk_CAMERAS_TYPE1_idx` ON `AC32006_Database_Team_10`.`CAMERAS` (`TYPE_idType` ASC);

    CREATE INDEX `fk_CAMERAS_STORAGE1_idx` ON `AC32006_Database_Team_10`.`CAMERAS` (`STORAGE_idStorage` ASC);


    -- -----------------------------------------------------
    -- Table `AC32006_Database_Team_10`.`PROVINCES`
    -- -----------------------------------------------------
    CREATE TABLE IF NOT EXISTS `AC32006_Database_Team_10`.`PROVINCES` (
      `idCounty` INT NOT NULL AUTO_INCREMENT,
      `Name` VARCHAR(45) NOT NULL,
      PRIMARY KEY (`idCounty`))
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `AC32006_Database_Team_10`.`COUNTRIES`
    -- -----------------------------------------------------
    CREATE TABLE IF NOT EXISTS `AC32006_Database_Team_10`.`COUNTRIES` (
      `idCountries` INT NOT NULL AUTO_INCREMENT,
      `Name` VARCHAR(45) NOT NULL,
      PRIMARY KEY (`idCountries`))
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `AC32006_Database_Team_10`.`CUSTOMERS`
    -- -----------------------------------------------------
    CREATE TABLE IF NOT EXISTS `AC32006_Database_Team_10`.`CUSTOMERS` (
      `idUsers` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `FirstName` VARCHAR(20) NOT NULL,
      `LastName` VARCHAR(20) NOT NULL,
      `DateOfBirth` DATE NOT NULL,
      `Gender` ENUM('male','female') NOT NULL,
      `Counties_idCounties` INT NOT NULL,
      `Countries_idCountries` INT NOT NULL,
      PRIMARY KEY (`idUsers`),
      CONSTRAINT `fk_CUSTOMERS_Counties1`
        FOREIGN KEY (`Counties_idCounties`)
        REFERENCES `AC32006_Database_Team_10`.`PROVINCES` (`idCounty`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
      CONSTRAINT `fk_CUSTOMERS_Countries1`
        FOREIGN KEY (`Countries_idCountries`)
        REFERENCES `AC32006_Database_Team_10`.`COUNTRIES` (`idCountries`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;

    CREATE INDEX `fk_CUSTOMERS_Counties1_idx` ON `AC32006_Database_Team_10`.`CUSTOMERS` (`Counties_idCounties` ASC);

    CREATE INDEX `fk_CUSTOMERS_Countries1_idx` ON `AC32006_Database_Team_10`.`CUSTOMERS` (`Countries_idCountries` ASC);


    -- -----------------------------------------------------
    -- Table `AC32006_Database_Team_10`.`PROFESSION`
    -- -----------------------------------------------------
    CREATE TABLE IF NOT EXISTS `AC32006_Database_Team_10`.`PROFESSION` (
      `idProfession` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `Title` VARCHAR(45) NOT NULL COMMENT 'The title of the profession (Photographer)',
      `Salary` INT NOT NULL COMMENT 'Avg of how much earning',
      `Years` INT NOT NULL COMMENT 'How many years worked in area',
      PRIMARY KEY (`idProfession`))
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `AC32006_Database_Team_10`.`HOBBY`
    -- -----------------------------------------------------
    CREATE TABLE IF NOT EXISTS `AC32006_Database_Team_10`.`HOBBY` (
      `idHobby` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `Title` VARCHAR(45) NOT NULL COMMENT 'The name of the customers hobby. (Swimming, photography, etc.)\n',
      PRIMARY KEY (`idHobby`))
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `AC32006_Database_Team_10`.`STORES`
    -- -----------------------------------------------------
    CREATE TABLE IF NOT EXISTS `AC32006_Database_Team_10`.`STORES` (
      `idStore` INT NOT NULL AUTO_INCREMENT,
      `Name` VARCHAR(45) NOT NULL COMMENT 'Name of the store.',
      `Brand` VARCHAR(45) NOT NULL,
      `Size` INT NOT NULL COMMENT 'The size of the store in square meeting.',
      `Quantity` INT NOT NULL,
      `QuantitySold` INT NOT NULL,
      `Counties_idCounties` INT NOT NULL,
      `Countries_idCountries` INT NOT NULL,
      PRIMARY KEY (`idStore`),
      CONSTRAINT `fk_STORE_Counties1`
        FOREIGN KEY (`Counties_idCounties`)
        REFERENCES `AC32006_Database_Team_10`.`PROVINCES` (`idCounty`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
      CONSTRAINT `fk_STORE_Countries1`
        FOREIGN KEY (`Countries_idCountries`)
        REFERENCES `AC32006_Database_Team_10`.`COUNTRIES` (`idCountries`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;

    CREATE INDEX `fk_STORE_Counties1_idx` ON `AC32006_Database_Team_10`.`STORES` (`Counties_idCounties` ASC);

    CREATE INDEX `fk_STORE_Countries1_idx` ON `AC32006_Database_Team_10`.`STORES` (`Countries_idCountries` ASC);


    -- -----------------------------------------------------
    -- Table `AC32006_Database_Team_10`.`SALES`
    -- -----------------------------------------------------
    CREATE TABLE IF NOT EXISTS `AC32006_Database_Team_10`.`SALES` (
      `idSales` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `DatePurchased` DATE NOT NULL COMMENT 'When was the camera bought',
      `CAMERAS_idCameras` INT NOT NULL,
      `STORE_idStore` INT NOT NULL,
      `CUSTOMERS_idUsers` INT UNSIGNED NOT NULL,
      PRIMARY KEY (`idSales`),
      CONSTRAINT `fk_SALES_STORE1`
        FOREIGN KEY (`STORE_idStore`)
        REFERENCES `AC32006_Database_Team_10`.`STORES` (`idStore`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
      CONSTRAINT `fk_SALES_CUSTOMERS1`
        FOREIGN KEY (`CUSTOMERS_idUsers`)
        REFERENCES `AC32006_Database_Team_10`.`CUSTOMERS` (`idUsers`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
      CONSTRAINT `fk_SALES_CAMERAS1`
        FOREIGN KEY (`CAMERAS_idCameras`)
        REFERENCES `AC32006_Database_Team_10`.`CAMERAS` (`idCameras`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;

    CREATE INDEX `fk_SALES_STORE1_idx` ON `AC32006_Database_Team_10`.`SALES` (`STORE_idStore` ASC);

    CREATE INDEX `fk_SALES_CUSTOMERS1_idx` ON `AC32006_Database_Team_10`.`SALES` (`CUSTOMERS_idUsers` ASC);

    CREATE INDEX `fk_SALES_CAMERAS1_idx` ON `AC32006_Database_Team_10`.`SALES` (`CAMERAS_idCameras` ASC);


    -- -----------------------------------------------------
    -- Table `AC32006_Database_Team_10`.`LENS`
    -- -----------------------------------------------------
    CREATE TABLE IF NOT EXISTS `AC32006_Database_Team_10`.`LENS` (
      `idLens` INT NOT NULL AUTO_INCREMENT,
      `Type` VARCHAR(45) NOT NULL,
      PRIMARY KEY (`idLens`))
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `AC32006_Database_Team_10`.`CUSTOMERS_has_PROFESSION`
    -- -----------------------------------------------------
    CREATE TABLE IF NOT EXISTS `AC32006_Database_Team_10`.`CUSTOMERS_has_PROFESSION` (
      `CUSTOMERS_idUsers` INT UNSIGNED NOT NULL,
      `PROFESSION_idProfession` INT UNSIGNED NOT NULL,
      PRIMARY KEY (`CUSTOMERS_idUsers`, `PROFESSION_idProfession`),
      CONSTRAINT `fk_CUSTOMERS_has_PROFESSION_CUSTOMERS1`
        FOREIGN KEY (`CUSTOMERS_idUsers`)
        REFERENCES `AC32006_Database_Team_10`.`CUSTOMERS` (`idUsers`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
      CONSTRAINT `fk_CUSTOMERS_has_PROFESSION_PROFESSION1`
        FOREIGN KEY (`PROFESSION_idProfession`)
        REFERENCES `AC32006_Database_Team_10`.`PROFESSION` (`idProfession`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;

    CREATE INDEX `fk_CUSTOMERS_has_PROFESSION_PROFESSION1_idx` ON `AC32006_Database_Team_10`.`CUSTOMERS_has_PROFESSION` (`PROFESSION_idProfession` ASC);

    CREATE INDEX `fk_CUSTOMERS_has_PROFESSION_CUSTOMERS1_idx` ON `AC32006_Database_Team_10`.`CUSTOMERS_has_PROFESSION` (`CUSTOMERS_idUsers` ASC);


    -- -----------------------------------------------------
    -- Table `AC32006_Database_Team_10`.`CUSTOMERS_has_HOBBY`
    -- -----------------------------------------------------
    CREATE TABLE IF NOT EXISTS `AC32006_Database_Team_10`.`CUSTOMERS_has_HOBBY` (
      `CUSTOMERS_idUsers` INT UNSIGNED NOT NULL,
      `HOBBY_idHobby` INT UNSIGNED NOT NULL,
      PRIMARY KEY (`CUSTOMERS_idUsers`, `HOBBY_idHobby`),
      CONSTRAINT `fk_CUSTOMERS_has_HOBBY_CUSTOMERS1`
        FOREIGN KEY (`CUSTOMERS_idUsers`)
        REFERENCES `AC32006_Database_Team_10`.`CUSTOMERS` (`idUsers`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
      CONSTRAINT `fk_CUSTOMERS_has_HOBBY_HOBBY1`
        FOREIGN KEY (`HOBBY_idHobby`)
        REFERENCES `AC32006_Database_Team_10`.`HOBBY` (`idHobby`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;

    CREATE INDEX `fk_CUSTOMERS_has_HOBBY_HOBBY1_idx` ON `AC32006_Database_Team_10`.`CUSTOMERS_has_HOBBY` (`HOBBY_idHobby` ASC);

    CREATE INDEX `fk_CUSTOMERS_has_HOBBY_CUSTOMERS1_idx` ON `AC32006_Database_Team_10`.`CUSTOMERS_has_HOBBY` (`CUSTOMERS_idUsers` ASC);


    -- -----------------------------------------------------
    -- Table `AC32006_Database_Team_10`.`TYPE_has_LENS`
    -- -----------------------------------------------------
    CREATE TABLE IF NOT EXISTS `AC32006_Database_Team_10`.`TYPE_has_LENS` (
      `TYPE_idType` INT NOT NULL,
      `LENS_idLens` INT NOT NULL,
      PRIMARY KEY (`TYPE_idType`, `LENS_idLens`),
      CONSTRAINT `fk_TYPE_has_LENS_TYPE1`
        FOREIGN KEY (`TYPE_idType`)
        REFERENCES `AC32006_Database_Team_10`.`TYPE` (`idType`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
      CONSTRAINT `fk_TYPE_has_LENS_LENS1`
        FOREIGN KEY (`LENS_idLens`)
        REFERENCES `AC32006_Database_Team_10`.`LENS` (`idLens`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;

    CREATE INDEX `fk_TYPE_has_LENS_LENS1_idx` ON `AC32006_Database_Team_10`.`TYPE_has_LENS` (`LENS_idLens` ASC);

    CREATE INDEX `fk_TYPE_has_LENS_TYPE1_idx` ON `AC32006_Database_Team_10`.`TYPE_has_LENS` (`TYPE_idType` ASC);


    -- -----------------------------------------------------
    -- Table `AC32006_Database_Team_10`.`GROUPS`
    -- -----------------------------------------------------
    CREATE TABLE IF NOT EXISTS `AC32006_Database_Team_10`.`GROUPS` (
      `idGROUPS` INT NOT NULL AUTO_INCREMENT,
      `Name` VARCHAR(45) NOT NULL,
      `Read` TINYINT(1) NOT NULL DEFAULT 0,
      `Write` TINYINT(1) NOT NULL DEFAULT 0,
      `Delete` TINYINT(1) NOT NULL DEFAULT 0,
      `Update` TINYINT(1) NOT NULL DEFAULT 0,
      PRIMARY KEY (`idGROUPS`))
    ENGINE = InnoDB;


    -- -----------------------------------------------------
    -- Table `AC32006_Database_Team_10`.`USERS`
    -- -----------------------------------------------------
    CREATE TABLE IF NOT EXISTS `AC32006_Database_Team_10`.`USERS` (
      `idUSERS` INT NOT NULL AUTO_INCREMENT,
      `Username` VARCHAR(45) NOT NULL,
      `Password` VARCHAR(45) NOT NULL,
      `GROUPS_idGROUPS` INT NOT NULL,
      PRIMARY KEY (`idUSERS`),
      CONSTRAINT `fk_USERS_GROUPS1`
        FOREIGN KEY (`GROUPS_idGROUPS`)
        REFERENCES `AC32006_Database_Team_10`.`GROUPS` (`idGROUPS`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;

    CREATE INDEX `fk_USERS_GROUPS1_idx` ON `AC32006_Database_Team_10`.`USERS` (`GROUPS_idGROUPS` ASC);

    SET SQL_MODE=@OLD_SQL_MODE;
    SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
    SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
");
