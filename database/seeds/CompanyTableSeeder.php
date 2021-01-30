<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => "Demo",
            'last_name' => "Owner", 
            'email' =>  "owner@example.com",
            'password' => Hash::make("secret"),
            'api_token' => Str::random(80),
            'email_verified_at' => now(),
            'phone' =>  "",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        //Assign owner role
        DB::table('model_has_roles')->insert([
            'role_id' => 2,
            'model_type' =>  'App\User',
            'model_id'=> 2
        ]);
    }
}
