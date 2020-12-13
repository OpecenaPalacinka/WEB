<?php
//////////////////////////////////////////////////////////////
////////////// Vlastni trida pro praci s databazi ////////////////
//////////////////////////////////////////////////////////////

/**
 * Vlastni trida spravujici databazi.
 */
class MyDatabase {

    /** @var PDO $pdo  PDO objekt pro praci s databazi. */
    private $pdo;

    /** @var MySession $mySession  Vlastni objekt pro spravu session. */
    private $mySession;

    /** @var string $userSessionKey  Klicem pro data uzivatele, ktera jsou ulozena v session. */
    private $userSessionKey = "current_user_id";


    /**
     * MyDatabase constructor.
     * Inicializace pripojeni k databazi a pokud ma byt spravovano prihlaseni uzivatele,
     * tak i vlastni objekt pro spravu session.
     * Pozn.: v samostatne praci by sprava prihlaseni uzivatele mela byt v samostatne tride.
     * Pozn.2: take je mozne do samostatne tridy vytahnout konkretni funkce pro praci s databazi.
     */
    public function __construct(){
        // inicialilzuju pripojeni k databazi - informace beru ze settings
        $this->pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $this->pdo->exec("set names utf8");
        // inicializuju objekt pro praci se session - pouzito pro spravu prihlaseni uzivatele
        // pozn.: v samostatne praci vytvorte pro spravu prihlaseni uzivatele samostatnou tridu.
        require_once("MySessions.class.php");
        $this->mySession = new MySession();
    }


    ///////////////////  Obecne funkce  ////////////////////////////////////////////

    /**
     *  Provede dotaz a bud vrati ziskana data, nebo pri chybe ji vypise a vrati null.
     *
     *  @param string $dotaz        SQL dotaz.
     *  @return PDOStatement|null    Vysledek dotazu.
     */
    private function executeQuery(string $dotaz){
        // vykonam dotaz
        $res = $this->pdo->query($dotaz);
        // pokud neni false, tak vratim vysledek, jinak null
        if ($res) {
            // neni false
            return $res;
        } else {
            // je false - vypisu prislusnou chybu a vratim null
            $error = $this->pdo->errorInfo();
            echo $error[2];
            return null;
        }
    }

    /**
     * Jednoduche cteni z prislusne DB tabulky.
     *
     * @param string $tableName         Nazev tabulky.
     * @param string $whereStatement    Pripadne omezeni na ziskani radek tabulky. Default "".
     * @param string $orderByStatement  Pripadne razeni ziskanych radek tabulky. Default "".
     * @return array                    Vraci pole ziskanych radek tabulky.
     */
    public function selectFromTable(string $tableName, string $whereStatement = "", string $orderByStatement = ""):array {
        // slozim dotaz
        $q = "SELECT * FROM ".$tableName
            .(($whereStatement == "") ? "" : " WHERE $whereStatement")
            .(($orderByStatement == "") ? "" : " ORDER BY $orderByStatement");
        // provedu ho a vratim vysledek
        $obj = $this->executeQuery($q);
        // pokud je null, tak vratim prazdne pole
        if($obj == null){
            return [];
        }
        // projdu jednotlive ziskane radky tabulky
        /*while($row = $vystup->fetch(PDO::FETCH_ASSOC)){
            $pole[] = $row['login'].'<br>';
        }*/
        // prevedu vsechny ziskane radky tabulky na pole
        return $obj->fetchAll();
    }

    /**
     * Jednoduchy zapis do prislusne tabulky.
     *
     * @param string $tableName         Nazev tabulky.
     * @param string $insertStatement   Text s nazvy sloupcu pro insert.
     * @param string $insertValues      Text s hodnotami pro prislusne sloupce.
     * @return bool                     Vlozeno v poradku?
     */
    public function insertIntoTable(string $tableName, string $insertStatement, string $insertValues):bool {
        // slozim dotaz
        $q = "INSERT INTO $tableName($insertStatement) VALUES ($insertValues)";
        // provedu ho a vratim uspesnost vlozeni
        $obj = $this->executeQuery($q);
        if($obj == null){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Jednoducha uprava radku databazove tabulky.
     *
     * @param string $tableName                     Nazev tabulky.
     * @param string $updateStatementWithValues     Cela cast updatu s hodnotami.
     * @param string $whereStatement                Cela cast pro WHERE.
     * @return bool                                 Upraveno v poradku?
     */
    public function updateInTable(string $tableName, string $updateStatementWithValues, string $whereStatement):bool {
        // slozim dotaz
        $q = "UPDATE $tableName SET $updateStatementWithValues WHERE $whereStatement";
        // provedu ho a vratim vysledek
        $obj = $this->executeQuery($q);
        if($obj == null){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Dle zadane podminky maze radky v prislusne tabulce.
     *
     * @param string $tableName Nazev tabulky.
     * @param string $whereStatement Podminka mazani.
     * @return bool
     */
    public function deleteFromTable(string $tableName, string $whereStatement): bool
    {
        // slozim dotaz
        $q = "DELETE FROM $tableName WHERE $whereStatement";
        // provedu ho a vratim vysledek
        $obj = $this->executeQuery($q);
        if($obj == null){
            return false;
        } else {
            return true;
        }
    }

    ///////////////////  KONEC: Obecne funkce  ////////////////////////////////////////////

    ///////////////////  Konkretni funkce  ////////////////////////////////////////////

    /**
     * Ziskani zaznamu vsech lodí z aplikace.
     *
     * @return array    Pole se vsemi loděmi.
     */
    public function getAllLode(){
        // ziskam vsechny uzivatele z DB razene dle ID a vratim je
        $cena = $this->selectFromTable(TABLE_LODE, "", "id_lod");
        return $cena;
    }

    /**
     * Ziskani zaznamu vseho prislusenstvi z aplikace.
     *
     * @return array    Pole se vsim prislusenstvim.
     */
    public function getAllPrislusenstvi(){
        // ziskam vsechny uzivatele z DB razene dle ID a vratim je
        $prislusenstvi = $this->selectFromTable(TABLE_PRISLUSENSTVI, "", "id_prislusenstvi");
        return $prislusenstvi;
    }

    /**
     * Ziskani zaznamu vsech lodí z aplikace.
     *
     * @return array    Pole se vsemi loděmi.
     */
    public function getAllReky(){
        // ziskam vsechny uzivatele z DB razene dle ID a vratim je
        $reky = $this->selectFromTable(TABLE_REKY, "", "id_reky");
        return $reky;
    }


    /**
     * Ziskani konkretniho prava uzivatele dle ID prava.
     *
     * @param int $id       ID prava.
     * @return array        Data nalezeneho prava.
     */
    public function getRightById(int $id){
        // ziskam pravo dle ID
        $rights = $this->selectFromTable(TABLE_PRAVA, "id_pravo=$id");
        if(empty($rights)){
            return null;
        } else {
            // vracim prvni nalezene pravo
            return $rights[0];
        }
    }

    /**
     * Nalezne uzivatele s danym loginem a heslem a vrati je.
     * @param $username
     * @param $password
     * @return mixed
     */
    public function vratUzivatele($username, $password){

        $q = "SELECT * FROM ".TABLE_USER." WHERE username=:uLogin AND password=:uHeslo;";
        $vystup = $this->pdo->prepare($q);
        $vystup->bindValue(":uLogin", $username);
        $vystup->bindValue(":uHeslo", $password);
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
     * @param $email
     * @param $username
     * @param $password
     */
    public function registrujUzivatele($email, $username, $password){

        $email = htmlspecialchars($email);
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);

        // zjistim, zda ho uz nemam v DB
        $uzivatel = $this->vratUzivatele($username,$password);

        // mohu uzivatele vlozit do DB?
        if(!isset($uzivatel) || count($uzivatel)==0){

            /////// START: Osetreni SQL Injection ////////////
            // vykonani SQL dotazu vyuzitim predpripaveneho dotazu
            $q = "INSERT INTO ".TABLE_USER." (email, username, password) VALUES (:email, :login, :heslo);";
            $vystup = $this->pdo->prepare($q);
            $vystup->bindValue(":email", $email);
            $vystup->bindValue(":login", $username);
            $vystup->bindValue(":heslo", $password);

            if($vystup->execute()){
                // dotaz probehl v poradku
                echo "Registrován nový uživatel.";
            } else {
                // dotaz skoncil chybou
                echo "Registrace uživatele se nezdařila.";
            }
            /////// KONEC: Osetreni SQL Injection ///
        }

    }

    /**
     * Uprava konkretniho uzivatele v databazi.
     *
     * @param int $idUzivatel   ID upravovaneho uzivatele.
     * @param string $login     Login.
     * @param string $heslo     Heslo.
     * @param string $jmeno     Jmeno.
     * @param string $email     E-mail.
     * @param int $idPravo      ID prava.
     * @return bool             Bylo upraveno?
     */
    public function updateUser(int $idUzivatel, string $login, string $heslo, string $jmeno, string $email, int $idPravo){
        // slozim cast s hodnotami
        $updateStatementWithValues = "login='$login', heslo='$heslo', jmeno='$jmeno', email='$email', id_pravo='$idPravo'";
        // podminka
        $whereStatement = "id_uzivatel=$idUzivatel";
        // provedu update
        return $this->updateInTable(TABLE_USER, $updateStatementWithValues, $whereStatement);
    }

    ///////////////////  KONEC: Konkretni funkce  ////////////////////////////////////////////

    ///////////////////  Sprava prihlaseni uzivatele  ////////////////////////////////////////

    /**
     * Overi, zda muse byt uzivatel prihlasen a pripadne ho prihlasi.
     *
     * @param string $login     Login uzivatele.
     * @param string $heslo     Heslo uzivatele.
     * @return bool             Byl prihlasen?
     */
    public function userLogin(string $login, string $heslo){
        // ziskam uzivatele z DB - primo overuju login i heslo
        $where = "login='$login' AND heslo='$heslo'";
        $user = $this->selectFromTable(TABLE_USER, $where);
        // ziskal jsem uzivatele
        if(count($user)){
            // ziskal - ulozim ho do session
            $_SESSION[$this->userSessionKey] = $user[0]['id_uzivatel']; // beru prvniho nalezeneho a ukladam jen jeho ID
            return true;
        } else {
            // neziskal jsem uzivatele
            return false;
        }
    }

    /**
     * Odhlasi soucasneho uzivatele.
     */
    public function userLogout(){
        unset($_SESSION[$this->userSessionKey]);
    }

    /**
     * Test, zda je nyni uzivatel prihlasen.
     *
     * @return bool     Je prihlasen?
     */
    public function isUserLogged(){
        return isset($_SESSION[$this->userSessionKey]);
    }

    /**
     * Pokud je uzivatel prihlasen, tak vrati jeho data,
     * ale pokud nebyla v session nalezena, tak vypisu chybu.
     *
     * @return mixed|null   Data uzivatele nebo null.
     */
    public function getLoggedUserData(){
        if($this->isUserLogged()){
            // ziskam data uzivatele ze session
            $userId = $_SESSION[$this->userSessionKey];
            // pokud nemam data uzivatele, tak vypisu chybu a vynutim odhlaseni uzivatele
            if($userId == null) {
                // nemam data uzivatele ze session - vypisu jen chybu, uzivatele odhlasim a vratim null
                echo "SEVER ERROR: Data přihlášeného uživatele nebyla nalezena, a proto byl uživatel odhlášen.";
                $this->userLogout();
                // vracim null
                return null;
            } else {
                // nactu data uzivatele z databaze
                $userData = $this->selectFromTable(TABLE_USER, "id_uzivatel=$userId");
                // mam data uzivatele?
                if(empty($userData)){
                    // nemam - vypisu jen chybu, uzivatele odhlasim a vratim null
                    echo "ERROR: Data přihlášeného uživatele se nenachází v databázi (mohl být smazán), a proto byl uživatel odhlášen.";
                    $this->userLogout();
                    return null;
                } else {
                    // protoze DB vraci pole uzivatelu, tak vyjmu jeho prvni polozku a vratim ziskana data uzivatele
                    return $userData[0];
                }
            }
        } else {
            // uzivatel neni prihlasen - vracim null
            return null;
        }
    }

    ///////////////////  KONEC: Sprava prihlaseni uzivatele  ////////////////////////////////////////

}
?>
