<?php

/**
 *  Objekt pro praci s Cookies.
 *  @author Michal Nykl
 */
class MyCookies {

    /** @var int $defExpire  Defaultni doba expirace cookie [s]  */
    private $defExpire;
    
    /**
     *  Pri vytvoreni objektu nastavim defaultni cas expirace cookies.
     */
    public function __construct(){
        // defaultne 10 dni [s]
        $this->defExpire = 10*60*60*24;
    }
    
    /**
     *  Funkce pro ulozeni hodnoty do cookies.
     *  @param string $key      Jmeno atributu.
     *  @param mixed $value     Hodnota.
     *  @param int $expire      Doba platnosti. Muze byt NULL.
     */
    public function addCookie(string $key, $value, $expire=null){
        // pokud neni uvedena doba platnosti, tak se pouzije defaultni
        if(!isset($expire)){
            $expire = $this->defExpire;
        }
        // nastavim cookie
        setcookie($key,$value,time()+$expire);        
    }
    
    /**
     *  Vrati hodnotu daneho cookies nebo null, pokud cookies neni nastavena.
     *  @param string $key  Jmeno atributu.
     *  @return mixed       Hodnota cookie nebo null, pokud neni obsazena.
     */
    public function readCookie(string $key){
        // existuje dany atribut v cookie
        if($this->isCookieSet($key)){
            return $_COOKIE[$key];
        } else {
            return null;
        }
    }
    
    /**
     *  Je cookie nastavena?
     *  @param string $key   Jmeno atributu.
     *  @return boolean
     */
    public function isCookieSet(string $key){
        return isset($_COOKIE[$key]);
    }
    
    /**
     *  Odstrani danou cookie.
     *  @param string $key Jmeno atributu.
     */
    public function removeCookie(string $key){
        $this->addCookie($key,null,0);
    }
    
}
?>
