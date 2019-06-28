<?php

namespace App\Console;

use App\Colombo\Cache\Manager\MyCache;
use App\Console\Commands\CacheManager;
use App\Console\Commands\CrawlerCommand;
use App\Console\Commands\GenSitemapCommand;
use App\Console\Commands\HandleImagePostUniversityCommand;
use App\Console\Commands\SlugGenerator;
use App\Console\Commands\InitializeElastic;
use App\Console\Commands\SeoEquationGenerator;
use App\Console\Commands\DefineEquationCate;
use App\Console\Commands\HandleMediaCommand;
use App\Console\Commands\SyncStatusCommand;
use App\Console\Commands\UpdateCrawlPostStatus;
use App\Console\Commands\UpdateNumPost;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        GenSitemapCommand::class,
        SyncStatusCommand::class,
        CrawlerCommand::class,
        UpdateNumPost::class,
        UpdateCrawlPostStatus::class,
        SlugGenerator::class,
        InitializeElastic::class,
        SeoEquationGenerator::class,
        DefineEquationCate::class,
        CacheManager::class,
        HandleMediaCommand::class,
        HandleImagePostUniversityCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('sitemap:create')
             ->daily();
         if(config('feature.handle_media.allow')){
             $schedule->command('handle:media')->daily();
         }
        if (config('feature.handle_university.allow')){
            $schedule->command('post:university')->daily();
        }

        foreach (config('cache_key') as $key => $config_cache){
            if(isset($config_cache['schedule'])){
                if($config_cache['schedule']){
                    if(array_key_exists('time_schedule', $config_cache )){
                        $time = $config_cache['time_schedule'];
                    }else{
                        $time = 1;
                    }
                    $schedule->call(function () use ($config_cache, $key) {
                        echo "\nRefreshing " . $key . " \n";
                        \Log::info("Refreshing " . $key);
                        MyCache::refresh(config('cache_key.' . $key));
                    })->cron('*/'. $time .' * * * * *');
                }
            }
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
