<?php

namespace App\Providers;

use App\Models\Topic;
use App\View\Components\DashboardNewPostsTable;
use App\View\Composers\FooterTopicComposer;
use App\View\Composers\LastestPostsTableComposer;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.footer', FooterTopicComposer::class); 
        view()->composer('components.dashboard.new-posts-table', LastestPostsTableComposer::class); 
    }   
}
