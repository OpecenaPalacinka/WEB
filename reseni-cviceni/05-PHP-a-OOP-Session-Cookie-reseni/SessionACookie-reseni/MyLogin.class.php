<?php 

/**
 *  Objekt pro spravu prihlaseni uzivatelu.
 *  @author Michal Nykl
 */
class MyLogin {

    /** @var MySession $ses  Objekt pro praci se session. */
    private $ses;

    /** @var string $dName  Klic pro ulozeni jmena do session. */
    private $dName = "jmeno";
    /** @var string $dDate  Klic pro ulozeni datumu do session. */
    private $dDate = "datum";
    
    /**
     *  Pri vytvoreni objektu zahaji session.
     */
    public function __construct(){
        require_once("MySessions.class.php");
        // inicializuju objekt sessny
        $this->ses = new MySession;
    }
    
    /**
     *  Otestuje, zda je uzivatel prihlasen.
     *  @return boolean
     */
    public function isUserLoged(){
        return $this->ses->isSessionSet($this->dName);
    }
    
    /**
     *  Nastavi do session jmeno uzivatele a datum prihlaseni.
     *  @param string $userName Jmeno uzivatele.
     */
    public function login($userName){
        $this->ses->addSession($this->dName,$userName); // jmeno
        $this->ses->addSession($this->dDate,date("d. m. Y, G:m:s"));
    }
    
    /**
     *  Odhlasi uzivatele.
     */
    public function logout(){
        $this->ses->removeSession($this->dName);
        $this->ses->removeSession($this->dDate);
    }
    
    /**
     *  Vrati informace o uzivateli.
     *  @return string  Informace o uzivateli.
     */
    public function getUserInfo(){
        $name = $this->ses->readSession($this->dName);
        $date = $this->ses->readSession($this->dDate);
        return "Jméno: $name<br>"
                ."Datum: $date<br>";
    }
    
}
?>
