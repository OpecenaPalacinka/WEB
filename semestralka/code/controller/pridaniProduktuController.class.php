<?php

require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladač zajišťující vypsání ceníku.
 */
class pridaniProduktuController implements IController {

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
	 * Vrati obsah ceníku.
	 * @param string $pageTitle     Název stránky.
	 * @return string
	 */
	public function show(string $pageTitle):string {
		global $tplData;
		$tplData = [];

		$tplData['title'] = $pageTitle;

		$IDLastReky = $this->db->getAllReky();

		$IDLastReky = count($IDLastReky) + 1;

		$tplData['lastIndexRekyPlusOne'] = $IDLastReky;

		$IDLastLodi = $this->db->getAllLode();
		$IDLastLodi = count($IDLastLodi) +1;

		$tplData['lastIndexLodiPlusOne'] = $IDLastLodi;

		$IDLastPrislu = $this->db->getAllPrislusenstvi();
		$IDLastPrislu = count($IDLastPrislu) +2;

		$tplData['lastIndexPrisluPlusOne'] = $IDLastPrislu;


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

		if (isset($_POST['registruj']) and isset($_POST['email']) and
			isset($_POST['password']) and isset($_POST['username']) and
			$_POST['registruj'] == "registruj"){

			$email = htmlspecialchars($_POST['email']);
			$heslo = htmlspecialchars($_POST['password']);
			$username = htmlspecialchars($_POST['username']);
			$isRegistered = $this->db->getAUser($email);
			if(!count($isRegistered)){
				$tplData['povedloSe'] = $this->db->registrujUzivatele($email,$username,$heslo,2);
				$tplData['login'] = "Registrace se zdařila! Vítejte ".$username;
			} else {
				$tplData['povedloSe'] = false;
				$tplData['login'] = "Je mi líto, ale registrace se nezdařila. Nejspíše už je tento email použit.";
			}
		}

		if (isset($_POST['pridejReku']) and isset($_POST['nazevReky']) and
			$_POST['pridejReku'] == "pridejReku"){

			$nazevReky = htmlspecialchars($_POST['nazevReky']);
			$IDReky = htmlspecialchars($_POST['idReky']);
			$isReka = $this->db->getExactReka($nazevReky);

			if(!count($isReka)){
				$tplData['povedloSe'] = $this->db->pridejReku($IDReky,$nazevReky);
				$tplData['login'] = "Přidání řeky se zdařilo! Přidal jsem ".$nazevReky;
			} else {
				$tplData['povedloSe'] = false;
				$tplData['login'] = "Je mi líto, ale přidání řeky se nezdařilo. Nejspíše už je řeka přidána.";
			}
		}

		if (isset($_POST['pridejLod']) and isset($_POST['nazevLodi']) and
			isset($_POST['cenaLodi']) and $_POST['pridejLod'] == "pridejLod"){

			$nazevLodi = htmlspecialchars($_POST['nazevLodi']);
			$IDLodi = htmlspecialchars($_POST['idLodi']);
			$cena = htmlspecialchars($_POST['cenaLodi']);
			$isLod = $this->db->getExactLodByName($nazevLodi);
			if(!count($isLod)){
				$tplData['povedloSe'] = $this->db->pridejNovouLod($IDLodi,$nazevLodi,$cena);
				$tplData['login'] = "Přidání lodě se zdařilo! Přidal jsem ".$nazevLodi." s cenou ".$cena." KČ";
			} else {
				$tplData['povedloSe'] = false;
				$tplData['login'] = "Je mi líto, ale přidání lodě se nezdařilo. Nejspíše už je loď přidána.";
			}
		}

		if (isset($_POST['pridejPrislu']) and isset($_POST['nazevPrislu']) and
			isset($_POST['cenaPrislu']) and $_POST['pridejPrislu'] == "pridejPrislu"){

			$nazevPrislu = htmlspecialchars($_POST['nazevPrislu']);
			$IDPrislu = htmlspecialchars($_POST['idPrislu']);
			$cenaPrislu = htmlspecialchars($_POST['cenaPrislu']);
			$isPrislu = $this->db->getExactPrisluByName($nazevPrislu);
			if(!count($isPrislu)){
				$tplData['povedloSe'] = $this->db->pridejNovePrislusenstvi($IDPrislu,$nazevPrislu,$cenaPrislu);
				$tplData['login'] = "Přidání příslušenství se zdařilo! Přidal jsem ".$nazevPrislu." s cenou ".$cenaPrislu." KČ";
			} else {
				$tplData['povedloSe'] = false;
				$tplData['login'] = "Je mi líto, ale přidání příslušenství se nezdařilo. Nejspíše už je příslušenství přidáno.";
			}
		}

		ob_start();
		require(DIRECTORY_VIEWS ."/pridaniProduktu.php");
		$obsah = ob_get_clean();

		return $obsah;
	}

}

?>