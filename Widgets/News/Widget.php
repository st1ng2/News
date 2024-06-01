<?php

namespace Flute\Modules\News\Widgets\News;

use Flute\Core\Widgets\AbstractWidget;
use Flute\Modules\News\database\Entities\News;
use Flute\Modules\News\Services\NewsService;
use Nette\Utils\Html;

class Widget extends AbstractWidget
{
    public function __construct()
    {
        $this->setAssets([
            'https://unpkg.com/embla-carousel@8.0.0/embla-carousel.umd.js',
            'Modules/News/Widgets/News/assets/js/news.js',
            'Modules/News/Widgets/News/assets/styles/news.scss',
        ]);
    }

    public function render(array $data = []): string
    {
        return render(mm('News', 'Widgets/News/views/index'), [
            'news' => $this->getNews(),
            'service' => app(NewsService::class)
        ]);
    }

    public function placeholder(array $settingValues = []): string
    {
        $row = Html::el('div');
        $row->addClass('row gx-4 gy-4');

        $col = Html::el('div');
        $col->addClass('col-md-3');

        $placeHolder = Html::el('div');
        $placeHolder->addClass('skeleton');
        $placeHolder->style('height', '300px');

        $col->addHtml($placeHolder);

        $row->addHtml($col);
        $row->addHtml($col);
        $row->addHtml($col);
        $row->addHtml($col);

        return $row->toHtml();
    }

    public function getName(): string
    {
        return 'News widget';
    }

    public function isLazyLoad(): bool
    {
        return false;
    }

    protected function getNews()
    {
        $select = rep(News::class)->select()->orderBy('created_at', 'desc')->limit(10);

        if (!user()->hasPermission('admin.news')) {
            $select = $select->where(function ($query) {
                $query->where('published_at', '<=', new \DateTime())
                    ->orWhere('published_at', '=', null);
            });
        }

        return $select->fetchAll();
    }
}