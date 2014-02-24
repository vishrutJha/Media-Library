SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `medialib` DEFAULT CHARACTER SET latin1 ;
USE `medialib` ;

-- -----------------------------------------------------
-- Table `medialib`.`lyrics`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `medialib`.`lyrics` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  `author` VARCHAR(255) NULL DEFAULT NULL ,
  `content` VARCHAR(2048) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `medialib`.`info`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `medialib`.`info` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `description` VARCHAR(2048) NULL DEFAULT NULL ,
  `type` VARCHAR(255) NULL DEFAULT NULL ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `medialib`.`posters`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `medialib`.`posters` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  `path` VARCHAR(255) NULL DEFAULT NULL ,
  `type` ENUM('movie','picture','audio','video') NULL DEFAULT NULL ,
  `info_id` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `info_id` (`info_id` ASC) ,
  CONSTRAINT `posters_ibfk_1`
    FOREIGN KEY (`info_id` )
    REFERENCES `medialib`.`info` (`id` ))
ENGINE = InnoDB
AUTO_INCREMENT = 240
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `medialib`.`audio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `medialib`.`audio` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NOT NULL ,
  `path` VARCHAR(255) NOT NULL ,
  `artist` VARCHAR(255) NULL DEFAULT 'unknown artist' ,
  `album` VARCHAR(255) NULL DEFAULT 'unknown album' ,
  `lyrics` INT(11) NULL DEFAULT NULL ,
  `album_art` INT(11) NULL DEFAULT NULL ,
  `duration` TIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `lyrics` (`lyrics` ASC) ,
  INDEX `album_art` (`album_art` ASC) ,
  CONSTRAINT `audio_ibfk_1`
    FOREIGN KEY (`lyrics` )
    REFERENCES `medialib`.`lyrics` (`id` ),
  CONSTRAINT `audio_ibfk_2`
    FOREIGN KEY (`album_art` )
    REFERENCES `medialib`.`posters` (`id` ))
ENGINE = InnoDB
AUTO_INCREMENT = 2266
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `medialib`.`reviews`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `medialib`.`reviews` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NULL DEFAULT NULL ,
  `author` VARCHAR(255) NULL DEFAULT NULL ,
  `source` VARCHAR(255) NULL DEFAULT NULL ,
  `content` VARCHAR(2047) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `medialib`.`subtitles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `medialib`.`subtitles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(11) NULL DEFAULT NULL ,
  `author` VARCHAR(255) NULL DEFAULT NULL ,
  `language` VARCHAR(255) NULL DEFAULT NULL ,
  `path` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `medialib`.`videos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `medialib`.`videos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NOT NULL ,
  `type` ENUM('movie','video') NULL DEFAULT NULL ,
  `language` VARCHAR(255) NULL DEFAULT NULL ,
  `director` VARCHAR(255) NULL DEFAULT NULL ,
  `rel_date` DATE NULL DEFAULT NULL ,
  `path` VARCHAR(255) NULL DEFAULT NULL ,
  `subtitle` INT(11) NULL DEFAULT NULL ,
  `review` INT(11) NULL DEFAULT NULL ,
  `poster` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `subtitle` (`subtitle` ASC) ,
  INDEX `review` (`review` ASC) ,
  INDEX `poster` (`poster` ASC) ,
  CONSTRAINT `videos_ibfk_1`
    FOREIGN KEY (`subtitle` )
    REFERENCES `medialib`.`subtitles` (`id` ),
  CONSTRAINT `videos_ibfk_2`
    FOREIGN KEY (`review` )
    REFERENCES `medialib`.`reviews` (`id` ),
  CONSTRAINT `videos_ibfk_3`
    FOREIGN KEY (`poster` )
    REFERENCES `medialib`.`posters` (`id` ))
ENGINE = InnoDB
AUTO_INCREMENT = 353
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- procedure GetAllProducts
-- -----------------------------------------------------

DELIMITER $$
USE `medialib`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllProducts`()
BEGIN
   SELECT *  FROM products;
   END$$

DELIMITER ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
