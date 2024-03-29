<?php

namespace Flute\Modules\News\Http\Controllers\View;

use Flute\Core\Admin\Http\Middlewares\HasPermissionMiddleware;
use Flute\Core\Support\AbstractController;
use Flute\Modules\News\database\Entities\News;
use Flute\Modules\News\Services\NewsService;
use Symfony\Component\HttpFoundation\Response;

class ViewAdminNewsController extends AbstractController
{
    public function __construct()
    {
        HasPermissionMiddleware::permission(['admin', 'admin.news']);
    }
    
    public function list() : Response
    {
        $table = table();
        $table
            ->fromEntity(rep(News::class)->select()->orderBy('id', 'DESC')->fetchAll(), ['image', 'description', 'blocks'])
            ->withActions('news');

        return view(mm('News', 'Resources/Views/admin/list'), [
            'table' => $table->render()
        ]);
    }

    public function update( $id, NewsService $newsService ) : Response
    {
        try {
            $new = $newsService->find((int) $id);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 404);
        }

        return view(mm('News', 'Resources/Views/admin/edit'), [
            'new' => $new
        ]);
    }

    public function add() : Response
    {
        return view(mm('News', 'Resources/Views/admin/add'));
    }
}