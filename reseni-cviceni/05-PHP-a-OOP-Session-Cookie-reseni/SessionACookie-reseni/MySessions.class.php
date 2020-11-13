<?php

/**
 *  Objekt pro praci se Session.
 *  @author Michal Nykl
 */
class MySession {
    
    /**
     *  Pri vytvoreni objektu je zahajena session.
     */
    public function __construct(){
        session_start(); // zahajim
    }
    
    /**
     *  Funkce pro ulozeni hodnoty do session.
     *  @param string $key     Jmeno atributu.
     *  @param mixed $value    Hodnota
     */
    public function addSession(string $key, $value){
        $_SESSION[$key] = $value;
    }

    /**
     *  Je session nastavena?
     *  @param string $key  Jmeno atributu.
     *  @return boolean
     */
    public function isSessionSet(string $key){
        return isset($_SESSION[$key]);
    }

    /**
     *  Vrati hodnotu dane session nebo null, pokud session neni nastavena.
     *  @param string $key Jmeno atributu.
     *  @return mixed
     */
    public function readSession(string $key){
        // existuje dany atribut v session
        if($this->isSessionSet($key)){
            return $_SESSION[$key];
        } else {
            return null;
        }
    }
    
    /**
     *  Odstrani danou session.
     *  @param string $key Jmeno atributu.
     */
    public function removeSession(string $key){
        unset($_SESSION[$key]);
    }
    
}
?>
