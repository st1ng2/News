<?php

namespace Flute\Modules\News\Http\Controllers\Api;

use Flute\Core\Support\AbstractController;
use Flute\Core\Support\FluteRequest;
use Flute\Modules\News\Services\NewsService;

class ApiNewsController extends AbstractController
{
    public function getNews(FluteRequest $request, NewsService $newsService)
    {
        return $this->json(
            $newsService->getPaginateNews((int) $request->input('page', 1))['result']
        );
    }
}