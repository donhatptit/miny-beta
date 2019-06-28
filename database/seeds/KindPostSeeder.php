<?php

use Illuminate\Database\Seeder;

class KindPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr_kind = [
            [
                'name' => 'Phân tích',
                'color' => '#1db019'
            ],
            [
                'name' => 'Cảm nhận',
                'color' => '#fc5d3a',
            ],
            [
                'name' => 'Soạn bài',
                'color' => '#e31f13',
            ],
            [
                'name' => 'Tóm tắt',
                'color' => '#3819fa',
            ],
            [
                'name' => 'Dàn ý',
                'color' => '#ed0d6b',
            ],
            [
                'name' => 'Miêu tả',
                'color' => '#ce0eed',
            ],
            [
                'name' => 'Kể chuyện',
                'color' => '#8534ed',
            ],
            [
                'name' => 'Văn mẫu',
                'color' => '#ffc32a',
            ],
        ];
        foreach($arr_kind as $kind){
            \App\Models\Kind::create($kind);
        }
    }
}
