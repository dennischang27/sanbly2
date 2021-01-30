<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedInteger('invoice_id');
			$table->date('date_issue');
			$table->date('date_due');
			$table->unsignedBigInteger('customer_id');
			$table->string('customer_name');
			$table->string('address', 191)->nullable();
			$table->string('city', 50)->nullable();
			$table->string('state', 50)->nullable();
			$table->string('zipcode', 20)->nullable();
			$table->string('country', 50)->nullable();
			$table->string('payment_terms',455);
			$table->string('client_notes',455);
			$table->float('subtotal')->default(0.00);
			$table->float('invoice_total')->default(0.00);
			$table->unsignedBigInteger('company_id');
			$table->bigInteger('user_id');
			$table->timestamps();
			$table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
