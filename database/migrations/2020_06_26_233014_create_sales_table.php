<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('delivery_status'); // 1 => completo, 2 => parcial, 0 => pendiente
            $table->float('additional_discounts')->nullable()->default('0.00');;
            $table->float('additional_payments')->nullable()->default('0.00');;
            $table->integer('total_quantity');
            $table->float('subtotal');
            $table->float('total_discounts')->nullable()->default('0.00');
            $table->float('total_tax');
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
        Schema::dropIfExists('sales');
    }
}
