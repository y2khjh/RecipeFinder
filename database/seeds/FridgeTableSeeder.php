<?php

use \RecipeFinder\Fridge;
use Illuminate\Database\Seeder;

class FridgeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fridge::truncate();
        Fridge::create(array('item' => 'bread', 'amount' => 10, 'unit' => 'slices', 'use_by' => '25/12/2015'));
        Fridge::create(array('item' => 'cheese', 'amount' => 10, 'unit' => 'slices', 'use_by' => '25/12/2015'));
        Fridge::create(array('item' => 'butter', 'amount' => 250, 'unit' => 'grams', 'use_by' => '25/12/2015'));
        Fridge::create(array('item' => 'peanut butter', 'amount' => 250, 'unit' => 'grams', 'use_by' => '2/12/2015'));
        Fridge::create(array('item' => 'mixed salad', 'amount' => 500, 'unit' => 'grams', 'use_by' => '26/12/2014'));
        Fridge::create(array('item' => 'mixed salad', 'amount' => 500, 'unit' => 'grams', 'use_by' => '26/11/2015'));
    }
}
