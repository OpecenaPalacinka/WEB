<?php
///////////////////////////////////////////////////////
////////////// Zakladni nastaveni webu ////////////////
///////////////////////////////////////////////////////

////// nastaveni pristupu k databazi ///////

    // prihlasovaci udaje k databazi
    define("DB_SERVER","localhost");
    define("DB_NAME","pujcovna_semestralka");
    define("DB_USER","root");
    define("DB_PASS","");

    // definice konkretnich nazvu tabulek
    define("TABLE_USER","user");
    define("TABLE_PRAVA","prava");
    define("TABLE_LODE","lode");
    define("TABLE_OBJEDNAVKA","objednavka");
    define("TABLE_OBJEDNAVKA_LODE","objednavky_lodi");
    define("TABLE_POMOCNA_PRISLUSENSTVI","pomocna_prislusenstvi");
    define("TABLE_PRISLUSENSTVI","prislusenstvi");
    define("TABLE_REKY","reky");


//// Dostupne stranky webu ////

/** Adresar kontroleru. */
const DIRECTORY_CONTROLLERS = "controller";
/** Adresar modelu. */
const DIRECTORY_MODELS = "model";
/** Adresar sablon */
const DIRECTORY_VIEWS = "view";

/** Klic defaultni webove stranky. */
const DEFAULT_WEB_PAGE_KEY = "uvod";

/** Dostupne webove stranky. */
const WEB_PAGES = array(
    //// Uvodni stranka ////
    "uvod" => array(
        "title" => "Úvodní stránka",

        //// kontroler
        "file_name" => "uvodController.class.php",
        "class_name" => "uvodController",
    ),
    //// KONEC: Uvodni stranka ////

    //// oNas ////
    "oNas" => array(
        "title" => "O nás",

        //// kontroler
        "file_name" => "oNasController.class.php",
        "class_name" => "oNasController",
    ),
    //// KONEC: oNas ////

    /// Registrace ///
    "registrace" => array(
        "title" => "Registrace",

        //// kontroler
        "file_name" => "registraceController.class.php",
        "class_name" => "registraceController"
    ),
    //// KONEC: Registrace /////

    //// Objednávka ////
    "objednavka" => array(
        "title" => "Objednávka",

        //// kontroler
        "file_name" => "objednavkaController.class.php",
        "class_name" => "objednavkaController",
    ),
    //// KONEC: Objednávka ////

    //// Login ////
    "login" => array(
        "title" => "Přihlášení",

        //// kontroler
        "file_name" => "loginController.class.php",
        "class_name" => "loginController",
    ),
    //// KONEC: Login ////

    //// Uvodni stranka ////
    "cenik" => array(
        "title" => "Ceník",

        //// kontroler
        "file_name" => "CenikController.class.php",
        "class_name" => "CenikController",
    ),
    //// KONEC: Uvodni stranka ////

    //// Objednávky ////
    "objednavky" => array(
        "title" => "Objednávky",

        //// kontroler
        "file_name" => "objednavkyController.class.php",
        "class_name" => "objednavkyController",
    ),
    //// KONEC: Objednávky ////
);


?>
