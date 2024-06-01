<?php

namespace Flute\Modules\News\ServiceProviders\Extensions;

use Flute\Core\Admin\Builders\AdminSidebarBuilder;

class AdminExtension implements \Flute\Core\Contracts\ModuleExtensionInterface
{
    public function register(): void
    {
        $this->addSidebar();
    }

    private function addSidebar(): void
    {
        // AdminSidebarBuilder::add('news.admin.title', [
        //     'title' => 'news.stats.title',
        //     'icon' => 'ph-chart-bar',
        //     'permission' => 'admin.news',
        //     'url' => '/admin/news/stats'
        // ]);

        AdminSidebarBuilder::add('additional', [
            'title' => 'news.admin.title',
            'icon' => 'ph-newspaper',
            'permission' => 'admin.news',
            'url' => '/admin/news/list'
        ]);
    }
}