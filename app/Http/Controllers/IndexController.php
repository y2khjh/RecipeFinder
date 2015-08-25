<?php
namespace RecipeFinder\Http\Controllers;

use Input;
use RecipeFinder\Ingredient;
use RecipeFinder\Recipe;
use RecipeFinder\RecipeOption;
use Validator;
use Redirect;
use Session;
use Request;

use RecipeFinder\Fridge;

class IndexController extends Controller
{
    /**
     * Display the home page
     *
     * @return Response
     */
    public function index() {
        $view = view('index');
        $view->foodsInFridge = Fridge::all();
        $view->json = Request::old('json_data');
        $view->defaultJson = file_get_contents(storage_path() . DIRECTORY_SEPARATOR . 'default_json.js');
        return $view;
    }

    public function upload() {

        $file = array('csvfile' => Input::file('csvfile'));

        $rules = array('csvfile' => 'required',);

        $validator = Validator::make($file, $rules);

        if ($validator->fails()) {
            return Redirect::to('/')->with('error', 'Invalid CSV File');
        } else {
            if ($file['csvfile']->isValid()) {
                Fridge::truncate();
                $csv = fopen($file['csvfile']->getRealPath(), 'r');
                while ($row = fgetcsv($csv)) {
                    Fridge::create(array_combine(
                        array('item', 'amount', 'unit', 'use_by'),
                        $row
                    ));
                }
                fclose($csv);
                return Redirect::to('/');
            }  else {
                return Redirect::to('/')->with('error', 'Invalid CSV File');
            }
        }
    }

    public function findRecipe() {
        $recipeOption = new RecipeOption();
        $json = Input::get('json_data');
        $input = json_decode($json, true);
        if ($input) {
            foreach ($input as $item) {
                $reciptIngredients = array();
                $allFound = true;
                foreach ($item['ingredients'] as $ingredient) {
                    $fridgeStock = $this->fridgeCheck($ingredient['item'], $ingredient['unit']);
                    if ($fridgeStock instanceof Fridge && $fridgeStock->amount >= intval($ingredient['amount'])) {
                        $reciptIngredients[] = new Ingredient(
                            $ingredient['item'],
                            $ingredient['amount'],
                            $ingredient['unit'],
                            date_create_from_format('d/m/Y', $fridgeStock->use_by)
                        );
                    } else {
                        $allFound = false;
                    }
                }

                if ($allFound) {
                    $recipe = new Recipe($item['name'], $reciptIngredients);
                    $recipeOption->add($recipe);
                }
            }

            if ($recipeOption->getIterator()->count()) {
                return Redirect::to('/')->withInput()->with('recipe_name', $recipeOption->getIterator()->offsetGet(0)->name);
            } else {
                return Redirect::to('/')->withInput()->with('error', 'Order Takeout');
            }
        } else {
            return Redirect::to('/')->withInput()->with('error', 'Invalid Recipe JSON');
        }
    }

    private function fridgeCheck($item, $unit) {
        return Fridge::getGoodItemCountAndUseBy($item, $unit);
    }
}