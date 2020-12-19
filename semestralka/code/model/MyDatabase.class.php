<?php

/**
 * Třída spravující databázi
 */
class MyDatabase {

    /** @var PDO $pdo  PDO objekt pro práci s databází. */
    private $pdo;

    /**
     * Inicializace připojení k databázi.
     */
    public function __construct(){
        $this->pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $this->pdo->exec("set names utf8");
    }


    /**
     *  Provede dotaz a bud vrati ziskana data, nebo pri chybe ji vypise a vrati null.
     *
     *  @param string $dotaz        SQL dotaz.
     *  @return PDOStatement|null    Výsledek dotazu
     */
    private function executeQuery(string $dotaz): ?PDOStatement
    {

        $res = $this->pdo->query($dotaz);
        if ($res) {
            return $res;
        } else {
            $error = $this->pdo->errorInfo();
            echo $error[2];
            return null;
        }
    }

    /**
     * Select z jedné tabulky
     *
     * @param string $tableName         Název tabulky
     * @param string $whereStatement    Pripadne omezeni na ziskani radek tabulky. Default "".
     * @param string $orderByStatement  Pripadne razeni ziskanych radek tabulky. Default "".
     * @return array                    Vraci pole ziskanych radek tabulky.
     */
    public function selectFromTable(string $tableName, string $whereStatement = "", string $orderByStatement = ""):array {
        $q = "SELECT * FROM ".$tableName
            .(($whereStatement == "") ? "" : " WHERE $whereStatement")
            .(($orderByStatement == "") ? "" : " ORDER BY $orderByStatement");

        $obj = $this->executeQuery($q);
        if($obj == null){
            return [];
        }
        return $obj->fetchAll();
    }

    /**
     * Upráva řádku databáze
     *
     * @param string $tableName                     Nazev tabulky.
     * @param string $updateStatementWithValues     Cela cast updatu s hodnotami.
     * @param string $whereStatement                Cela cast pro WHERE.
     * @return bool                                 Upraveno v poradku?
     */
    public function updateInTable(string $tableName, string $updateStatementWithValues, string $whereStatement):bool {

        $q = "UPDATE $tableName SET $updateStatementWithValues WHERE $whereStatement";

        $obj = $this->executeQuery($q);
        if($obj == null){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Ziskani zaznamu vsech lodí z aplikace.
     *
     * @return array    Pole se vsemi loděmi.
     */
    public function getAllLode(): array
    {
        $cena = $this->selectFromTable(TABLE_LODE, "", "id_lod");
        return $cena;
    }

    /**
     * Ziskani zaznamu vseho prislusenstvi z aplikace.
     *
     * @return array    Pole se vsim prislusenstvim.
     */
    public function getAllPrislusenstvi(): array
    {
        $prislusenstvi = $this->selectFromTable(TABLE_PRISLUSENSTVI, "", "id_prislusenstvi");
        return $prislusenstvi;
    }

    /**
     * Ziskani zaznamu vsech řek z aplikace.
     *
     * @return array    Pole se vsemi řekami.
     */
    public function getAllReky(): array
    {
        $reky = $this->selectFromTable(TABLE_REKY, "", "id_reky");
        return $reky;
    }

    /**
     * Ziskani zaznamu vsech objednávek z aplikace.
     *
     * @return array    Pole se vsemi objednávkami.
     */
    public function getAllObjednavky(): array
    {
        $objednavky = $this->selectFromTable(TABLE_OBJEDNAVKA,"","datum_vytvoreni");
        return $objednavky;
    }

    /**
     * Získání uživatele podle Emailu.
     *
     * @param string $email    Email pro vyhledání v databízi.
     * @return array    Pole se vsemi uživateli (vždycky bude pouze jeden uživatel).
     */
    public function getAUser(string $email): ?array
    {
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

    /**
     * Získání jedné dané řeky podle jména řeky
     *
     * @param string $jmenoReky Jméno řeky
     * @return array    Pole se řekou.
     */
    public function getExactReka(string $jmenoReky): array
    {
        $reka = $this->selectFromTable(TABLE_REKY, "nazev='$jmenoReky'");
        return $reka[0];
    }

    /**
     * Získání jedné řeky podle jejího ID.
     *
     * @param int $id   ID hledané řeky
     * @return array    Pole s řekou.
     */
    public function getExactRekaById(int $id): array
    {
        $reka = $this->selectFromTable(TABLE_REKY, "id_reky='$id'");
        return $reka[0];
    }

    /**
     * Získání jednoho uživatele podle jeho ID
     *
     * @param int $id   ID uživatele
     * @return array    Pole s prvním uživatelem.
     */
    public function getExactUserById(int $id): array
    {
        $user = $this->selectFromTable(TABLE_USER, "id_user='$id'");
        return $user[0];
    }

    /**
     * Získání všech lodí, které jsou v jedné objednávce
     *
     * @param int $idObjednavky ID objednávky ve které hledám lodě
     * @return array    Pole se vsemi loděmi.
     */
    public function getAllLodeByIdObjednavky(int $idObjednavky): array
    {
        $lode = $this->selectFromTable(TABLE_OBJEDNAVKA_LODE,"OBJEDNAVKA_id_objednavky='$idObjednavky'");
        return $lode;
    }

    /**
     * Získání dané lodě podle jejího ID.
     *
     * @param int $id   ID lodě
     * @return array    Pole s lodí.
     */
    public function getExactLodById(int $id): array
    {
        $lod = $this->selectFromTable(TABLE_LODE, "id_lod='$id'");
        return $lod[0];
    }

    /**
     * Získání všeho příslušenství, které je u jedné objednávky
     *
     * @param int $idObjednavky ID objednávky ve které hledám příslušenství
     * @return array    Pole s příslušenstvím
     */
    public function getAllPrisluByIdObjednavky(int $idObjednavky): array
    {
        $prislu = $this->selectFromTable(TABLE_POMOCNA_PRISLUSENSTVI,"OBJEDNAVKA_id_objednavky='$idObjednavky'");
        return $prislu;
    }

    /**
     * Získání jednoho příslušenství podle jeho ID
     *
     * @param int $id   ID příslušenství
     * @return array    Pole s příslušenstvím
     */
    public function getExactPrisluById(int $id): array
    {
        $prislu = $this->selectFromTable(TABLE_PRISLUSENSTVI, "id_prislusenstvi='$id'");
        return $prislu[0];
    }

    /**
     * Získání objednávky podle jejího ID
     *
     * @param int $id   ID objednávky
     * @return array    Pole s danou objednávkou
     */
    public function getExactObjById(int $id): array
    {
        $obj = $this->selectFromTable(TABLE_OBJEDNAVKA, "id_objednavky='$id'");
        return $obj[0];
    }

    /**
     * Vytvoření celé objednávky
     *
     * @param int $id               ID objednávky
     * @param $datumVyberu          /Datum vypůjčení
     * @param $id_user              /ID uživatele, který vytvořil objednávku
     * @param $id_reky              /ID řeky, která byla vybrána
     * @param $datumVraceni         /Datum vrácení
     * @param int $schvalena        Byla schálena? 0 - NE || 1 - ANO
     * @return bool                 Povedlo se vytvořit objednávku?
     */
    public function vytvorObjednavku(int $id,$datumVyberu,$id_user,$id_reky,$datumVraceni,$schvalena=0): bool
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

    /**
     * Přidání příslušenství dané objednávky
     *
     * @param $idPrislu /ID příslušenství
     * @param $idObj    /ID objednávky
     * @param $pocet    /Počet příslušenství
     * @return bool     Povedlo se přidat?
     */
    public function pridejPrislusenstvi($idPrislu,$idObj,$pocet): bool
    {

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

    /**
     * Přidání lodí dané objednávky
     *
     * @param $idlod    /ID lodi
     * @param $idObj    /ID objednávky
     * @param $pocet    /Počet lodí
     * @return bool     Povedlo se?
     */
    public function pridejLod($idlod,$idObj,$pocet): bool
    {

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
     * Nalezne uživatele s daným emailem a heslem
     *
     * @param $email        /Email uživatele v databázi
     * @param $password     /Heslo uživatele
     * @return mixed        Vrácení uživatele pokud se povede nebo vrátí NULL
     */
    public function vratUzivatele($email, $password){

        $q = "SELECT * FROM ".TABLE_USER." WHERE email=:uLogin AND password=:uHeslo;";
        $vystup = $this->pdo->prepare($q);
        $vystup->bindValue(":uLogin", $email);
        $vystup->bindValue(":uHeslo", $password);
        if($vystup->execute()){
            return $vystup->fetchAll();
        } else {
            return null;
        }
    }

    /**
     * Registruje nového uživatele
     *
     * @param $email        /Email uživatele
     * @param $username     /Uživatelské jméno
     * @param $password     /Heslo
     * @return bool         Povedlo se?
     */
    public function registrujUzivatele($email, $username, $password): bool
    {

        $email = htmlspecialchars($email);
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);

        // zjistim, zda ho uz nemam v DB
        $uzivatel = $this->vratUzivatele($email,$password);

        if(!isset($uzivatel) || count($uzivatel)==0){

            $q = "INSERT INTO ".TABLE_USER." (id_user,email,username,password,PRAVA_id_prava) VALUES (NULL,:email, :login, :heslo,3);";
            $vystup = $this->pdo->prepare($q);
            $vystup->bindValue(":email", $email);
            $vystup->bindValue(":login", $username);
            $vystup->bindValue(":heslo", $password);

            if($vystup->execute()){
                return true;
            } else {
                return false;
            }
        }
        return false;
    }


    /**
     * Úprava konkrétní objednávky
     *
     * @param int $idObjednavky     ID objednávky
     * @param $datum_vytvoreni      /Datum vypůjčení
     * @param int $USER_id_user     /ID uživatele, který je autor objednávky
     * @param int $REKY_id_reky     /ID řeky, která byla vybrána
     * @param int $schvalena        /Schávalena? 0 = NE || 1 = ANO
     * @param $datum_vraceni        /Datum vrácení objednávky
     * @return bool                 Byla upravena?
     */
    public function updateObjednavka(int $idObjednavky, $datum_vytvoreni, int $USER_id_user, int $REKY_id_reky, int $schvalena, $datum_vraceni): bool
    {
        $updateStatementWithValues = "id_objednavky='$idObjednavky', datum_vytvoreni='$datum_vytvoreni', USER_id_user='$USER_id_user', REKY_id_reky='$REKY_id_reky', schvalena='$schvalena', datum_vraceni='$datum_vraceni'";

        $whereStatement = "id_objednavky=$idObjednavky";

        return $this->updateInTable(TABLE_OBJEDNAVKA, $updateStatementWithValues, $whereStatement);
    }
}
?>
