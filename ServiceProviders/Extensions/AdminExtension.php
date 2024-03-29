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
        AdminSidebarBuilder::add('additional', [
            'title' => 'news.admin.title',
            'icon' => 'ph-newspaper',
            'permission' => 'admin.news',
            'url' => '/admin/news/list'
        ]);
    }
}