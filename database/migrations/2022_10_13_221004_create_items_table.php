<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
           
            $table->increments('id');

            $table->string('item_type');


            $table->integer('location_id')->unsigned();

            $table->foreign('location_id')->references('id')->on('locations');

            
            $table->boolean('tradable');


            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');


            $table->string('status');
            
            $table->boolean('is_active');

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
        Schema::dropIfExists('items');
    }
}
