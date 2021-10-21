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
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('title', 100);
            $table->string('slug', 110)->unique();
            $table->string('thumbnail', 190);
            $table->string('desc')->nullable()->comment('This column type is varchar because this is a small description, now it is unusable');
            $table->unsignedSmallInteger('price');
            $table->unsignedTinyInteger('currency_id');
            $table->unsignedSmallInteger('position');
            $table->softDeletes();
            $table->foreign('currency_id')->references('id')->on('currencies');
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
