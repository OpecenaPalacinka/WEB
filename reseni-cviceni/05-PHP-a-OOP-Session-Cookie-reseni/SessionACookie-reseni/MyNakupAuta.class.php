<?php 

/**
 *  Objekt pro praci s vyberem automobilu.
 *  @author Michal Nykl
 */
class MyNakupAuta {

    /** @var MyCookies $coo  Objekt pro praci s cookie. */
    private $coo;

    /** @var string $dWheels  Klic pro ulozeni poctu kol do cookie. */
    private $dWheels = "kola";
    /** @var string $dColor  Klic pro ulozeni barvy do cookie. */
    private $dColor = "barva";
    
    /**
     *  Pri vytvoreni objektu zahaji session.
     */
    public function __construct(){
        require_once("myCookies.class.php");
        // inicializuju objekt sessny
        $this->coo = new MyCookies;
    }
    
    /**
     *  Otestuje, zda už existují informace o vybraném automobilu.
     *  @return boolean
     */
    public function isSelectedCar(){
        return $this->coo->isCookieSet($this->dWheels);
    }
    
    /**
     *  Nastavi do cookies pocet kol a barvu automobilu.
     *  @param integer $wheels Pocet kol.
     *  @param string $color Barva.
     */
    public function createCar($wheels, $color){
        $this->coo->addCookie($this->dWheels,$wheels); // kola
        $this->coo->addCookie($this->dColor,$color);
    }
    
    /**
     *  Smaze informace o automobilu.
     */
    public function deleteCar(){
        $this->coo->removeCookie($this->dWheels);
        $this->coo->removeCookie($this->dColor);
    }
    
    /**
     *  Vrati informace o poctu kol.
     *  @return int
     */
    public function getWheels(){
        return intval($this->coo->readCookie($this->dWheels));
    }
    
    /**
     *  Vrati informace o barve.
     *  @return string
     */
    public function getColor(){
        return $this->coo->readCookie($this->dColor);
    }
    
    /**
     *  Vytvoří informace o daném automobilu.
     *  @return string Informace.
     */
    public function getInfo(){
        $wheels = $this->getWheels();
        $color = $this->getColor();
        $str = "";
        if($wheels > 0) {
            for ($i = 0; $i < $wheels; $i++) {
                $str .= "<div style='background-color: $color;width:50px;height:50px;margin:5px;display:inline-block;border-radius:50%;'></div>";
            }
            $str .= "<br><i>Kola: $wheels, barva: $color</i><br>";
        }
        return $str;
    }
    
}

?>
