<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content',2000);
            $table->boolean('available')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('number')->default(1000);
            $table->integer('start')->default(0);
            $table->integer('end')->default(0);
            $table->integer('target')->default(0);
            $table->integer('bookable_id');
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
        Schema::dropIfExists('offers');
    }
}
