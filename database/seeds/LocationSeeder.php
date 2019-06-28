<?php

use Illuminate\Database\Seeder;
use App\Core\SimpleXLSX;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        if ( $xlsx = SimpleXLSX::parse('storage/files/dvhcvn.xlsx') ) {
            $data =  $xlsx->rows();
        } else {
            return  SimpleXLSX::parseError();
        }
        $provinces = [];
        $districts = [];

        unset($data[0]);

        foreach($data as $d){
            $provinces[array_get($d,0)] = array_get($d, 1);
            $districts[array_get($d,2)] = [
              'code' => array_get($d, 3),
               'province' => array_get($d, 1),
            ];
        }
        $this->importProvince($provinces);
        $this->importDistrict($districts);

    }
    public function importProvince($provinces){
        foreach($provinces as $key => $province){
            Location::create([
                'code' => $province,
                'name' => $key,
                'depth' => 0
            ]);
        }
    }
    public function importDistrict($districts){
        foreach($districts as $key => $district){
            $province = Location::where('code', $district['province'])->first();
            $arr_data['code'] = $district['code'];
            $arr_data['name'] = $key;
            $arr_data['parent_id'] = $province->id;
            $arr_data['depth'] = 1;
            Location::create($arr_data);
        }
    }
}
