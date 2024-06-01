<?php

namespace Flute\Modules\News;

use Flute\Core\Database\Entities\Permission;
use Flute\Modules\News\Widgets\News\Widget;

class Installer extends \Flute\Core\Support\AbstractModuleInstaller
{
    public function install(\Flute\Core\Modules\ModuleInformation &$module): bool
    {
        $permission = rep(Permission::class)->findOne([
            'name' => 'admin.news'
        ]);

        if (!$permission) {
            $permission = new Permission;
            $permission->name = 'admin.news';
            $permission->desc = 'news.perm_desc';

            transaction($permission)->run();
        }

        return true;
    }

    public function uninstall(\Flute\Core\Modules\ModuleInformation &$module): bool
    {
        $permission = rep(Permission::class)->findOne([
            'name' => 'admin.news'
        ]);

        if ($permission) {
            transaction($permission, 'delete')->run();
        }

        widgets()->unregister(Widget::class);

        return true;
    }
}