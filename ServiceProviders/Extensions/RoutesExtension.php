<?php

namespace Flute\Modules\News\ServiceProviders\Extensions;

use Flute\Core\Admin\Http\Middlewares\HasPermissionMiddleware;
use Flute\Core\Router\RouteGroup;
use Flute\Modules\News\Http\Controllers\Api\ApiAdminNewsController;
use Flute\Modules\News\Http\Controllers\Api\ApiNewsController;
use Flute\Modules\News\Http\Controllers\View\ViewAdminNewsController;
use Flute\Modules\News\Http\Controllers\View\ViewNewsController;

class RoutesExtension implements \Flute\Core\Contracts\ModuleExtensionInterface
{
    public function register(): void
    {
        router()->group(function (RouteGroup $routeGroup) {
            $routeGroup->get('/', [ViewNewsController::class, 'list']);

            $routeGroup->get('/get', [ApiNewsController::class, 'getNews']);

            $routeGroup->get('/{slug}', [ViewNewsController::class, 'new']);
        }, 'news');

        router()->group(function (RouteGroup $routeGroup) {
            $routeGroup->middleware(HasPermissionMiddleware::class);

            $routeGroup->group(function (RouteGroup $news) {
                $news->get('list', [ViewAdminNewsController::class, 'list']);
                $news->get('add', [ViewAdminNewsController::class, 'add']);
                $news->get('edit/{id}', [ViewAdminNewsController::class, 'update']);
            }, 'news/');

            $routeGroup->group(function (RouteGroup $news) {
                $news->post('add', [ApiAdminNewsController::class, 'store']);
                $news->post('edit/{id}', [ApiAdminNewsController::class, 'update']);
                $news->delete('{id}', [ApiAdminNewsController::class, 'delete']);
            }, 'api/news/');
        }, 'admin/');
    }
}