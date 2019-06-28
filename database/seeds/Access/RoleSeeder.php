<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(env('DB_DRIVER')=='mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table(config('laravel-permission.table_names.roles'))->delete();
        $model_role = config('laravel-permission.models.role');
        if (!empty($model_role)){
            $roles_list = config('laravel-permission.default.roles_list');
            foreach ($roles_list as $role_name){
                /** @var $role \Backpack\PermissionManager\app\Models\Role */
                $role = new $model_role();
                $role->name = $role_name;
                $role->save();
            }
        }else{
            echo 'model_role empty';
        }
        if(env('DB_DRIVER')=='mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
