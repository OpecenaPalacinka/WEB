<?php

require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladač zajišťující vypsání uživatelova profilu.
 */
class profilController implements IController {

	/** @var MyDatabase $db  Sprava databaze. */
	private $db;
	/**
	 * @var userManage  $user Načtení správy uživatele
	 */
	private $user;

	/**
	 * Inicializace pripojeni k databazi a ke správě uživatele.
	 */
	public function __construct() {
		// inicializace prace s DB
		require_once (DIRECTORY_MODELS ."/MyDatabase.class.php");
		$this->db = new MyDatabase();
		require_once (DIRECTORY_MODELS ."/userManage.php");
		$this->user = new userManage();
	}

	/**
	 * Vrati obsah profilu.
	 * @param string $pageTitle     Název stránky.
	 * @return string
	 */
	public function show(string $pageTitle):string {
		global $tplData;
		$tplData = [];

		$tplData['title'] = $pageTitle;


		if(isset($_POST['odhlasit']) and $_POST['odhlasit'] == "odhlasit"){
			$this->user->userLogout();
			header('location: index.php?page=uvod');
		}

		$tplData['userLogged'] = $this->user->isUserLogged();

		if($tplData['userLogged']){
			$user = $this->user->getLoggedUserData();
			$tplData['pravo'] = $user['PRAVA_id_prava'];
			$tplData['username'] = $user['username'];
			$tplData['email'] = $user['email'];
			$tplData['password'] = $user['password'];
		} else {
			$tplData['pravo'] = null;
		}

		$objednavky = $this->db->getExactObjByUserId($user['id_user']);

		//Převedení objednávek z ID udajů na názvy
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

		$tplData['exactUserObj'] = $objednavky;

		ob_start();
		require(DIRECTORY_VIEWS ."/profil.php");
		$obsah = ob_get_clean();

		return $obsah;
	}

}

?>