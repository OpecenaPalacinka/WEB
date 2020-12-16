<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

class registraceController
{

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
        }

        $tplData['userLogged'] = $this->user->isUserLogged();

        if($tplData['userLogged']){
            $user = $this->user->getLoggedUserData();
            $tplData['pravo'] = $user['PRAVA_id_prava'];
        } else {
            $tplData['pravo'] = 10;
        }

        if (isset($_POST['registruj']) and isset($_POST['email']) and
            isset($_POST['password']) and isset($_POST['username']) and
            $_POST['registruj'] == "registruj"){

            $email = htmlspecialchars($_POST['email']);
            $heslo = htmlspecialchars($_POST['password']);
            $username = htmlspecialchars($_POST['username']);
            $isRegistered = $this->db->getAUser($email);
            if(!count($isRegistered)){
                $tplData['povedloSe'] = $this->db->registrujUzivatele($email,$username,$heslo);
                $tplData['login'] = "Registrace se zdařila! Vítejte ".$username;
            } else {
                $tplData['povedloSe'] = false;
                $tplData['login'] = "Je mi líto, ale registrace se nezdařila. Nejspíše už je tento email použit.";
            }
        }

        //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS ."/registrace.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }

}
?>