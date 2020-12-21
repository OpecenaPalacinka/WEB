-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1:3306
-- Vytvořeno: Sob 19. pro 2020, 21:22
-- Verze serveru: 5.7.31
-- Verze PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `pujcovna_semestralka`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `lode`
--

DROP TABLE IF EXISTS `lode`;
CREATE TABLE IF NOT EXISTS `lode` (
                                      `id_lod` int(11) NOT NULL,
                                      `typ_lode` varchar(45) COLLATE utf8_czech_ci NOT NULL,
                                      `cena` int(11) NOT NULL,
                                      PRIMARY KEY (`id_lod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `lode`
--

INSERT INTO `lode` (`id_lod`, `typ_lode`, `cena`) VALUES
(1, 'Samba 2-m', 900),
(2, 'Samba 3-m', 1100),
(3, 'Colorado 4-m', 1800),
(4, 'Colorado 6-m', 2200),
(5, 'Kajak', 800);

-- --------------------------------------------------------

--
-- Struktura tabulky `objednavka`
--

DROP TABLE IF EXISTS `objednavka`;
CREATE TABLE IF NOT EXISTS `objednavka` (
                                            `id_objednavky` int(11) NOT NULL,
                                            `datum_vytvoreni` date NOT NULL,
                                            `USER_id_user` int(11) NOT NULL,
                                            `REKY_id_reky` int(11) NOT NULL,
                                            `schvalena` tinyint(4) NOT NULL,
                                            `datum_vraceni` date NOT NULL,
                                            PRIMARY KEY (`id_objednavky`),
                                            KEY `fk_OBJEDNAVKA_USER1_idx` (`USER_id_user`),
                                            KEY `fk_OBJEDNAVKA_REKY1_idx` (`REKY_id_reky`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `objednavka`
--

INSERT INTO `objednavka` (`id_objednavky`, `datum_vytvoreni`, `USER_id_user`, `REKY_id_reky`, `schvalena`, `datum_vraceni`) VALUES
(1, '2015-12-20', 3, 2, 1, '2018-12-20'),
(160816238, '2020-12-18', 4, 2, 0, '2020-12-25'),
(160816307, '2020-12-18', 1, 2, 1, '2020-12-24'),
(160816326, '2020-12-10', 1, 3, 0, '2020-12-23'),
(160839653, '2020-12-21', 1, 1, 0, '2020-12-25');

-- --------------------------------------------------------

--
-- Struktura tabulky `objednavky_lodi`
--

DROP TABLE IF EXISTS `objednavky_lodi`;
CREATE TABLE IF NOT EXISTS `objednavky_lodi` (
                                                 `LODE_id_lod` int(11) NOT NULL,
                                                 `OBJEDNAVKA_id_objednavky` int(11) NOT NULL,
                                                 `pocet` int(11) NOT NULL,
                                                 PRIMARY KEY (`LODE_id_lod`,`OBJEDNAVKA_id_objednavky`),
                                                 KEY `fk_table1_OBJEDNAVKA1_idx` (`OBJEDNAVKA_id_objednavky`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `objednavky_lodi`
--

INSERT INTO `objednavky_lodi` (`LODE_id_lod`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES
(1, 1, 3),
(2, 160816238, 1),
(2, 160816307, 1),
(2, 160839653, 2),
(3, 1, 2),
(3, 160839653, 4),
(4, 160816238, 3),
(5, 160839653, 5);

-- --------------------------------------------------------

--
-- Struktura tabulky `pomocna_prislusenstvi`
--

DROP TABLE IF EXISTS `pomocna_prislusenstvi`;
CREATE TABLE IF NOT EXISTS `pomocna_prislusenstvi` (
                                                       `PRISLUSENSTVI_id_prislusenstvi` int(11) NOT NULL,
                                                       `OBJEDNAVKA_id_objednavky` int(11) NOT NULL,
                                                       `pocet` int(11) NOT NULL,
                                                       PRIMARY KEY (`PRISLUSENSTVI_id_prislusenstvi`,`OBJEDNAVKA_id_objednavky`),
                                                       KEY `fk_POMOCNA_OBJEDNAVKA1_idx` (`OBJEDNAVKA_id_objednavky`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `pomocna_prislusenstvi`
--

INSERT INTO `pomocna_prislusenstvi` (`PRISLUSENSTVI_id_prislusenstvi`, `OBJEDNAVKA_id_objednavky`, `pocet`) VALUES
(1, 1, 3),
(1, 160816238, 8),
(1, 160816326, 1),
(2, 1, 2),
(2, 160816238, 4),
(2, 160839653, 2),
(4, 160839653, 4),
(5, 160816238, 2),
(6, 160839653, 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `prava`
--

DROP TABLE IF EXISTS `prava`;
CREATE TABLE IF NOT EXISTS `prava` (
                                       `id_prava` int(11) NOT NULL,
                                       `typ_prava` varchar(45) COLLATE utf8_czech_ci NOT NULL,
                                       PRIMARY KEY (`id_prava`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `prava`
--

INSERT INTO `prava` (`id_prava`, `typ_prava`) VALUES
(1, 'Admin'),
(2, 'Zaměstnanec'),
(3, 'Uživatel');

-- --------------------------------------------------------

--
-- Struktura tabulky `prislusenstvi`
--

DROP TABLE IF EXISTS `prislusenstvi`;
CREATE TABLE IF NOT EXISTS `prislusenstvi` (
                                               `id_prislusenstvi` int(11) NOT NULL,
                                               `nazev_prislusen` varchar(45) COLLATE utf8_czech_ci NOT NULL,
                                               `cena` int(11) NOT NULL,
                                               PRIMARY KEY (`id_prislusenstvi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `prislusenstvi`
--

INSERT INTO `prislusenstvi` (`id_prislusenstvi`, `nazev_prislusen`, `cena`) VALUES
(1, 'Pumpa k raftu', 10),
(2, 'Pádlo', 50),
(4, 'Vesta - dospělý', 75),
(5, 'Vesta - dítě', 50),
(6, 'Barel', 100);

-- --------------------------------------------------------

--
-- Struktura tabulky `reky`
--

DROP TABLE IF EXISTS `reky`;
CREATE TABLE IF NOT EXISTS `reky` (
                                      `id_reky` int(11) NOT NULL,
                                      `nazev` varchar(45) COLLATE utf8_czech_ci NOT NULL,
                                      PRIMARY KEY (`id_reky`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `reky`
--

INSERT INTO `reky` (`id_reky`, `nazev`) VALUES
(1, 'Vltava'),
(2, 'Morava'),
(3, 'Labe'),
(4, 'Berounka'),
(5, 'Ohře'),
(6, 'Dyje'),
(7, 'Sázava'),
(8, 'Lužnice'),
(9, 'Otava'),
(10, 'Mže');

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
                                      `id_user` int(11) NOT NULL AUTO_INCREMENT,
                                      `email` varchar(45) COLLATE utf8_czech_ci NOT NULL,
                                      `username` varchar(45) COLLATE utf8_czech_ci NOT NULL,
                                      `password` varchar(45) COLLATE utf8_czech_ci NOT NULL,
                                      `PRAVA_id_prava` int(11) NOT NULL,
                                      PRIMARY KEY (`id_user`),
                                      KEY `fk_USER_PRAVA1_idx` (`PRAVA_id_prava`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `user`
--

INSERT INTO `user` (`id_user`, `email`, `username`, `password`, `PRAVA_id_prava`) VALUES
(1, 'spravce@email.cz', 'admin', 'admin', 1),
(2, 'zamestnanec@email.cz', 'zamestnanec', 'zamestnanec', 2),
(3, 'uzivatel@email.cz', 'uzivatel', 'uzivatel', 3),
(4, 'japejape456@gmail.com', 'Jan', 'a', 3);

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `objednavka`
--
ALTER TABLE `objednavka`
    ADD CONSTRAINT `fk_OBJEDNAVKA_REKY1` FOREIGN KEY (`REKY_id_reky`) REFERENCES `reky` (`id_reky`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    ADD CONSTRAINT `fk_OBJEDNAVKA_USER1` FOREIGN KEY (`USER_id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `objednavky_lodi`
--
ALTER TABLE `objednavky_lodi`
    ADD CONSTRAINT `fk_table1_LODE1` FOREIGN KEY (`LODE_id_lod`) REFERENCES `lode` (`id_lod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    ADD CONSTRAINT `fk_table1_OBJEDNAVKA1` FOREIGN KEY (`OBJEDNAVKA_id_objednavky`) REFERENCES `objednavka` (`id_objednavky`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `pomocna_prislusenstvi`
--
ALTER TABLE `pomocna_prislusenstvi`
    ADD CONSTRAINT `fk_POMOCNA_OBJEDNAVKA1` FOREIGN KEY (`OBJEDNAVKA_id_objednavky`) REFERENCES `objednavka` (`id_objednavky`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    ADD CONSTRAINT `fk_POMOCNA_PRISLUSENSTVI` FOREIGN KEY (`PRISLUSENSTVI_id_prislusenstvi`) REFERENCES `prislusenstvi` (`id_prislusenstvi`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `user`
--
ALTER TABLE `user`
    ADD CONSTRAINT `fk_USER_PRAVA1` FOREIGN KEY (`PRAVA_id_prava`) REFERENCES `prava` (`id_prava`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
