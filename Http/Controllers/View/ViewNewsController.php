<?php

namespace Flute\Modules\News\Http\Controllers\View;

use Flute\Core\Support\AbstractController;
use Flute\Core\Support\FluteRequest;
use Flute\Modules\News\Services\NewsService;

class ViewNewsController extends AbstractController
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
        page()->disablePageEditor();
    }

    public function list()
    {
        $news = $this->newsService->getPaginateNews();

        return view(mm('News', 'Resources/Views/list'), [
            'news' => $news['result'],
            'count' => $news['count'],
            'service' => $this->newsService
        ]);
    }

    public function new(FluteRequest $request, string $slug)
    {
        try {
            $new = $this->newsService->find($slug);

            return view(mm('News', 'Resources/Views/new'), [
                'new' => $new,
                'editor' => $this->newsService->parseBlocks($new),
                'service' => $this->newsService
            ]);

        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 404);
        }
    }
}