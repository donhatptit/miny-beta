<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'name'     => 'Admin1',
            'email'    => 'admin1@gmail.com',
            'password' => bcrypt('admin'),
        ]);

//        DB::table('users')
//            ->where('id', 1)
//            ->update(['password' => bcrypt('hoan123456')]);
    }
}
