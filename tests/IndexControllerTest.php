<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IndexControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->visit('/')
             ->see('Recipe Finder');
    }

    public function testCSVUpload() {
        $testCsv = storage_path() . DIRECTORY_SEPARATOR . 'test_csv.csv';
        $this->visit('/')
            ->attach($testCsv, 'csvfile')
            ->press('submit')
            ->see('test food');
    }

    public function testFindRecipe() {
        $defaultJson = file_get_contents(storage_path() . DIRECTORY_SEPARATOR . 'default_json.js');
        $this->visit('/')
            ->type($defaultJson, 'json')
            ->press('submit')
            ->see('salad sandwich');
    }
}
