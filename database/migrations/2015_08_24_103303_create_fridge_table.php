<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFridgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fridges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item');
            $table->integer('amount');
            $table->enum('unit', Config::get('enum.unit'));
            $table->date('use_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fridges');
    }
}
