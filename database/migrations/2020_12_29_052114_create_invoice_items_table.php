<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('product_id');
			$table->string('product_name');
			$table->integer('quantity');
			$table->unsignedBigInteger('tax_id');
			$table->string('tax_name');
			$table->float('price');
			$table->float('tax_percentage');
			$table->float('tax_amount');
			$table->unsignedBigInteger('invoice_id');
			$table->unsignedBigInteger('company_id');
			$table->bigInteger('user_id');
			$table->timestamps();
			$table->foreign('product_id')->references('id')->on('products');
			$table->foreign('tax_id')->references('id')->on('taxes');
			$table->foreign('invoice_id')->references('id')->on('invoices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
}
