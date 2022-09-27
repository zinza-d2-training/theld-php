<?php
 namespace App\View\Composers;

use App\Services\TopicServices;
use Illuminate\View\View;

class FooterTopicComposer
{
    public function __construct(TopicServices $topicServices)
    {
        $this->topicServices = $topicServices;
    }

    /**
     * Bind data to the view.
    *
    * @param  View  $view
    * @return void
    */
    public function compose(View $view)
    {
        $footerTopics = $this->topicServices->getAll();
        $view->with('footerTopics', $footerTopics);
    }
}
