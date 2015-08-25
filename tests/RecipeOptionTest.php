<?php

class RecipeOptionTest extends TestCase
{
    public function testClass() {
        $ingredients_1 = array(
            new \RecipeFinder\Ingredient(
                'Apple', 100, 'grams', new \DateTime('2025-08-25')
            ),
            new \RecipeFinder\Ingredient(
                'Butter', 200, 'grams', new \DateTime('2025-08-19')
            ),
        );
        $recipe_1 = new \RecipeFinder\Recipe(
            'Test Recipe 1', $ingredients_1
        );

        $ingredients_2 = array(
            new \RecipeFinder\Ingredient(
                'Apple', 100, 'grams', new \DateTime('2024-08-25')
            ),
            new \RecipeFinder\Ingredient(
                'Butter', 200, 'grams', new \DateTime('2024-08-19')
            ),
        );
        $recipe_2 = new \RecipeFinder\Recipe(
            'Test Recipe 2', $ingredients_2
        );

        $recipeOption = new \RecipeFinder\RecipeOption();
        $recipeOption->add($recipe_1);
        $recipeOption->add($recipe_2);

        $this->assertEquals(2, $recipeOption->getIterator()->count());
        $this->assertEquals('Test Recipe 2', $recipeOption->getIterator()->offsetGet(0)->name);

    }
}