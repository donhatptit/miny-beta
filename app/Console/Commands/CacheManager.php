<?php

namespace App\Console\Commands;

use App\Colombo\Cache\Manager\MyCache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class CacheManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mycache:run
        {action : Thuc hien hanh dong voi cache, get, refresh}
        {--key=null : Key cua cache can xu ly}
        ';

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
        $this->info('cache');
        $action = $this->argument('action');
        $key = $this->option('key');
        $config = 'cache_key.' . $key;
        if($action == 'get'){
            $this->info('get');
            if(\Config::has($config)){
                $value = MyCache::get(config($config));
                $this->info($value);
            }else{
                $this->info('Key khong dung');
            }
        }elseif($action == 'refresh'){
            $this->info('refresh');
            if(\Config::has($config)){
                $value = MyCache::refresh(config($config));
                $this->info($value);
            }else{
                $this->info('Key khong dung');
            }
        }elseif ($action == 'reset'){
            foreach (config('cache_key') as $key => $config_cache){
                MyCache::refresh(config('cache_key.' . $key));
            }
        }elseif ($action == 'test'){
            foreach (config('cache_key') as $key => $config_cache){
                if(isset($config_cache['schedule'])){
                    if($config_cache['schedule']){
                        $this->info('have');
                    }
                }else{
                    $this->warn('not have');
                }
            }
        }

    }
}
