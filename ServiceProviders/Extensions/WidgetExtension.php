<?php

namespace Flute\Modules\News\ServiceProviders\Extensions;

use Flute\Modules\News\Widgets\News\Widget;

class WidgetExtension implements \Flute\Core\Contracts\ModuleExtensionInterface
{
    public function register() : void
    {
        widgets()->register(new Widget());
    }
}