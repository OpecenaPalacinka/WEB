<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani uvodni stranky.
 */
class objednavkaController implements IController {

    /** @var MyDatabase $db  Sprava databaze. */
    private $db;
    /**
     * @var userManage
     */
    private $user;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct() {
        // inicializace prace s DB
        require_once (DIRECTORY_MODELS ."/MyDatabase.class.php");
        $this->db = new MyDatabase();
        require_once (DIRECTORY_MODELS ."/userManage.php");
        $this->user = new userManage();
    }

    /**
     * Vrati obsah uvodni stranky.
     * @param string $pageTitle     Nazev stranky.
     * @return string               Vypis v sablone.
     */
    public function show(string $pageTitle):string {
        //// vsechna data sablony budou globalni
        global $tplData;
        $tplData = [];
        // nazev
        $tplData['title'] = $pageTitle;

        $tplData['reky'] = $this->db->getAllReky();

        $tplData['lode'] = $this->db->getAllLode();

        $tplData['prislusenstvi'] = $this->db->getAllPrislusenstvi();

        if(isset($_POST['odhlasit']) and $_POST['odhlasit'] == "odhlasit"){
            $this->user->userLogout();
        }

        $tplData['userLogged'] = $this->user->isUserLogged();

        if($tplData['userLogged']){
            $user = $this->user->getLoggedUserData();
            $tplData['pravo'] = $user['PRAVA_id_prava'];
            $tplData['username'] = $user['username'];
            $tplData['email'] = $user['email'];
            $tplData['password'] = $user['password'];
        } else {
            $tplData['pravo'] = 10;
        }

        $tplData['zkouska'] = "Začátek";

        $tplData['povedloSe'] = false;
        $tplData['uspech'] = "Je mi líto, ale rezervace se nezdařila";

        if ($_POST['dat-vyp'] < date('Y-m-d')) {
            $tplData['povedloSe'] = false;
            $tplData['uspech'] = "Pokud nemáte stroj času, tak si prosím nerezervujte loď do minulosti.";
        } else if (isset($_POST['rezervace']) and isset($_POST['firstName']) and
            isset($_POST['password']) and isset($_POST['email']) and
            ($_POST['dat-vyp'] < $_POST['dat-vra'])){

            $email = htmlspecialchars($_POST['email']);
            $firstName = htmlspecialchars($_POST['firstName']);
            $password = htmlspecialchars($_POST['password']);
            $reka = htmlspecialchars($_POST['reka']);
            $reka = $this->db->getExactReka($reka);
            $IDreka = $reka['id_reky'];

            $datVyp = $_POST['dat-vyp'];
            $datVra = $_POST['dat-vra'];
            $lod1 = $_POST['lod1'];
            $lod2 = $_POST['lod2'];
            $lod3 = $_POST['lod3'];
            $lod4 = $_POST['lod4'];
            $lod5 = $_POST['lod5'];
            $padla = $_POST['padlo'];
            $vestaDosp = $_POST['vesta-dosp'];
            $vestaDite = $_POST['vesta-dite'];
            $barel = $_POST['barel'];
            $pumpa = $_POST['pumpa'];

            $cas = intval(time()/10);

            $tplData['zkouska'] = $datVyp;

            $isRegistred = $this->db->getAUser($email);
            if (!count($isRegistred)){
               $this->db->registrujUzivatele($email,$firstName,$password);
            }

            $user = $this->db->vratUzivatele($email,$password);

            if(count($user) and ($password == $user[0]['password']
                and $firstName == $user[0]['username'])) {
                $userID = $user[0]['id_user'];
                $this->db->vytvorObjednavku($cas,$datVyp,$userID,$IDreka,$datVra);
                if (!$lod1==0) {
                    $this->db->pridejLod(1, $cas, $lod1);
                }
                if (!$lod2==0) {
                    $this->db->pridejLod(2, $cas, $lod2);
                }
                if (!$lod3==0) {
                    $this->db->pridejLod(3, $cas, $lod3);
                }
                if (!$lod4==0) {
                    $this->db->pridejLod(4, $cas, $lod4);
                }
                if (!$lod5==0) {
                    $this->db->pridejLod(5, $cas, $lod5);
                }
                if (!$pumpa==0){
                    $this->db->pridejPrislusenstvi(1,$cas,$pumpa);
                }
                if (!$padla==0){
                    $this->db->pridejPrislusenstvi(2,$cas,$padla);
                }
                if (!$vestaDosp==0){
                    $this->db->pridejPrislusenstvi(4,$cas,$vestaDosp);
                }
                if (!$vestaDite==0){
                    $this->db->pridejPrislusenstvi(5,$cas,$vestaDite);
                }
                if (!$barel==0){
                    $this->db->pridejPrislusenstvi(6,$cas,$barel);
                }
                $tplData['povedloSe'] = true;
                $tplData['uspech'] = "Rezervace proběhla úspěšně.";
            } else  {
                $tplData['povedloSe'] = false;
                $tplData['uspech'] = "Je mi líto, ale zadali jste špatné jméno nebo heslo.";
            }



        }

        //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS ."/objednavka.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }

}

?>