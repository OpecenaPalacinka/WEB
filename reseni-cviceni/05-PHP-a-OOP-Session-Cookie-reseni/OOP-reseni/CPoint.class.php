<?php
// pripojim pozadovanou tridu
require_once "AGeometricShape.abstract.php";

/**
 * Class CPoint
 * Trida pro bod, ktery je geometrickym tvarem, ale nijak ho nerozsiruje.
 */
class CPoint extends AGeometricShape {

    /**
     * Vykresleni bodu.
     */
    public function draw()
    {
        // primo vypisu nazev a souradnice
        echo "[".$this->getMyId()
            ." | ".get_class($this)
            ." | name: ".$this->getName()
            .", x: ".$this->getX()
            .", y: ".$this->getY()
            ."]";
    }
}

?>