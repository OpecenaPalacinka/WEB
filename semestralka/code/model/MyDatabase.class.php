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
     * Ziskani zaznamu vsech lodí z aplikace.
     *
     * @return array    Pole se vsemi loděmi.
     */
    public function getAUser($email){
        // ziskam vsechny uzivatele z DB razene dle ID a vratim je
        $q = "SELECT * FROM ".TABLE_USER
            ." WHERE email=:uEmail;";
        $user = $this->pdo->prepare($q);
        $user->bindValue(":uEmail",$email);
        if($user->execute()){
            return $user->fetchAll();
        } else {
            return null;
        }
    }

    public function getExactReka($jmenoReky){
        $reka = $this->selectFromTable(TABLE_REKY, "nazev='$jmenoReky'");
        return $reka[0];
    }

    public function vytvorObjednavku($id,$datumVyberu,$id_user,$id_reky,$datumVraceni,$schvalena=0): bool
    {

        $q = "INSERT INTO ".TABLE_OBJEDNAVKA." (id_objednavky,datum_vytvoreni,USER_id_user,REKY_id_reky,schvalena,datum_vraceni) 
        VALUES (:idObj,:datumVyberu, :ID_User, :ID_Reky,:schvalena,:datumVraceni);";
        $vystup = $this->pdo->prepare($q);

        $vystup->bindValue(":idObj", $id);
        $vystup->bindValue(":datumVyberu", $datumVyberu);
        $vystup->bindValue(":ID_User", $id_user);
        $vystup->bindValue(":ID_Reky", $id_reky);
        $vystup->bindValue(":schvalena", $schvalena);
        $vystup->bindValue(":datumVraceni", $datumVraceni);

        if($vystup->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function pridejPrislusenstvi($idPrislu,$idObj,$pocet){

        $q = "INSERT INTO ".TABLE_POMOCNA_PRISLUSENSTVI." (PRISLUSENSTVI_id_prislusenstvi,OBJEDNAVKA_id_objednavky,pocet) 
        VALUES (:idPrislu,:idObj,:pocet);";
        $vystup = $this->pdo->prepare($q);

        $vystup->bindValue(":idPrislu", $idPrislu);
        $vystup->bindValue(":idObj", $idObj);
        $vystup->bindValue(":pocet", $pocet);

        if($vystup->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function pridejLod($idlod,$idObj,$pocet){

        $q = "INSERT INTO ".TABLE_OBJEDNAVKA_LODE." (LODE_id_lod,OBJEDNAVKA_id_objednavky,pocet) 
        VALUES (:idLod,:idObj,:pocet);";
        $vystup = $this->pdo->prepare($q);

        $vystup->bindValue(":idLod", $idlod);
        $vystup->bindValue(":idObj", $idObj);
        $vystup->bindValue(":pocet", $pocet);

        if($vystup->execute()){
            return true;
        } else {
            return false;
        }
    }


    /**
     * Nalezne uzivatele s danym loginem a heslem a vrati je.
     * @param $email
     * @param $password
     * @return mixed
     */
    public function vratUzivatele($email, $password){

        $q = "SELECT * FROM ".TABLE_USER." WHERE email=:uLogin AND password=:uHeslo;";
        $vystup = $this->pdo->prepare($q);
        $vystup->bindValue(":uLogin", $email);
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
    public function registrujUzivatele($email, $username, $password): bool
    {

        $email = htmlspecialchars($email);
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);

        // zjistim, zda ho uz nemam v DB
        $uzivatel = $this->vratUzivatele($email,$password);

        // mohu uzivatele vlozit do DB?
        if(!isset($uzivatel) || count($uzivatel)==0){

            /////// START: Osetreni SQL Injection ////////////
            // vykonani SQL dotazu vyuzitim predpripaveneho dotazu
            $q = "INSERT INTO ".TABLE_USER." (id_user,email,username,password,PRAVA_id_prava) VALUES (NULL,:email, :login, :heslo,3);";
            $vystup = $this->pdo->prepare($q);
            $vystup->bindValue(":email", $email);
            $vystup->bindValue(":login", $username);
            $vystup->bindValue(":heslo", $password);

            if($vystup->execute()){
                // dotaz probehl v poradku
                return true;
            } else {
                // dotaz skoncil chybou
                return false;
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

}
?>
