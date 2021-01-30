<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Roles
         $admin = Role::create(['name' => 'admin']);
         $owner = Role::create(['name' => 'owner']);
         $staff = Role::create(['name' => 'staff']);
        
        //Permissions
         $admin->givePermissionTo(Permission::create(['name' => 'manage owners']));
         $admin->givePermissionTo(Permission::create(['name' => 'edit settings']));
        
         $owner->givePermissionTo(Permission::create(['name' => 'manage staff']));
         $owner->givePermissionTo(Permission::create(['name' => 'edit owner']));
        
         $staff->givePermissionTo(Permission::create(['name' => 'edit staff']));
        
         //ADD ADMIN USER ROLE
         DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' =>  'App\User',
            'model_id'=> 1
         ]);
    }
}
