<?php
// pripojim pozadovanou tridu
require_once "AGeometricShape.abstract.php";
// pripojim interface pro vykreslitelnost
require_once "IHasArea.interface.php";

/**
 * Class CCircle
 * Trida pro kruh, ktery je geometrickym tvarem (rozsiruje ho o polomer) a ma obsah.
 */
class CCircle extends AGeometricShape implements IHasArea {

    /** @var float $radius  Polomer */
    private $radius;

    /**
     * Pretezuji konstruktor rodice.
     *
     * @param string $name  Nazev.
     * @param float $x      Souradnice X.
     * @param float $y      Souradnice Y.
     * @param float $radius Polomer.
     */
    public function __construct(string $name, float $x, float $y, float $radius)
    {
        // zaklad predam predkovi
        parent::__construct($name, $x, $y);
        // doplnim vlastni
        $this->radius = $radius;
    }

    /**
     * Vykresleni cary.
     */
    public function draw()
    {
        // primo vypisu nazev a souradnice
        echo "[".$this->getMyId()
            ." | ".get_class($this)
            ." | name: ".$this->getName()
            .", x: ".$this->getX()
            .", y: ".$this->getY()
            .", radius: ".$this->radius
            ."]";
    }

    /**
     * Vypocet obsahu.
     * @return float
     */
    public function getArea(): float
    {
        // pi * druha mocnina polomeru
        return pi()*pow($this->radius/2, 2);
    }
}

?>