<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('credit_id');
            $table->foreign('credit_id')->references('id')->on('credits')->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->float('discount')->nullable('0.00');
            $table->float('unit_price');
            $table->float('unit_tax')->nullable('0.00');
            $table->float('total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credits_items');
    }
}
