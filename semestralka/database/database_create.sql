-- MySQL Script generated by MySQL Workbench
-- Tue Dec 22 23:30:24 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `PRAVA`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `PRAVA` ;

CREATE TABLE IF NOT EXISTS `PRAVA` (
                                       `id_prava` INT NOT NULL,
                                       `typ_prava` VARCHAR(45) NOT NULL,
                                       PRIMARY KEY (`id_prava`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `USER`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `USER` ;

CREATE TABLE IF NOT EXISTS `USER` (
                                      `id_user` INT NOT NULL AUTO_INCREMENT,
                                      `email` VARCHAR(45) NOT NULL,
                                      `username` VARCHAR(45) NOT NULL,
                                      `password` VARCHAR(45) NOT NULL,
                                      `PRAVA_id_prava` INT NOT NULL,
                                      PRIMARY KEY (`id_user`),
                                      INDEX `fk_USER_PRAVA1_idx` (`PRAVA_id_prava` ASC),
                                      CONSTRAINT `fk_USER_PRAVA1`
                                          FOREIGN KEY (`PRAVA_id_prava`)
                                              REFERENCES `PRAVA` (`id_prava`)
                                              ON DELETE CASCADE
                                              ON UPDATE CASCADE)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `LODE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `LODE` ;

CREATE TABLE IF NOT EXISTS `LODE` (
                                      `id_lod` INT NOT NULL,
                                      `typ_lode` VARCHAR(45) NOT NULL,
                                      `cena` INT NOT NULL,
                                      PRIMARY KEY (`id_lod`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `REKY`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `REKY` ;

CREATE TABLE IF NOT EXISTS `REKY` (
                                      `id_reky` INT NOT NULL,
                                      `nazev` VARCHAR(45) NOT NULL,
                                      PRIMARY KEY (`id_reky`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PRISLUSENSTVI`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `PRISLUSENSTVI` ;

CREATE TABLE IF NOT EXISTS `PRISLUSENSTVI` (
                                               `id_prislusenstvi` INT NOT NULL,
                                               `nazev_prislusen` VARCHAR(45) NOT NULL,
                                               `cena` INT NOT NULL,
                                               PRIMARY KEY (`id_prislusenstvi`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `OBJEDNAVKA`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `OBJEDNAVKA` ;

CREATE TABLE IF NOT EXISTS `OBJEDNAVKA` (
                                            `id_objednavky` INT NOT NULL,
                                            `datum_vytvoreni` DATE NOT NULL,
                                            `USER_id_user` INT NOT NULL,
                                            `REKY_id_reky` INT NOT NULL,
                                            `schvalena` TINYINT NOT NULL,
                                            `datum_vraceni` DATE NOT NULL,
                                            PRIMARY KEY (`id_objednavky`),
                                            INDEX `fk_OBJEDNAVKA_USER1_idx` (`USER_id_user` ASC),
                                            INDEX `fk_OBJEDNAVKA_REKY1_idx` (`REKY_id_reky` ASC),
                                            CONSTRAINT `fk_OBJEDNAVKA_USER1`
                                                FOREIGN KEY (`USER_id_user`)
                                                    REFERENCES `USER` (`id_user`)
                                                    ON DELETE CASCADE
                                                    ON UPDATE CASCADE,
                                            CONSTRAINT `fk_OBJEDNAVKA_REKY1`
                                                FOREIGN KEY (`REKY_id_reky`)
                                                    REFERENCES `REKY` (`id_reky`)
                                                    ON DELETE CASCADE
                                                    ON UPDATE CASCADE)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `POMOCNA_PRISLUSENSTVI`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `POMOCNA_PRISLUSENSTVI` ;

CREATE TABLE IF NOT EXISTS `POMOCNA_PRISLUSENSTVI` (
                                                       `PRISLUSENSTVI_id_prislusenstvi` INT NOT NULL,
                                                       `OBJEDNAVKA_id_objednavky` INT NOT NULL,
                                                       `pocet` INT NOT NULL,
                                                       PRIMARY KEY (`PRISLUSENSTVI_id_prislusenstvi`, `OBJEDNAVKA_id_objednavky`),
                                                       INDEX `fk_POMOCNA_OBJEDNAVKA1_idx` (`OBJEDNAVKA_id_objednavky` ASC),
                                                       CONSTRAINT `fk_POMOCNA_PRISLUSENSTVI`
                                                           FOREIGN KEY (`PRISLUSENSTVI_id_prislusenstvi`)
                                                               REFERENCES `PRISLUSENSTVI` (`id_prislusenstvi`)
                                                               ON DELETE CASCADE
                                                               ON UPDATE CASCADE,
                                                       CONSTRAINT `fk_POMOCNA_OBJEDNAVKA1`
                                                           FOREIGN KEY (`OBJEDNAVKA_id_objednavky`)
                                                               REFERENCES `OBJEDNAVKA` (`id_objednavky`)
                                                               ON DELETE CASCADE
                                                               ON UPDATE CASCADE)
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `OBJEDNAVKY_LODI`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `OBJEDNAVKY_LODI` ;

CREATE TABLE IF NOT EXISTS `OBJEDNAVKY_LODI` (
                                                 `LODE_id_lod` INT NOT NULL,
                                                 `OBJEDNAVKA_id_objednavky` INT NOT NULL,
                                                 `pocet` INT NOT NULL,
                                                 PRIMARY KEY (`LODE_id_lod`, `OBJEDNAVKA_id_objednavky`),
                                                 INDEX `fk_table1_OBJEDNAVKA1_idx` (`OBJEDNAVKA_id_objednavky` ASC),
                                                 CONSTRAINT `fk_table1_LODE1`
                                                     FOREIGN KEY (`LODE_id_lod`)
                                                         REFERENCES `LODE` (`id_lod`)
                                                         ON DELETE CASCADE
                                                         ON UPDATE CASCADE,
                                                 CONSTRAINT `fk_table1_OBJEDNAVKA1`
                                                     FOREIGN KEY (`OBJEDNAVKA_id_objednavky`)
                                                         REFERENCES `OBJEDNAVKA` (`id_objednavky`)
                                                         ON DELETE CASCADE
                                                         ON UPDATE CASCADE)
    ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `PRAVA`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `PRAVA` (`id_prava`, `typ_prava`) VALUES (1, 'Admin');
INSERT INTO `PRAVA` (`id_prava`, `typ_prava`) VALUES (2, 'Zaměstnanec');
INSERT INTO `PRAVA` (`id_prava`, `typ_prava`) VALUES (3, 'Uživatel');

COMMIT;


-- -----------------------------------------------------
-- Data for table `USER`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `USER` (`id_user`, `email`, `username`, `password`, `PRAVA_id_prava`) VALUES (1, 'spravce@email.cz', 'admin', 'admin', 1);
INSERT INTO `USER` (`id_user`, `email`, `username`, `password`, `PRAVA_id_prava`) VALUES (2, 'zamestnanec@email.cz', 'zamestnanec', 'zamestnanec', 2);
INSERT INTO `USER` (`id_user`, `email`, `username`, `password`, `PRAVA_id_prava`) VALUES (3, 'uzivatel@email.cz', 'uzivatel', 'uzivatel', 3);
INSERT INTO `USER` (`id_user`, `email`, `username`, `password`, `PRAVA_id_prava`) VALUES (4, 'adam.krikava@email.cz', 'ada15', '123456', 3);
INSERT INTO `USER` (`id_user`, `email`, `username`, `password`, `PRAVA_id_prava`) VALUES (5, 'neznam@email.cz', 'usernameHaHa', 'nevim', 3);

COMMIT;


-- -----------------------------------------------------
-- Data for table `LODE`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `LODE` (`id_lod`, `typ_lode`, `cena`) VALUES (1, 'Samba 2-m', 900);
INSERT INTO `LODE` (`id_lod`, `typ_lode`, `cena`) VALUES (2, 'Samba 3-m', 1100);
INSERT INTO `LODE` (`id_lod`, `typ_lode`, `cena`) VALUES (3, 'Colorado 4-m', 1800);
INSERT INTO `LODE` (`id_lod`, `typ_lode`, `cena`) VALUES (4, 'Colorado 6-m', 2200);
INSERT INTO `LODE` (`id_lod`, `typ_lode`, `cena`) VALUES (5, 'Kajak', 800);

COMMIT;


-- -----------------------------------------------------
-- Data for table `REKY`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `REKY` (`id_reky`, `nazev`) VALUES (1, 'Vltava');
INSERT INTO `REKY` (`id_reky`, `nazev`) VALUES (2, 'Morava');
INSERT INTO `REKY` (`id_reky`, `nazev`) VALUES (3, 'Labe');
INSERT INTO `REKY` (`id_reky`, `nazev`) VALUES (4, 'Berounka');
INSERT INTO `REKY` (`id_reky`, `nazev`) VALUES (5, 'Ohře');
INSERT INTO `REKY` (`id_reky`, `nazev`) VALUES (6, 'Dyje');
INSERT INTO `REKY` (`id_reky`, `nazev`) VALUES (7, 'Sázava');
INSERT INTO `REKY` (`id_reky`, `nazev`) VALUES (8, 'Lužnice');
INSERT INTO `REKY` (`id_reky`, `nazev`) VALUES (9, 'Otava');
INSERT INTO `REKY` (`id_reky`, `nazev`) VALUES (10, 'Mže');

COMMIT;


-- -----------------------------------------------------
-- Data for table `PRISLUSENSTVI`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `PRISLUSENSTVI` (`id_prislusenstvi`, `nazev_prislusen`, `cena`) VALUES (1, 'Pumpa k raftu', 10);
INSERT INTO `PRISLUSENSTVI` (`id_prislusenstvi`, `nazev_prislusen`, `cena`) VALUES (2, 'Pádlo', 50);
INSERT INTO `PRISLUSENSTVI` (`id_prislusenstvi`, `nazev_prislusen`, `cena`) VALUES (3, 'Vesta - dospělý', 75);
INSERT INTO `PRISLUSENSTVI` (`id_prislusenstvi`, `nazev_prislusen`, `cena`) VALUES (4, 'Vesta - dítě', 50);
INSERT INTO `PRISLUSENSTVI` (`id_prislusenstvi`, `nazev_prislusen`, `cena`) VALUES (5, 'Barel', 100);

COMMIT;


-- -----------------------------------------------------
-- Data for table `OBJEDNAVKA`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `OBJEDNAVKA` (`id_objednavky`, `datum_vytvoreni`, `USER_id_user`, `REKY_id_reky`, `schvalena`, `datum_vraceni`) VALUES (1, '15.12.2020', 3, 2, 0, '18.12.2020');
INSERT INTO `OBJEDNAVKA` (`id_objednavky`, `datum_vytvoreni`, `USER_id_user`, `REKY_id_reky`, `schvalena`, `datum_vraceni`) VALUES (2, '22.12.2020', 4, 6, 0, '24.12.2020');
INSERT INTO `OBJEDNAVKA` (`id_objednavky`, `datum_vytvoreni`, `USER_id_user`, `REKY_id_reky`, `schvalena`, `datum_vraceni`) VALUES (3, '30.12.2020', 4, 8, 0, '31.12.2020');
INSERT INTO `OBJEDNAVKA` (`id_objednavky`, `datum_vytvoreni`, `USER_id_user`, `REKY_id_reky`, `schvalena`, `datum_vraceni`) VALUES (4, '23.12.2020', 5, 1, 1, '25.12.2020');

COMMIT;


-- -----------------------------------------------------
-- Data for table `POMOCNA_PRISLUSENSTVI`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `POMOCNA_PRISLUSENSTVI` (`PRISLUSENSTVI_id_prislusenstvi`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES (1, 1, 3);
INSERT INTO `POMOCNA_PRISLUSENSTVI` (`PRISLUSENSTVI_id_prislusenstvi`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES (2, 1, 2);
INSERT INTO `POMOCNA_PRISLUSENSTVI` (`PRISLUSENSTVI_id_prislusenstvi`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES (3, 2, 2);
INSERT INTO `POMOCNA_PRISLUSENSTVI` (`PRISLUSENSTVI_id_prislusenstvi`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES (5, 2, 3);
INSERT INTO `POMOCNA_PRISLUSENSTVI` (`PRISLUSENSTVI_id_prislusenstvi`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES (1, 3, 4);
INSERT INTO `POMOCNA_PRISLUSENSTVI` (`PRISLUSENSTVI_id_prislusenstvi`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES (4, 3, 8);
INSERT INTO `POMOCNA_PRISLUSENSTVI` (`PRISLUSENSTVI_id_prislusenstvi`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES (5, 4, 4);
INSERT INTO `POMOCNA_PRISLUSENSTVI` (`PRISLUSENSTVI_id_prislusenstvi`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES (3, 4, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `OBJEDNAVKY_LODI`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `OBJEDNAVKY_LODI` (`LODE_id_lod`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES (3, 1, 2);
INSERT INTO `OBJEDNAVKY_LODI` (`LODE_id_lod`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES (1, 1, 3);
INSERT INTO `OBJEDNAVKY_LODI` (`LODE_id_lod`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES (5, 2, 1);
INSERT INTO `OBJEDNAVKY_LODI` (`LODE_id_lod`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES (3, 2, 2);
INSERT INTO `OBJEDNAVKY_LODI` (`LODE_id_lod`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES (2, 3, 1);
INSERT INTO `OBJEDNAVKY_LODI` (`LODE_id_lod`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES (1, 3, 3);
INSERT INTO `OBJEDNAVKY_LODI` (`LODE_id_lod`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES (4, 4, 4);
INSERT INTO `OBJEDNAVKY_LODI` (`LODE_id_lod`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES (5, 4, 1);

COMMIT;

