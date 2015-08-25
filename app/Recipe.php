<?php

namespace RecipeFinder;

class Recipe
{
    private $name;
    private $ingredients = array();
    private $useBy;

    /**
     * Object Constructor
     *
     * @param $name
     * @param array $ingredients
     */
    public function __construct($name, array $ingredients) {
        $this->setName($name);
        $this->setIngredients($ingredients);
    }

    private function setName($name) {
        $this->name = (string)$name;
    }

    private function setIngredients(array $ingredients) {
        foreach ($ingredients as $ingredient) {
            $this->ingredients[] = new Ingredient(
                $ingredient->item,
                $ingredient->amount,
                $ingredient->unit,
                $ingredient->useBy
            );
            $this->updateUseBy($ingredient->useBy);
        }
    }

    private function updateUseBy(\DateTime $useBy) {
        if ($this->useBy === null) {
            $this->useBy = $useBy;
        } else {
            if ($useBy < $this->useBy) {
                $this->useBy = $useBy;
            }
        }
    }

    /**
     * @return string
     */
    public function __toString() {
        return (string)$this->name;
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