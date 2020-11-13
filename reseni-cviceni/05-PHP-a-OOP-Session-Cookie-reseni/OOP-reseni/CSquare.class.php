<?php
// pripojim pozadovanou tridu
require_once "ATetragon.abstract.php";

/**
 * Class CSquare
 * Trida pro ctverec, ktery je geometrickym tvarem a soucasne ma obsah a delku strany.
 */
class CSquare extends ATetragon {

    /** @var float $side  Delka strany. */
    public $side;

    /**
     * Konstruktor pro ctverec.
     *
     * @param string $name  Nazev.
     * @param float $x      Souradnice X.
     * @param float $y      Souradnice Y.
     * @param string $color Barva tvaru.
     * @param float $side   Strana ctverce.
     */
    public function __construct(string $name, float $x, float $y, string $color, float $side)
    {
        parent::__construct($name, $x, $y, $color);
        $this->side = $side;
    }

    /**
     * Vykresleni ctverce.
     */
    public function draw()
    {
        // primo vypisu nazev a souradnice
        echo "[".$this->getMyId()
            ." | ".get_class($this)
            ." | name: ".$this->getName()
            .", x: ".$this->getX()
            .", y: ".$this->getY()
            .", color: ".$this->color
            .", side: ".$this->side
            ."]";
    }

    /**
     * Vypocitam a vypisu obsah.
     *
     * @return float  Vypocitany obsah.
     */
    public function getArea():float
    {
        return ($this->side * $this->side);
    }

}

?>