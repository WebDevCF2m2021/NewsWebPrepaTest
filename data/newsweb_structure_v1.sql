-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema newsweb
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `newsweb` ;

-- -----------------------------------------------------
-- Schema newsweb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `newsweb` DEFAULT CHARACTER SET utf8 ;
USE `newsweb` ;

-- -----------------------------------------------------
-- Table `newsweb`.`permission`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `newsweb`.`permission` ;

CREATE TABLE IF NOT EXISTS `newsweb`.`permission` (
  `idpermission` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `permissionname` VARCHAR(45) NOT NULL,
  `permissionrole` TINYINT UNSIGNED NOT NULL COMMENT '0 => admin\n1 => contributor\n2 => commentator',
  PRIMARY KEY (`idpermission`))
ENGINE = InnoDB;

CREATE UNIQUE INDEX `permissionname_UNIQUE` ON `newsweb`.`permission` (`permissionname` ASC);


-- -----------------------------------------------------
-- Table `newsweb`.`theuser`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `newsweb`.`theuser` ;

CREATE TABLE IF NOT EXISTS `newsweb`.`theuser` (
  `idtheuser` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `theuserlogin` VARCHAR(60) NOT NULL,
  `theuserpwd` VARCHAR(255) NOT NULL,
  `theusermail` VARCHAR(255) NOT NULL,
  `theuseruniqid` VARCHAR(255) NOT NULL,
  `theuseractivate` TINYINT UNSIGNED NULL DEFAULT 0 COMMENT '0 => inactive\n1 => active\n2 => ban',
  `permission_idpermission` TINYINT UNSIGNED NULL,
  PRIMARY KEY (`idtheuser`),
  CONSTRAINT `fk_theuser_permission`
    FOREIGN KEY (`permission_idpermission`)
    REFERENCES `newsweb`.`permission` (`idpermission`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE UNIQUE INDEX `theuserlogin_UNIQUE` ON `newsweb`.`theuser` (`theuserlogin` ASC);

CREATE UNIQUE INDEX `theusermail_UNIQUE` ON `newsweb`.`theuser` (`theusermail` ASC);

CREATE UNIQUE INDEX `theuseruniqid_UNIQUE` ON `newsweb`.`theuser` (`theuseruniqid` ASC);

CREATE INDEX `fk_theuser_permission_idx` ON `newsweb`.`theuser` (`permission_idpermission` ASC);


-- -----------------------------------------------------
-- Table `newsweb`.`thearticle`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `newsweb`.`thearticle` ;

CREATE TABLE IF NOT EXISTS `newsweb`.`thearticle` (
  `idthearticle` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `thearticletitle` VARCHAR(120) NOT NULL,
  `thearticleslug` VARCHAR(120) NOT NULL,
  `thearticleresume` VARCHAR(250) NULL,
  `thearticletext` TEXT NOT NULL,
  `thearticledate` DATETIME NULL DEFAULT NOW(),
  `thearticleactivate` TINYINT NULL DEFAULT 0 COMMENT '0 => waiting\n1 => publish\n2 => deleted',
  `theuser_idtheuser` INT UNSIGNED NULL,
  PRIMARY KEY (`idthearticle`),
  CONSTRAINT `fk_thearticle_theuser1`
    FOREIGN KEY (`theuser_idtheuser`)
    REFERENCES `newsweb`.`theuser` (`idtheuser`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE UNIQUE INDEX `thearticleslug_UNIQUE` ON `newsweb`.`thearticle` (`thearticleslug` ASC);

CREATE INDEX `fk_thearticle_theuser1_idx` ON `newsweb`.`thearticle` (`theuser_idtheuser` ASC);


-- -----------------------------------------------------
-- Table `newsweb`.`theimage`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `newsweb`.`theimage` ;

CREATE TABLE IF NOT EXISTS `newsweb`.`theimage` (
  `idtheimage` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `theimagename` VARCHAR(45) NOT NULL,
  `theimagetype` VARCHAR(5) NOT NULL,
  `theimageurl` VARCHAR(100) NOT NULL,
  `theimagetext` VARCHAR(250) NULL,
  PRIMARY KEY (`idtheimage`))
ENGINE = InnoDB;

CREATE UNIQUE INDEX `theimagename_UNIQUE` ON `newsweb`.`theimage` (`theimagename` ASC);


-- -----------------------------------------------------
-- Table `newsweb`.`theimage_has_thearticle`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `newsweb`.`theimage_has_thearticle` ;

CREATE TABLE IF NOT EXISTS `newsweb`.`theimage_has_thearticle` (
  `theimage_idtheimage` INT UNSIGNED NOT NULL,
  `thearticle_idthearticle` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`theimage_idtheimage`, `thearticle_idthearticle`),
  CONSTRAINT `fk_theimage_has_thearticle_theimage1`
    FOREIGN KEY (`theimage_idtheimage`)
    REFERENCES `newsweb`.`theimage` (`idtheimage`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_theimage_has_thearticle_thearticle1`
    FOREIGN KEY (`thearticle_idthearticle`)
    REFERENCES `newsweb`.`thearticle` (`idthearticle`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_theimage_has_thearticle_thearticle1_idx` ON `newsweb`.`theimage_has_thearticle` (`thearticle_idthearticle` ASC);

CREATE INDEX `fk_theimage_has_thearticle_theimage1_idx` ON `newsweb`.`theimage_has_thearticle` (`theimage_idtheimage` ASC);


-- -----------------------------------------------------
-- Table `newsweb`.`thesection`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `newsweb`.`thesection` ;

CREATE TABLE IF NOT EXISTS `newsweb`.`thesection` (
  `idthesection` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `thesectiontitle` VARCHAR(60) NOT NULL,
  `thesectionslug` VARCHAR(60) NOT NULL,
  `thesectiondesc` VARCHAR(300) NULL,
  PRIMARY KEY (`idthesection`))
ENGINE = InnoDB;

CREATE UNIQUE INDEX `thesectionslug_UNIQUE` ON `newsweb`.`thesection` (`thesectionslug` ASC);


-- -----------------------------------------------------
-- Table `newsweb`.`thesection_has_thearticle`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `newsweb`.`thesection_has_thearticle` ;

CREATE TABLE IF NOT EXISTS `newsweb`.`thesection_has_thearticle` (
  `thesection_idthesection` SMALLINT UNSIGNED NOT NULL,
  `thearticle_idthearticle` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`thesection_idthesection`, `thearticle_idthearticle`),
  CONSTRAINT `fk_thesection_has_thearticle_thesection1`
    FOREIGN KEY (`thesection_idthesection`)
    REFERENCES `newsweb`.`thesection` (`idthesection`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_thesection_has_thearticle_thearticle1`
    FOREIGN KEY (`thearticle_idthearticle`)
    REFERENCES `newsweb`.`thearticle` (`idthearticle`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_thesection_has_thearticle_thearticle1_idx` ON `newsweb`.`thesection_has_thearticle` (`thearticle_idthearticle` ASC);

CREATE INDEX `fk_thesection_has_thearticle_thesection1_idx` ON `newsweb`.`thesection_has_thearticle` (`thesection_idthesection` ASC);


-- -----------------------------------------------------
-- Table `newsweb`.`thecomment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `newsweb`.`thecomment` ;

CREATE TABLE IF NOT EXISTS `newsweb`.`thecomment` (
  `idthecomment` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `theuser_idtheuser` INT UNSIGNED NULL,
  `thecommenttext` VARCHAR(850) NOT NULL,
  `thecommentdate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `thecommentactive` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 => waiting\n1 => publish\n2 => deleted',
  PRIMARY KEY (`idthecomment`),
  CONSTRAINT `fk_thecomment_theuser1`
    FOREIGN KEY (`theuser_idtheuser`)
    REFERENCES `newsweb`.`theuser` (`idtheuser`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_thecomment_theuser1_idx` ON `newsweb`.`thecomment` (`theuser_idtheuser` ASC);


-- -----------------------------------------------------
-- Table `newsweb`.`thearticle_has_thecomment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `newsweb`.`thearticle_has_thecomment` ;

CREATE TABLE IF NOT EXISTS `newsweb`.`thearticle_has_thecomment` (
  `thearticle_idthearticle` INT UNSIGNED NOT NULL,
  `thecomment_idthecomment` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`thearticle_idthearticle`, `thecomment_idthecomment`),
  CONSTRAINT `fk_thearticle_has_thecomment_thearticle1`
    FOREIGN KEY (`thearticle_idthearticle`)
    REFERENCES `newsweb`.`thearticle` (`idthearticle`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_thearticle_has_thecomment_thecomment1`
    FOREIGN KEY (`thecomment_idthecomment`)
    REFERENCES `newsweb`.`thecomment` (`idthecomment`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_thearticle_has_thecomment_thecomment1_idx` ON `newsweb`.`thearticle_has_thecomment` (`thecomment_idthecomment` ASC);

CREATE INDEX `fk_thearticle_has_thecomment_thearticle1_idx` ON `newsweb`.`thearticle_has_thecomment` (`thearticle_idthearticle` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
