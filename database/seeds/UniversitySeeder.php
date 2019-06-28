<?php

use Illuminate\Database\Seeder;
use App\Core\SimpleXLSX;
use App\Models\University;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        if ( $xlsx = SimpleXLSX::parse('storage/files/univer.xlsx') ) {
            $data =  $xlsx->rows();
        } else {
            return  SimpleXLSX::parseError();
        }
        $universities = [];
        foreach($data as $d){
            if($d[0] !== ""){
                $universities[] = $this->replace_title($d[0]);
            }
        }
        unset($universities[0]);

        foreach($universities as $university){
            University::create([
                'vi_name'  => $university,
                'created_by' => 1,
            ]);

        }
    }
    public function replace_title($title){
        $title = preg_replace('/ĐH|Đh|đh/','Đại học', $title);
        $title = preg_replace('/CĐ|cđ|Cđ/','Cao đẳng', $title);
        $title = preg_replace('/HCM|Hcm|hcm/', 'Hồ Chí Minh', $title);
        $title = preg_replace('/HN|hn|Hn/', 'Hà Nội', $title);
        $title = preg_replace('/VN|Vn|vn/', 'Việt Nam', $title);
        $title = preg_replace('/tp/', 'thành phố', $title);
        $title = preg_replace('/HN2/', 'Hà Nội 2', $title);
        $title = preg_replace('/\sph\s/',' phân hiệu ', $title);
        return $title;
    }
}
