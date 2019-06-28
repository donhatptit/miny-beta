<?php

use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(config('laravel-permission.table_names.user_has_roles'))->delete();
        $admin = \App\User::first();
        $admin->assignRole('Administrator');
    }
}
