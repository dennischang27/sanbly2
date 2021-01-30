<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->after('name')->nullable();
			$table->unsignedBigInteger('tax_id')->after('price_includes_tax')->nullable();
			$table->string('item_code')->nullable()->change();
			$table->string('serial_number')->nullable()->change();
			$table->string('category')->nullable()->change();
			$table->string('tax')->nullable()->change();
			$table->string('notes',455)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('category_id');
			$table->dropColumn('tax_id');
        });
    }
}
