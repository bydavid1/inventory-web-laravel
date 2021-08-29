<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKardexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kardex', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('kardex_types')->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->char('invoice_ref', 15)->nullable();
            $table->integer('final_stock');
            $table->float('final_value');
            $table->float('final_unit_value');
            $table->integer('quantity');
            $table->float('unit_price');
            $table->float('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kardex');
    }
}
