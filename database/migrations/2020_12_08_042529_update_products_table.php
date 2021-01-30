<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::dropIfExists('products');
		 
		 Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_code');
			$table->string('name');
			$table->string('category');
			$table->string('serial_number');
			$table->float('price')->default(0.00);
			$table->boolean('price_includes_tax')->default(0);
			$table->string('tax');
			$table->float('cost')->default(0.00);
			$table->integer('stock_level')->default(0);
			$table->string('notes',455);
            $table->unsignedBigInteger('company_id');
            $table->bigInteger('user_id');
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
