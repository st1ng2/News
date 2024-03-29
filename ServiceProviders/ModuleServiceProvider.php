<?php

namespace Flute\Modules\News\ServiceProviders;

use Flute\Core\Support\ModuleServiceProvider as AbstractModuleServiceProvider;
use Flute\Modules\News\ServiceProviders\Extensions\AdminExtension;
use Flute\Modules\News\ServiceProviders\Extensions\RoutesExtension;
use Flute\Modules\News\ServiceProviders\Extensions\WidgetExtension;

class ModuleServiceProvider extends AbstractModuleServiceProvider
{
    public array $extensions = [
        WidgetExtension::class,
        RoutesExtension::class,
        AdminExtension::class
    ];

    public function boot(\DI\Container $container): void
    {
        $this->loadEntities();
        $this->loadTranslations();
    }

    public function register(\DI\Container $container): void
    {
    }
}