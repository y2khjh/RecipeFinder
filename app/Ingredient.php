<?php

namespace RecipeFinder;

class Ingredient
{
    private $item;
    private $amount;
    private $unit;
    private $useBy;

    /**
     * Object Constructor
     *
     * @param $item
     * @param $amount
     * @param $unit
     * @param \DateTime $useBy
     */
    public function __construct($item, $amount, $unit, \DateTime $useBy) {
        $this->setItem($item);
        $this->setAmount($amount);
        $this->setUnit($unit);
        $this->setUseBy($useBy);
    }

    private function setItem($item) {
        $this->item = (string)$item;
    }

    private function setAmount($amount) {
        $this->amount = (int)$amount;
    }

    private function setUnit($unit) {
        $this->unit = (string)$unit;
    }

    private function setUseBy(\DateTime $useBy) {
        $this->useBy = $useBy->setTime(0, 0, 0);
    }

    /**
     * @return string
     */
    public function __toString() {
        return (string)$this->item;
    }

    /**
     * Property getter of class
     *
     * @param $name
     * @return mixed
     */
    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            throw new \RuntimeException();
        }
    }
}