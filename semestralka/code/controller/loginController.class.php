<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani uvodni stranky.
 */
class loginController implements IController {

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

        if(isset($_POST['odhlasit']) and $_POST['odhlasit'] == "odhlasit"){
            $this->user->userLogout();
            header("URL=index.php?page=uvod");
        }

        $tplData['userLogged'] = $this->user->isUserLogged();
        if($tplData['userLogged']){
            $user = $this->user->getLoggedUserData();
            $tplData['pravo'] = $user['PRAVA_id_prava'];
        } else {
            $tplData['pravo'] = 10;
        }

        if (isset($_POST['prihlasit']) and isset($_POST['email']) and
            isset($_POST['password']) and $_POST['prihlasit'] == "prihlasit"){

            $email = htmlspecialchars($_POST['email']);
            $heslo = htmlspecialchars($_POST['password']);
            $uzivatel = $this->db->vratUzivatele($email,$heslo);
            if (!empty($uzivatel)){
                $tplData['userLogged'] = $this->user->userLogin($email,$heslo);
                $tplData['povedloSe'] = true;
                $tplData['login'] = "Přihlášení se povedlo! Vítejte ".$uzivatel[0]['username'];
            } else {
                $tplData['povedloSe'] = false;
                $tplData['login'] = "Zadali jste špatný email nebo heslo!";
            }
        }



        //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS ."/login.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }

}

?>