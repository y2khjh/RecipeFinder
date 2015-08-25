<?php

class RecipeTest extends TestCase
{
    public function testClass() {

        $expectName = 'Test Recipe';

        $expectIngredients = array(
            new \RecipeFinder\Ingredient(
                'Apple', 100, 'grams', new \DateTime('2015-08-25')
            ),
            new \RecipeFinder\Ingredient(
                'Butter', 200, 'grams', new \DateTime('2015-08-19')
            ),
        );

        $recipe = new \RecipeFinder\Recipe(
            $expectName, $expectIngredients
        );

        $this->assertEquals($expectName, (string)$recipe);
        $this->assertEquals($expectName, (string)$recipe);
        $this->assertEquals($expectName, $recipe->name);
        $this->assertEquals(new \DateTime('2015-08-19'), $recipe->useBy);

    }
}