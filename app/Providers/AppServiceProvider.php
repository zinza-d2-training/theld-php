<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Topic;
use App\Models\User;
use App\Observers\CompanyObserver;
use App\Observers\TopicObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();
        Topic::observe(TopicObserver::class);
        User::observe(UserObserver::class);
        Company::observe(CompanyObserver::class);
    }
}
