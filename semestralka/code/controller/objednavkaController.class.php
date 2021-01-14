<?php

require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladač pro vypsání stránky s objednávkou
 */
class objednavkaController implements IController {

    /** @var MyDatabase $db  Správa databáze */
    private $db;
    /**
     * @var userManage $user Správa uživatele
     */
    private $user;

    /**
     * Inicializace připojení k databázi a správě uživatele
     */
    public function __construct() {
        // inicializace prace s DB
        require_once (DIRECTORY_MODELS ."/MyDatabase.class.php");
        $this->db = new MyDatabase();
        require_once (DIRECTORY_MODELS ."/userManage.php");
        $this->user = new userManage();
    }

    /**
     * Vrátí stránku s možností objednávky.
     * @param string $pageTitle     Název stránky.
     * @return string               Výpis.
     */
    public function show(string $pageTitle):string {
        global $tplData;
        $tplData = [];

        $tplData['title'] = $pageTitle;

        $tplData['reky'] = $this->db->getAllReky();

        $tplData['lode'] = $this->db->getAllLode();

        $tplData['prislusenstvi'] = $this->db->getAllPrislusenstvi();

        if(isset($_POST['odhlasit']) and $_POST['odhlasit'] == "odhlasit"){
            $this->user->userLogout();
        }

        $tplData['userLogged'] = $this->user->isUserLogged();

        //Pokud je uživatel přihlášený, zjistím jeho údaje pro vyplnění do objednávky
        if($tplData['userLogged']){
            $user = $this->user->getLoggedUserData();
            $tplData['pravo'] = $user['PRAVA_id_prava'];
            $tplData['username'] = $user['username'];
            $tplData['email'] = $user['email'];
            $tplData['password'] = $user['password'];
        } else {
            $tplData['pravo'] = null;
        }

        $tplData['povedloSe'] = false;
        $tplData['uspech'] = "Je mi líto, ale rezervace se nezdařila";

        //Získání hodnot z Ajaxu
	    $poleHodnotZAjaxu=[];
	    foreach ($tplData['lode'] as $lod){
		    $lod = str_replace(' ', 'XXXX', $lod);
		    array_push($poleHodnotZAjaxu,$lod);
	    }
	    foreach ($tplData['prislusenstvi'] as $prislusen){
	    	$prislusen = str_replace(' ', 'XXXX', $prislusen);
	    	array_push($poleHodnotZAjaxu,$prislusen);
	    }
	    for ($i = 0; $i < count($poleHodnotZAjaxu);$i++){
		    $poleHodnotZAjaxu[$i] = $poleHodnotZAjaxu[$i][1];
	    }

	    //Kontrola datumu objednávky
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
            $reka = $this->db->getExactReka($reka)[0];
            $IDreka = $reka['id_reky'];

            $datVyp = $_POST['dat-vyp'];
            $datVra = $_POST['dat-vra'];
            $poleRealHodnot = [];
			//Převedení poleHodnot do nového poleReal, tak aby se podle klíče dalo vyhledávat v databázi
	        foreach ($poleHodnotZAjaxu as $hodnota){
	        	if (isset($_POST[$hodnota])){
	        		$valueInArray = $_POST[$hodnota];
	        		$hodnota = str_replace('XXXX',' ',$hodnota);
			        $poleRealHodnot[$hodnota] = $valueInArray;
		        }
            }
			//Čas pro ID objednávky
	        $cas = intval(time()/10);

            $isRegistred = $this->db->getAUser($email);
            if (!count($isRegistred)){
               $this->db->registrujUzivatele($email,$firstName,$password);
            }

            $user = $this->db->vratUzivatele($email,$password);

            //Při splnění všech podmínek, přistupujeme k rezervaci, která už nemůže skončit chybou
            if(count($user) and ($password == $user[0]['password']
                and $firstName == $user[0]['username'])) {
                $userID = $user[0]['id_user'];
                $this->db->vytvorObjednavku($cas,$datVyp,$userID,$IDreka,$datVra);

	            foreach ($poleRealHodnot as $key => $itemForInsert){
		            $isLod = $this->db->getExactLodByName($key);
		            if ($isLod != null){
			            $this->db->pridejLod($isLod[0]['id_lod'],$cas,intval($itemForInsert));
		            } else {
			            $prislusenstvi = $this->db->getExactPrisluByName($key);
			            $this->db->pridejPrislusenstvi($prislusenstvi[0]['id_prislusenstvi'],$cas,intval($itemForInsert));
		            }
	            }

                $tplData['povedloSe'] = true;
                $tplData['uspech'] = "Rezervace proběhla úspěšně. Svoji rezervaci naleznete po přihlášení v záložce profil.";

            } else  {
                $tplData['povedloSe'] = false;
                $tplData['uspech'] = "Je mi líto, ale zadali jste špatné jméno nebo heslo.";
            }



        }

        ob_start();
        require(DIRECTORY_VIEWS ."/objednavka.php");
        $obsah = ob_get_clean();

        return $obsah;
    }

}

?>