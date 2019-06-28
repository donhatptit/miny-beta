<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(config('laravel-permission.table_names.permissions'))->delete();
        DB::table(config('laravel-permission.table_names.role_has_permissions'))->delete();
        $permission_model = config('laravel-permission.models.permission');
        $role_model = config('laravel-permission.models.role');
        $perm_list = config('laravel-permission.default.permission_list');
        foreach ($perm_list as $perm => $roles){
            /** @var $permission */
            $permission = new $permission_model();
            $permission->name = $perm;
            $permission->save();
            foreach ($roles as $role_name){
                $role = $role_model::findByName($role_name);
                $role->givePermissionTo($perm);
            }
        }

    }
}
