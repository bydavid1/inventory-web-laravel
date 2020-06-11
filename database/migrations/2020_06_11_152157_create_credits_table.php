<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date');
            $table->unsignedBigInteger('costumer_id');
            $table->foreign('costumer_id')->references('id')->on('costumers')->onDelete('cascade');
            $table->integer('payment_status');
            $table->string('delivery_status');
            $table->float('additional_discounts')->nullable();
            $table->float('additional_payments')->nullable();
            $table->text('comments')->nullable();
            $table->float('quantity');
            $table->float('subtotal');
            $table->float('discounts')->nullable();
            $table->float('tax');
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
        Schema::dropIfExists('credits');
    }
}
