<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->float('amount');
			$table->date('payment_date');
			$table->unsignedBigInteger('payment_mode_id');
			$table->string('payment_mode_name');
			$table->string('transaction_id', 100)->nullable();
			$table->string('note',455)->nullable();
			$table->boolean('do_not_send_invoice')->default(0);
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
        Schema::dropIfExists('invoice_payments');
    }
}
