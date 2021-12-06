<?php

namespace App\Providers;

use App\Models\Post;
use App\Observers\PostObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // make your own query file
        // if(env('APP_DEBUG')) {
        //     \DB::listen(function($query){
        //         \File::append(
        //             storage_path('logs/query.log'),
        //             $query->sql . '[' . implode(', ', $query->bindings) . ']' . PHP_EOL
        //         );
        //     });
        // }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultstringLength(191);
        Post::observe(PostObserver::class);

        \View::composer("*", function ($view) {
            $view->with("activeStatus", ActiveStatus::class);
            $view->with("conentTypes",  ConentTypes::class);
            $view->with("settingTypes", SettingTypes::class);
        });
    }
}
