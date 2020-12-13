<?php

/**
 * Trida pro spravu databaze.
 */
class Databaze{

    /** @var PDO $db  Instance PDO pro praci s databazi. */
    private $db;

    /// ukazka predpripraveneho dotazu
    /*
    $dotaz = "INSERT INTO ".TABLE_UZIVATELE." (jmeno, login, heslo, email) VALUES (?,?,?,?);";
    $vystup = $this->db->prepare($dotaz);
    $jm = htmlspecialchars($jm);
    $vystup->execute(array($jm, $log, $pas, $mail));
    */

    /**
     * Inicilalizace pripojeni k databazi.
     */
    public function __construct(){
        // nacteni nastaveni
        require_once("settings.inc.php");
        // vytvoreni instance PDO  pro praci s DB
        $this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
        // vynuceni kodovani UTF-8
        $q = "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'";
        $this->db->query($q);
    }

    /**
     * Nalezne uzivatele s danym loginem a heslem a vrati je.
     * @param string $log   Login.
     * @param string $pas   Heslo.
     * @return array
     */
    public function vratUzivatele($log, $pas){
        // ziskam vysledek dotazu klasicky
        //$vystup = $this->db->query("SELECT * FROM ".TABLE_UZIVATELE." WHERE login='$log' AND heslo='$pas';");
        // vsechny radky do pole a to vratim
        //return $pole = $vystup->fetchAll();

        /////// START: Osetreni SQL Injection ////////////
        // vykonani SQL dotazu vyuzitim predpripaveneho dotazu
        $q = "SELECT * FROM ".TABLE_UZIVATELE." WHERE login=:uLogin AND heslo=:uHeslo;";
        $vystup = $this->db->prepare($q);
        $vystup->bindValue(":uLogin", $log);
        $vystup->bindValue(":uHeslo", $pas);
        if($vystup->execute()){
            // dotaz probehl v poradku
            // vsechny radky do pole a to vratim
            return $vystup->fetchAll();
        } else {
            // dotaz skoncil chybou
            return null;
        }
        /////// KONEC: Osetreni SQL Injection ///

    }

    /**
     * Registruje noveho uzivatele (kombinace jmeno.
     * @param string $jm    Jmeno.
     * @param string $log   Login.
     * @param string $pas   Heslo.
     * @param string $mail  E-mail.
     */
    public function registrujUzivatele($jm, $log, $pas, $mail){
        // zjistim, zda ho uz nemam v DB
        $uzivatel = $this->vratUzivatele($log,$pas);

        // mohu uzivatele vlozit do DB?
        if(!isset($uzivatel) || count($uzivatel)==0){
            /// ziskam vysledek dotazu klasicky
            //$dotaz = "INSERT INTO ".TABLE_UZIVATELE." (jmeno, login, heslo, email) VALUES ('$jm', '$log', '$pas', '$mail');";
            //$this->db->query($dotaz);

            /////// START: Osetreni SQL Injection ////////////
            // vykonani SQL dotazu vyuzitim predpripaveneho dotazu
            $q = "INSERT INTO ".TABLE_UZIVATELE." (jmeno, login, heslo, email) VALUES (:jmeno, :login, :heslo, :email);";
            $vystup = $this->db->prepare($q);
            $vystup->bindValue(":jmeno", $jm);
            $vystup->bindValue(":login", $log);
            $vystup->bindValue(":heslo", $pas);
            $vystup->bindValue(":email", $mail);
            if($vystup->execute()){
                // dotaz probehl v poradku
                echo "Registrován nový uživatel.";
            } else {
                // dotaz skoncil chybou
                echo "Registrace uživatele se nezdařila.";
            }
            /////// KONEC: Osetreni SQL Injection ///
        }
        // pokud uzivatel nevytvoren, tak nic nedelam
    }

    /**
     * Vypise vsechny prispevky. (nema vstupni parametry, tj. neni co osetrit)
     * @return array
     */
    public function vratPrispevky(){
        // ziskam vysledek dotazu klasicky
        $vystup = $this->db->query("SELECT * FROM ".TABLE_KNIHA." ORDER BY idkniha DESC;");

        // vsechny radky do pole a to vratim
        return $vystup->fetchAll();
    }

    /**
     * Nalezne prispevek dle jeho ID.
     * @param int|string $id    ID prispevku, ktery ma byt vracen.
     * @return array
     */
    public function vratPrispevek($id){
        // ziskam vysledek dotazu klasicky
        //$vystup = $this->db->query("SELECT * FROM ".TABLE_KNIHA." WHERE idkniha=$id;");
        // vsechny radky do pole a to vratim
        //return $pole = $vystup->fetchAll();

        /////// START: Osetreni SQL Injection ///
        // vykonani SQL dotazu vyuzitim predpripaveneho dotazu
        $q = "SELECT * FROM ".TABLE_KNIHA." WHERE idkniha = :kID";
        $vystup = $this->db->prepare($q);
        if($vystup->execute(array( "kID" => $id ))){
            // dotaz probehl v poradku
            // vsechny radky do pole a to vratim
            return $vystup->fetchAll();
        } else {
            // dotaz skoncil chybou
            return null;
        }
        /////// KONEC: Osetreni SQL Injection ///
    }

    /**
     * Vlozi jeden prispevek do navstevni knihy.
     * @param string $uzivatel  Uzivatel odesilajici prispevek.
     * @param string $text      Text prispevku.
     */
    public function vlozPrispevek($uzivatel, $text){
        // osetreni XSS
        $uzivatel = htmlspecialchars($uzivatel);
        $text = htmlspecialchars($text);

        // ziskat vysledek dotazu klasicky
        //$this->db->query("INSERT INTO ".TABLE_KNIHA." (clovek, text) VALUES ('$uzivatel', '$text');");

        /////// START: Osetreni SQL Injection ///
        // vykonani SQL dotazu vyuzitim predpripaveneho dotazu
        $q = "INSERT INTO ".TABLE_KNIHA." (clovek, text) VALUES (:kUzivatel, :kText);";
        $vystup = $this->db->prepare($q);
        if($vystup->execute(array( "kUzivatel" => $uzivatel, "kText" => $text ))){
            // dotaz probehl v poradku
            echo "Přidán záznam do návštěvní knihy.";
        } else {
            // dotaz skoncil chybou
            echo "Přidání záznamu do návštěvní knihy se nezdařilo.";
        }
        /////// KONEC: Osetreni SQL Injection ///
    }
    
}


?>