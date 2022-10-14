<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {

            $table->increments('id');

            $table->string('code')->nullable();            

            $table->timestamps();

            $table->softDeletes();

            $table->string('country');

            $table->string('address_1');

            $table->string('address_2')->nullable();

            $table->string('city');

            $table->string('state');

            $table->string('zone');

            $table->integer('zip_code');

            $table->decimal('lat', 17, 15);

            $table->decimal('lng', 17, 15);

            $table->string('type');


            $table->integer('added_by')->unsigned();

            $table->foreign('added_by')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
