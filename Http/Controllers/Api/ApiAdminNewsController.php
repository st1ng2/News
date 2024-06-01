<?php

namespace Flute\Modules\News\Http\Controllers\Api;

use Flute\Core\Admin\Http\Middlewares\HasPermissionMiddleware;
use Flute\Core\Support\AbstractController;
use Flute\Core\Support\FluteRequest;
use Flute\Modules\News\Services\NewsService;
use Symfony\Component\HttpFoundation\Response;

class ApiAdminNewsController extends AbstractController
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
        HasPermissionMiddleware::permission(['admin', 'admin.news']);
    }

    public function store(FluteRequest $request): Response
    {
        try {
            $this->newsService->store(
                $request->slug,
                $request->title,
                $request->description,
                $request->files->get('image'),
                $request->input('blocks', '[]'),
                $request->published_at,
            );

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function delete(FluteRequest $request, $id): Response
    {
        try {
            $this->newsService->delete((int) $id);

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(FluteRequest $request, $id): Response
    {
        try {
            $this->newsService->update(
                (int) $id,
                $request->slug,
                $request->title,
                $request->description,
                $request->files->get('image'),
                $request->input('blocks', '[]'),
                $request->published_at,
            );

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}