<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            
            $table->increments('id');


            $table->integer('item_id')->unsigned();

            $table->foreign('item_id')->references('id')->on('items');


            $table->integer('file_details_id')->unsigned();

            $table->foreign('file_details_id')->references('id')->on('file_details');

            
            $table->boolean('is_primary');

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
        Schema::dropIfExists('files');
    }
}
