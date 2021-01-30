<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('product_categories', function(Blueprint $table){
            $table->dropForeign(['company_id']);
        });
        Schema::dropIfExists('product_categories');
        Schema::enableForeignKeyConstraints();
		
		Schema::create('product_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
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
        Schema::disableForeignKeyConstraints();
        Schema::table('product_categories', function(Blueprint $table){
            $table->dropForeign(['company_id']);
        });
        Schema::dropIfExists('product_categories');
        Schema::enableForeignKeyConstraints();
    }
}
