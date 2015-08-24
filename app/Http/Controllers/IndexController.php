<?php
namespace RecipeFinder\Http\Controllers;

use Input;
use Validator;
use Redirect;
use Session;

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
        $view->defaultJson = file_get_contents(storage_path() . DIRECTORY_SEPARATOR . 'default_json.js');
        return $view;
    }

    public function upload() {

        $file = array('csvfile' => Input::file('csvfile'));

        $rules = array('csvfile' => 'required',);

        $validator = Validator::make($file, $rules);

        if ($validator->fails()) {
            return Redirect::to('/');
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
                return Redirect::to('/');
            }
        }
    }

    public function findRecipe() {
        $input = json_decode(Input::get('json', '[]'), true);
        var_dump($input);
    }
}