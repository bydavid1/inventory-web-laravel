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
            $table->timestamps();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('image');
            $table->text('description')->default('No hay descripción');
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->float('price1');
            $table->float('price2')->default('0.00');
            $table->float('price3')->default('0.00');
            $table->float('price4')->default('0.00');
            $table->float('utility1');
            $table->float('utility2')->default('0.00');
            $table->float('utility3')->default('0.00');
            $table->float('utility4')->default('0.00');
            $table->float('purchase');
            $table->integer('quantity');
            $table->integer('type')->default('1');
            $table->integer('is_available');
            $table->integer('is_deleted')->default('0');;
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
