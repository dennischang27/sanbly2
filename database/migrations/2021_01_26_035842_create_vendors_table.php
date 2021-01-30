<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vendor_name');
            $table->string('vendor_contact_name')->nullable();
            $table->string('vendor_phone', 30)->nullable();
            $table->string('vendor_email', 80)->nullable();
            $table->string('vendor_website', 80)->nullable();
            
            $table->string('vbill_name')->nullable();
            $table->string('vbill_phone', 30)->nullable();
            $table->string('vbill_address', 191)->nullable();
			$table->string('vbill_city', 50)->nullable();
			$table->string('vbill_state', 50)->nullable();
			$table->string('vbill_zipcode', 20)->nullable();
			$table->string('vbill_country', 50)->nullable();
            
			$table->boolean('is_active')->default(0);
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
        Schema::dropIfExists('vendors');
    }
}
