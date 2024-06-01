<?php

namespace Flute\Modules\News\Http\Controllers\View;

use Flute\Core\Admin\Http\Middlewares\HasPermissionMiddleware;
use Flute\Core\Support\AbstractController;
use Flute\Core\Table\TableColumn;
use Flute\Modules\News\database\Entities\News;
use Flute\Modules\News\Services\NewsService;
use Symfony\Component\HttpFoundation\Response;

class ViewAdminNewsController extends AbstractController
{
    public function __construct()
    {
        HasPermissionMiddleware::permission(['admin', 'admin.news']);
    }

    public function list(): Response
    {
        $table = table();

        $news = rep(News::class)->select()->fetchAll();

        foreach ($news as $new) {
            if (!$new->published_at) {
                $new->published_time = '<div class="new-published">' . __('news.published') . '</div>';
            } else {
                $formattedTime = $new->published_at->format(default_date_format());

                if ($new->published_at <= now()) {
                    $new->published_time = '<div data-tooltip="' . $formattedTime . '" data-tooltip-conf="left">' . __('news.was_published') . '</div>';
                } else {
                    $new->published_time = '<div class="will-published">' . __('news.will_published', [
                        ':date' => $formattedTime
                    ]) . '</div>';
                }
            }

            $new->created_at = $new->created_at->format(default_date_format());
        }

        $table->addColumns([
            new TableColumn('id', "ID"),
            new TableColumn('slug', __('news.admin.slug')),
            new TableColumn('title', __('news.admin.title_label')),
            new TableColumn('created_at', __('def.created_at')),
            new TableColumn('views', __('news.views')),
            (new TableColumn('published_time', __('news.admin.published_at')))->setClean(false),
        ])->withActions('news', [
                    [
                        'class' => ['view', 'ignore'],
                        'iconClass' => 'ph-arrow-up-right',
                        'attributes' => [
                            'data-translate' => '"def.view"',
                            'target' => '"_blank"',
                            'data-translate-attribute' => '"data-tooltip"',
                            'data-tooltip-conf' => '"left"',
                            'href' => 'u(`news/`+data[1])',
                        ]
                    ],
                ]);

        $table->setData($news);

        return view(mm('News', 'Resources/Views/admin/list'), [
            'table' => $table->render()
        ]);
    }

    public function update($id, NewsService $newsService): Response
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

    public function add(): Response
    {
        return view(mm('News', 'Resources/Views/admin/add'));
    }
}