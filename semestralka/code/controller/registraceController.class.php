<?php

require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladač pro výpis registrace
 */
class registraceController
{
    /** @var MyDatabase $db  Sprava databaze. */
    private $db;
    /**
     * @var userManage $user Správa uživatele
     */
    private $user;

    /**
     * Inicializace připojení k databázi a správě uživatele
     */
    public function __construct() {
        require_once (DIRECTORY_MODELS ."/MyDatabase.class.php");
        $this->db = new MyDatabase();
        require_once (DIRECTORY_MODELS ."/userManage.php");
        $this->user = new userManage();
    }

    /**
     * Vrátí obsah stránky s registrací
     * @param string $pageTitle     Název stránky
     * @return string               Výpis
     */
    public function show(string $pageTitle):string {
        global $tplData;
        $tplData = [];

        $tplData['title'] = $pageTitle;

        if(isset($_POST['odhlasit']) and $_POST['odhlasit'] == "odhlasit"){
            $this->user->userLogout();
        }

        $tplData['userLogged'] = $this->user->isUserLogged();

        if($tplData['userLogged']){
            $user = $this->user->getLoggedUserData();
            $tplData['pravo'] = $user['PRAVA_id_prava'];
        } else {
            $tplData['pravo'] = null;
        }

        //Registrace nového zákazníka
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

        ob_start();
        require(DIRECTORY_VIEWS ."/registrace.php");
        $obsah = ob_get_clean();

        return $obsah;
    }
}
?>