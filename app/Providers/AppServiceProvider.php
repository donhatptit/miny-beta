<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Http\Request;
use Schema;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        if(Debugbar::isEnabled()){
            $ip = $request->getClientIp();
            if(!$this->checkIp($ip)){
                Debugbar::disable();
            }
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);

        $request_uri = $this->app->request->getRequestUri();

        //admin
        $admin_prefix = '/'.config('backpack.base.route_prefix', 'admin');

        if( mb_strpos($request_uri, $admin_prefix) === 0 OR $this->app->runningInConsole()){
            $this->app->register(\Backpack\Base\BaseServiceProvider::class);
            $this->app->register(\Backpack\CRUD\CrudServiceProvider::class);

            $loader = AliasLoader::getInstance();
            $loader->alias('CRUD', '\Backpack\CRUD\CrudServiceProvider');

            $this->app->register(\Backpack\BackupManager\BackupManagerServiceProvider::class);
            $this->app->register(\Backpack\LogManager\LogManagerServiceProvider::class);
            $this->app->register(\Backpack\NewsCRUD\NewsCRUDServiceProvider::class);
            $this->app->register(\Backpack\PermissionManager\PermissionManagerServiceProvider::class);
            $this->app->register(\Backpack\Settings\SettingsServiceProvider::class);
        }

        //social
        $facebook_social_prefix = '/app/facebook';
        $google_social_prefix = '/app/google';
        $api_social_prefix = '/api/v1/social';

        if(mb_strpos($request_uri, $facebook_social_prefix) === 0
        || mb_strpos($request_uri, $google_social_prefix) === 0
        || mb_strpos($request_uri, $api_social_prefix) === 0){
            $this->app->register(\Laravel\Socialite\SocialiteServiceProvider::class);

            $loader = AliasLoader::getInstance();
            $loader->alias('Socialite', '\Laravel\Socialite\Facades\Socialite');
        }
    }


    private function checkIp($ip){
        $white_ips = $this->app['config']['debugbar.white_ips'];
        if (!is_array($white_ips)){
            $white_ips = explode(',', $white_ips);
        }
        if(in_array("*", $white_ips) || in_array($ip, $white_ips)){
            return true;
        }
        return false;
    }
}
