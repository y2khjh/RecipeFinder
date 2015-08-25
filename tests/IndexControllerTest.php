<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use \RecipeFinder\Fridge;

class IndexControllerTest extends TestCase
{
    use DatabaseTransactions;

//    public function setUp() {
//        parent::setUp();
//        $this->setupTestDatabase();
//    }

    public function setupTestDatabase() {
        Fridge::truncate();

        $nextYear = new \DateTime();
        $nextYear->modify('+1 year');
        $inNineMonth = new \DateTime();
        $inNineMonth->modify('+9 month');
        $inSixMonth = new \DateTime();
        $inSixMonth->modify('+6 month');
        $inThreeMonth = new \DateTime();
        $inThreeMonth->modify('+3 month');
        $yesterday = new \DateTime();
        $yesterday->modify('-1 day');
        Fridge::create(array('item' => 'Good Test Item 1 Year', 'amount' => 1, 'unit' => 'of', 'use_by' => $nextYear->format('d/m/Y')));
        Fridge::create(array('item' => 'Good Test Item 9 Month', 'amount' => 5, 'unit' => 'ml', 'use_by' => $inNineMonth->format('d/m/Y')));
        Fridge::create(array('item' => 'Good Test Item 6 Month', 'amount' => 10, 'unit' => 'grams', 'use_by' => $inSixMonth->format('d/m/Y')));
        Fridge::create(array('item' => 'Good Test Item 3 Month', 'amount' => 10, 'unit' => 'slices', 'use_by' => $inThreeMonth->format('d/m/Y')));
        Fridge::create(array('item' => 'Bad Test Item Expired', 'amount' => 2, 'unit' => 'slices', 'use_by' => $yesterday->format('d/m/Y')));
    }


    public function testIndex()
    {
        $this->visit('/')
             ->see('Recipe Finder');
    }

    public function testCSVUpload() {
        $testCsv = storage_path() . DIRECTORY_SEPARATOR . 'test_csv.csv';
        $this->visit('/')
            ->attach($testCsv, 'csvfile')
            ->press('upload_csvfile')
            ->see('test food');
    }

    public function testFindRecipe() {
        $this->setupTestDatabase();

        $data = array(
            array(
                "name" => "Recipe 1",
                "ingredients" => array(
                    array(
                        "item" => "Good Test Item 1 Year",
                        "amount" => "10",
                        "unit" => "of",
                    )
                )
            ),
            array(
                "name" => "Recipe 2",
                "ingredients" => array(
                    array(
                        "item" => "Good Test Item 6 Month",
                        "amount" => "10",
                        "unit" => "grams",
                    )
                )
            ),
            array(
                "name" => "Recipe 3 (I am the best!)",
                "ingredients" => array(
                    array(
                        "item" => "Good Test Item 3 Month",
                        "amount" => "10",
                        "unit" => "slices",
                    )
                )
            ),
        );

        $this->visit('/')
            ->type(json_encode($data), 'json_data')
            ->press('submit_recipes')
            ->seeInField('#found_recipe', 'Recipe 3 (I am the best!)')
            ->dontSee('Order Takeout');
    }

    public function testRecipeNotFound() {
        $this->setupTestDatabase();

        $testData = array(
            array(
                "name" => "should not see me because ingredients not found",
                "ingredients" => array(
                    array(
                        "item" => "rare bread",
                        "amount" => "2",
                        "unit" => "slices"
                    )
                )
            )
        );
        $this->visit('/')
            ->type(json_encode($testData), 'json_data')
            ->press('submit_recipes')
            ->see('Order Takeout');

        $testData = array(
            array(
                "name" => "should not see me because not enough amount of ingredients",
                "ingredients" => array(
                    array(
                        "item" => "Good Test Item 1 Year",
                        "amount" => "2000",
                        "unit" => "slices"
                    )
                )
            )
        );
        $this->visit('/')
            ->type(json_encode($testData), 'json_data')
            ->press('submit_recipes')
            ->see('Order Takeout');

        $testData = array(
            array(
                "name" => "should not see me because required ingredients has expired",
                "ingredients" => array(
                    array(
                        "item" => "Bad Test Item Expired",
                        "amount" => "2",
                        "unit" => "slices"
                    )
                )
            )
        );
        $this->visit('/')
            ->type(json_encode($testData), 'json_data')
            ->press('submit_recipes')
            ->see('Order Takeout');
    }
}
