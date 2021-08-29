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
            $table->foreignId('customer_id')->nullable()->constrained('customers');
            $table->foreignId('payment_id')->constrained('payments')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('pos_id')->constrained('pos');
            $table->string('unregistered_customer')->nullable();
            $table->integer('delivery_status')->nullable()->default('1'); // 1 => completo, 2 => parcial, 0 => pendiente
            $table->float('additional_discounts')->nullable()->default('0.00');;
            $table->float('additional_payments')->nullable()->default('0.00');;
            $table->integer('total_quantity');
            $table->float('subtotal');
            $table->float('total_discounts')->nullable()->default('0.00');
            $table->float('total_tax');
            $table->float('total');
            $table->timestamps();
            $table->softDeletes();
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
