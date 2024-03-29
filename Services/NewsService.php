<?php

namespace Flute\Modules\News\Services;

use Flute\Core\Page\PageEditorParser;
use Flute\Modules\News\database\Entities\News;
use Flute\Modules\News\database\Entities\NewsBlock;
use Nette\Utils\Json;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class NewsService
{
    public function find($slugOrId)
    {
        $where = !is_int($slugOrId) ? [
            'slug' => $slugOrId
        ] : [
            'id' => $slugOrId
        ];

        $new = rep(News::class)->select()->load('blocks')->where($where)->fetchOne();

        if (!$new) {
            throw new \Exception(__('news.not_found'));
        }

        return $new;
    }

    public function formatDate($date)
    {
        $monthsRu = [
            "января",
            "февраля",
            "марта",
            "апреля",
            "мая",
            "июня",
            "июля",
            "августа",
            "сентября",
            "октября",
            "ноября",
            "декабря"
        ];
        $monthsEn = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ];
        $months = app()->getLang() === 'ru' ? $monthsRu : $monthsEn;

        $formattedDate = $date->format("d ") . $months[$date->format("n") - 1] . $date->format(", Y H:i");
        return $formattedDate;
    }

    public function parseBlocks(News $news)
    {
        /** @var PageEditorParser $parser */
        $parser = app(PageEditorParser::class);

        $blocks = Json::decode($news->blocks->json ?? '[]', Json::FORCE_ARRAY);

        return $parser->parse($blocks);
    }

    public function getPaginateNews(int $page = 1)
    {
        $select = rep(News::class)
            ->select()
            ->orderBy('created_at', 'desc');

        $itemsPerPage = 8;

        $offset = ($page - 1) * $itemsPerPage;

        $totalItems = rep(News::class)->select()->count();
        $totalPages = ceil($totalItems / $itemsPerPage);

        return [
            'result' => $select->limit($itemsPerPage)
                ->offset($offset)
                ->fetchAll(),
            'count' => $totalPages,
        ];
    }

    /**
     * Загрузка и обработка изображения слайда.
     *
     * @param UploadedFile $file
     * @return string
     */
    public function uploadImage(UploadedFile $file)
    {
        $maxSize = 5000000;
        $allowedMimeTypes = ['image/png', 'image/jpeg', 'image/gif', 'image/webp'];;

        if ($file->getSize() > $maxSize) {
            throw new \Exception(__('validator.max_post_size', ['%d' => $maxSize]));
        }

        try {
            $mimeType = $file->getMimeType();
        } catch (\Exception $e) {
            logs()->error($file->getErrorMessage());

            throw new \Exception(__('def.unknown_error'));
        }

        if (!in_array($mimeType, $allowedMimeTypes)) {
            throw new \Exception(__('validator.image'));
        }

        $fileName = hash('sha256', uniqid()) . '.' . $file->getClientOriginalExtension();
        $destination = BASE_PATH . '/public/assets/uploads';

        if (!file_exists($destination)) {
            mkdir($destination, 0700, true);
        }

        $file->move($destination, $fileName);

        // Конвертация в WebP при необходимости
        $newFileDestination = 'assets/uploads/' . $fileName;
        if (in_array($mimeType, ['image/png', 'image/jpeg']) && config('profile.convert_to_webp')) {
            $webPFileName = hash('sha256', uniqid()) . '.webp';
            try {
                \WebPConvert\WebPConvert::convert($destination . '/' . $fileName, $destination . '/' . $webPFileName);
                unlink($destination . '/' . $fileName); // Удаление исходного файла
                $newFileDestination = 'assets/uploads/' . $webPFileName;
            } catch (\Exception $e) {
                // Обработка ошибок конвертации
            }
        }

        return $newFileDestination;
    }

    public function store(string $slug, string $title, string $description, $img, $json)
    {
        $this->checkUnique($slug);

        $new = new News;

        $new->slug = $slug;
        $new->title = $title;
        $new->description = $description;
        $new->image = $this->uploadImage($img);

        $block = new NewsBlock;
        $block->json = $json;
        $block->news = $new;

        $new->blocks = $block;

        transaction($new)->run();
    }

    public function update(int $id, string $slug, string $title, string $description, $img, $json)
    {
        $this->checkUnique($slug, $id);

        $new = $this->find($id);

        $new->slug = $slug;
        $new->title = $title;
        $new->description = $description;

        if ($img) {
            try {
                fs()->remove(BASE_PATH . '/public/' . $new->image);
            } catch (\Exception $e) {
                // we ignore
            }

            $new->image = $this->uploadImage($img);
        }

        $block = new NewsBlock;
        $block->json = $json;
        $block->news = $new;

        $new->blocks = $block;

        transaction($new)->run();
    }

    public function checkUnique(string $slug, ?int $id = null)
    {
        $get = rep(News::class)->select()->where([
            'slug' => $slug
        ]);

        if ($id)
            $get->where('id', '!=', $id);

        $get = $get->fetchOne();

        if ($get) {
            throw new \Exception(__('def.slug_taken'));
        }
    }

    public function delete(int $id): void
    {
        $new = $this->find($id);

        transaction($new, 'delete')->run();

        return;
    }
}
