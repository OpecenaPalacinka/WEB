<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani stranky se spravou uzivatelu.
 */
class objednavkyController implements IController {

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
     * Vrati obsah stranky se spravou uzivatelu.
     * @param string $pageTitle     Nazev stranky.
     * @return string               Vypis v sablone.
     */
    public function show(string $pageTitle):string {
        //// vsechna data sablony budou globalni
        global $tplData;
        $tplData = [];
        // nazev
        $tplData['title'] = $pageTitle;

        $objednavky = $this->db->getAllObjednavky();

        foreach ($objednavky as $key => $objednavka){
            $objednavky[$key]['REKY_id_reky'] = $this->db->getExactRekaById($objednavka['REKY_id_reky'])['nazev'];
            $objednavky[$key]['USER_id_user'] = $this->db->getExactUserById($objednavka['USER_id_user'])['username'];
            if ($objednavka['schvalena'] == 0){
                $objednavky[$key]['schvalena'] = "NE";
            } else {
                $objednavky[$key]['schvalena'] = "ANO";
            }
        }

        $tplData['objednavky'] = $objednavky;

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

        //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS ."/objednavky.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }

}

?>