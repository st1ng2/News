<?php

namespace Flute\Modules\News\Events;

use Flute\Modules\News\database\Entities\News;
use Symfony\Contracts\EventDispatcher\Event;

class NewPublishedEvent extends Event
{
    public const NAME = 'flute.news.published';

    public News $new;

    public function __construct( News $new )
    {
        $this->new = $new;
    }
}