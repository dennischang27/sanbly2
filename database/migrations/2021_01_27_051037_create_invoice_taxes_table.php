<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_taxes', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('tax_name');
			$table->float('tax_percentage');
			$table->float('tax_amount');
			$table->unsignedBigInteger('invoice_id');
			$table->unsignedBigInteger('company_id');
			$table->bigInteger('user_id');
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
        Schema::dropIfExists('invoice_taxes');
    }
}
