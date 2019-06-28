<?php

use Illuminate\Database\Seeder;
use App\Core\SimpleXLSX;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        if ( $xlsx = SimpleXLSX::parse('storage/files/topic.xlsx') ) {
            $data =  $xlsx->rows();
        } else {
            return  SimpleXLSX::parseError();
        }
        $topics = [];
        foreach($data as $d){
            if($d[0] !== ""){
                $topics[] = $d[0];
            }
        }
        unset($topics[0]);
        foreach($topics as $topic){
            \App\Models\Topic::create([
                'name'  => $topic,
            ]);

        }
    }
}
