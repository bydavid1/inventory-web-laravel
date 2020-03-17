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
            $table->text('description');
            $table->integer('provider_id');
            $table->integer('category_id');
            $table->float('price1');
            $table->float('price2');
            $table->float('price3');
            $table->float('price4');
            $table->float('utility1');
            $table->float('utility2');
            $table->float('utility3');
            $table->float('utility4');
            $table->float('purchase');
            $table->integer('quantity');
            $table->integer('type');
            $table->integer('is_available');
            $table->integer('is_deleted');
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
