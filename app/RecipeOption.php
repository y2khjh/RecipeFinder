<?php

namespace RecipeFinder;

class RecipeOption implements \IteratorAggregate
{
    private $recipes = array();

    /**
     * Re-sort the recipe and then return it as an Iterator
     *
     * @return \ArrayIterator
     */
    public function getIterator() {
        usort($this->recipes, array('static', 'cmpUseBy'));
        return new \ArrayIterator($this->recipes);
    }

    /**
     * Add a new recipe to the option
     *
     * @param Recipe $recipe
     */
    public function add(Recipe $recipe) {
        $today = new \DateTime();
        $today->setTime(0, 0, 0);
        if ($recipe->useBy >= $today) {
            $this->recipes[] = $recipe;
        }
    }

    private static function cmpUseBy(Recipe $thisRecipe, Recipe $nextRecipe) {
        if ($thisRecipe->useBy == $nextRecipe->useBy) {
            return 0;
        }
        return ($thisRecipe->useBy < $nextRecipe->useBy) ? -1 : 1;
    }
}