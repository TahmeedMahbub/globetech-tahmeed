<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            
            $table->increments('id');


            $table->integer('item_id')->unsigned();

            $table->foreign('item_id')->references('id')->on('items');


            $table->string('title')->nullable();


            $table->integer('category_id')->unsigned()->nullable();

            $table->foreign('category_id')->references('id')->on('categories');


            $table->integer('sub_category_id')->unsigned()->nullable();

            $table->foreign('sub_category_id')->references('id')->on('sub_categories');

            
            $table->boolean('negotiable')->nullable();

            $table->decimal('price', 10, 2)->nullable();

            $table->string('condition', 20)->nullable();

            $table->text('description')->nullable();
            
            $table->integer('min_quantity')->unsigned()->nullable();

            $table->date('validity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
