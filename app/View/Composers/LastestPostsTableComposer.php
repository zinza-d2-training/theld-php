<?php
 namespace App\View\Composers;

use App\Services\DashboardServices;
use App\Services\PostServices;
use App\Services\TopicServices;
use Illuminate\View\View;

class LastestPostsTableComposer
{
    public function __construct(DashboardServices $dashboardServices)
    {
        $this->dashboardServices = $dashboardServices;
    }

    /**
     * Bind data to the view.
    *
    * @param  View  $view
    * @return void
    */
    public function compose(View $view)
    {
        $lastestPosts = $this->dashboardServices->lastestPost();
        $view->with('lastestPosts', $lastestPosts);
    }
}
