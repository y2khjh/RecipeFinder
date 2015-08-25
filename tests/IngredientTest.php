<?php

class IngredientTest extends TestCase
{
    public function testClass() {

        $expectItem = 'Test Item';
        $expectAmount = 123;
        $expectUnit = 'grams';
        $expectUseBy = new \DateTime('2015-08-25');

        $ingredient = new \RecipeFinder\Ingredient(
            $expectItem, $expectAmount, $expectUnit, $expectUseBy
        );

        $this->assertEquals($expectItem, (string)$ingredient);
        $this->assertEquals($expectItem, $ingredient->item);
        $this->assertEquals($expectUnit, $ingredient->unit);
        $this->assertEquals($expectUseBy, $ingredient->useBy);

    }
}