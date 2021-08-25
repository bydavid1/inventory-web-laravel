<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKardexItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kardex_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kardex_report_id')->constrained('kardex_reports')->onDelete('cascade');
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->float('quantity');
            $table->decimal('unit_value');
            $table->decimal('value');
            $table->float('final_stock');
            $table->decimal('final_value');
            $table->decimal('final_unit_value');
            $table->boolean('is_initial')->nullable();
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
        Schema::dropIfExists('kardex_items');
    }
}
