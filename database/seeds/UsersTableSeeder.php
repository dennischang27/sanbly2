<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => env('ADMIN_NAME', "Admin"),
            'last_name' => "Admin",
            'email' =>  env('ADMIN_EMAIL', "admin@example.com"),
            'password' => Hash::make( env('ADMIN_PASSWORD', "secret")),
            'api_token' => Str::random(80),
            'email_verified_at' => now(),
            'phone' =>  "",
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
