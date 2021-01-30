<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_items', function (Blueprint $table) {
			$table->unsignedBigInteger('tax_id')->nullable()->change();
			$table->string('tax_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('invoice_items', function (Blueprint $table) {
			$table->unsignedBigInteger('tax_id')->nullable(false)->change();
			$table->string('tax_name')->nullable(false)->change();
        });
    }
}
