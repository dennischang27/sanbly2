<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('api_token')->unique();
            $table->boolean('active')->default(1);
            $table->string('verification_code')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('plan_id')->nullable();
            $table->timestamp('plan_expiration_date')->nullable();
            $table->json('plan_settings')->nullable();
            
            
        });
        
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name');
            $table->string('subdomain')->unique();
            $table->string('logo')->default("");
            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('address');
            $table->string('phone');
        });
        
         Schema::create('product_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('company_id');
            $table->bigInteger('user_id');
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->integer('order_index')->default(0);
            $table->integer('active')->default(1);
        });
        
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description',455);
            $table->string('image');
            $table->float('price');
            $table->bigInteger('user_id');
            $table->unsignedBigInteger('product_category_id');
            $table->timestamps();
            $table->foreign('product_category_id')->references('id')->on('product_categories');
        });
        
        Schema::create('taxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tax_name');
            $table->decimal('tax_amount', 5, 2);
            $table->bigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->timestamps();
        });
        
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payment_method_name');
            $table->string('payment_method_description')->nullable();
            $table->bigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
        
        Schema::create('plan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('price');
            $table->integer('price_yearly');
            
            $table->integer('limit_staff')->default(0)->comment('0 is unlimited');

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
        $table->dropColumn('api_token');
        $table->dropColumn('phone');
        
        Schema::dropIfExists('companies');
        
        Schema::dropIfExists('product_categories');
        
        Schema::dropIfExists('products');
        
        Schema::dropIfExists('taxes');
        
        Schema::dropIfExists('plan');
        
    }
}
