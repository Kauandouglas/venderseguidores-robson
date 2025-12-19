<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\ConfigTemplate;
use App\Models\Service;
use App\Models\SystemSetting;
use App\Models\Template;
use App\Models\User;
use App\Observers\CategoryObserver;
use App\Observers\ConfigTemplateObserver;
use App\Observers\ServiceObserver;
use App\Observers\SystemSettingObserver;
use App\Observers\TemplateObserver;
use App\Observers\UserObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        // Observers
        SystemSetting::observe(SystemSettingObserver::class);
        Category::observe(CategoryObserver::class);
        Service::observe(ServiceObserver::class);
        Template::observe(TemplateObserver::class);
        ConfigTemplate::observe(ConfigTemplateObserver::class);
        User::observe(UserObserver::class);

        #URL::forceScheme('https');
    }
}
