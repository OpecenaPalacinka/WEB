<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladač zajišťující vypsaní objednávek pro zaměstnance
 */
class objednavkyController implements IController {

    /** @var MyDatabase $db  Sprava databaze. */
    private $db;
    /**
     * @var userManage $user Správa uživatele
     */
    private $user;

    /**
     * Inicializace připojení k databázi a správě uživatele.
     */
    public function __construct() {
        // inicializace prace s DB
        require_once (DIRECTORY_MODELS ."/MyDatabase.class.php");
        $this->db = new MyDatabase();
        require_once (DIRECTORY_MODELS ."/userManage.php");
        $this->user = new userManage();
    }

    /**
     * Vrátí obsah stránky pro výpis objednávek
     * @param string $pageTitle     Název stránky
     * @return string               Výpis
     */
    public function show(string $pageTitle):string {
        global $tplData;
        $tplData = [];

        $tplData['title'] = $pageTitle;

        $objednavky = $this->db->getAllObjednavky();

        //Převedu objednávky tak, abych místo ID měl názvy.
        foreach ($objednavky as $key => $objednavka){
            $objednavky[$key]['REKY_id_reky'] = $this->db->getExactRekaById($objednavka['REKY_id_reky'])['nazev'];
            $objednavky[$key]['USER_id_user'] = $this->db->getExactUserById($objednavka['USER_id_user'])['username'];
            $exactlode = $this->db->getAllLodeByIdObjednavky($objednavka['id_objednavky']);
            $exactPrislu = $this->db->getAllPrisluByIdObjednavky($objednavka['id_objednavky']);
            foreach ($exactlode as $keySecond => $exactLod){
                $exactlode[$keySecond]['LODE_id_lod'] = $this->db->getExactLodById($exactLod['LODE_id_lod'])['typ_lode'];
            }
            foreach ($exactPrislu as $keyThird => $exactPrislusenstvi){
                $exactPrislu[$keyThird]['PRISLUSENSTVI_id_prislusenstvi'] = $this->db->getExactPrisluById($exactPrislusenstvi['PRISLUSENSTVI_id_prislusenstvi'])['nazev_prislusen'];
            }

            $tplData["lode".$objednavka["id_objednavky"]] = $exactlode;
            $tplData["prislu".$objednavka["id_objednavky"]] = $exactPrislu;
            if ($objednavka['schvalena'] == 0){
                $objednavky[$key]['schvalena'] = "NE";
            } else {
                $objednavky[$key]['schvalena'] = "ANO";
            }
        }

        $tplData['objednavky'] = $objednavky;

        if(isset($_POST['Schvalit'])){
            $objID = $_POST['Schvalit'];
            $obj = $this->db->getExactObjById($objID);
            $this->db->updateObjednavka($objID,$obj['datum_vytvoreni'],$obj['USER_id_user'],$obj['REKY_id_reky'],1,$obj['datum_vraceni']);
            header("Refresh:0");
        }

        if(isset($_POST['odhlasit']) and $_POST['odhlasit'] == "odhlasit"){
            $this->user->userLogout();
	        header('location: index.php?page=uvod');
        }

        $tplData['userLogged'] = $this->user->isUserLogged();

        if($tplData['userLogged']){
            $user = $this->user->getLoggedUserData();
            $tplData['pravo'] = $user['PRAVA_id_prava'];
        } else {
            $tplData['pravo'] = null;
        }

        ob_start();
        require(DIRECTORY_VIEWS ."/objednavky.php");
        $obsah = ob_get_clean();

        return $obsah;
    }
}
?>