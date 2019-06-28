<?php

namespace App\Console\Commands;

use App\Models\University;
use Illuminate\Console\Command;

class UpdateProvinceId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:province_id
    {--option=all : Chon all hoac id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $option = $this->option('option');
        $this->info('Running.....');
        if(is_numeric($option)){
            $university = University::where('id', $option)->first();
            if(!empty($university->location_id)){
                $university->province_id = $university->location->parent_id;
                $university->save();
            }

        }elseif($option == 'all'){
            University::chunk(100, function($universities){
                foreach($universities as $university){
                    if(!empty($university->location_id)) {
                        $university->province_id = $university->location->parent_id;
                        $university->save();
                    }
                }
            });
        }else{
            $this->warn('Tùy chọn không hợp lệ');
        }
        $this->info('Done !!!');
    }
}
