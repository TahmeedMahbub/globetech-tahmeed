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


            $table->string('title');


            $table->integer('category_id')->unsigned();

            $table->foreign('category_id')->references('id')->on('categories');


            $table->integer('sub_category_id')->unsigned();

            $table->foreign('sub_category_id')->references('id')->on('sub_categories');

            
            $table->boolean('negotiable');

            $table->decimal('price', 10, 2);

            $table->string('condition', 20);

            $table->text('description')->nullable();
            
            $table->integer('min_quantity')->unsigned();

            $table->date('validity');

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
        Schema::dropIfExists('products');
    }
}
