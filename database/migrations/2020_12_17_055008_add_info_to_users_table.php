<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('dob', 30)->nullable()->after('remember_token');
			$table->string('country', 100)->nullable()->after('dob');
			$table->string('currency', 30)->nullable()->after('country');
			$table->text('languages')->nullable()->after('currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
			$table->dropColumn(['dob', 'country', 'currency', 'languages']);
        });
    }
}
