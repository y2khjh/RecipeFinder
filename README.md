# RecipeFinder

## Prerequisites

  * PHP >= 5.5.9
  * OpenSSL PHP Extension
  * PDO PHP Extension
  * Mbstring PHP Extension
  * Tokenizer PHP Extension
  * Composer

## Installation

  * git clone git@github.com:y2khjh/RecipeFinder.git ~/RecipeFinder
  * cd ~/RecipeFinder
  * composer install && composer update
  * php artisan key:generate

## Run it (without web server e.g. Apache, Ngnix)

  * cd ~/RecipeFinder
  * php artisan serve
  * in your browser open http://localhost:8000/
  
  You should see the Recipe Finder form has been loaded and there are some testing data already in the Fridge database.
  You can upload a CSV file to replace all the existing testing Fridge data.
