<?php

namespace Flute\Modules\News\database\Entities;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasOne;
use Cycle\Annotated\Annotation\Table;
use Cycle\Annotated\Annotation\Table\Index;

/**
 * @Entity()
 * @Table(
 *      indexes={
 *          @Index(columns={"slug"}, unique=true)
 *      }
 * )
 */
class News
{
    /** @Column(type="primary") */
    public $id;

    /** @Column(type="string") */
    public $slug;

    /** @Column(type="string") */
    public $title;

    /** @Column(type="string") */
    public $description;

    /** @Column(type="string") */
    public $image;

    /** @HasOne(target="NewsBlock") */
    public $blocks;

    /**
     * @Column(type="timestamp", default="CURRENT_TIMESTAMP")
     */
    public $created_at;

    /**
     * @Column(type="timestamp", nullable=true)
     */
    public $published_at;

    /**
     * @Column(type="boolean", default=false)
     */
    public $notification_sent = false;

    /**
     * @Column(type="integer", default=0)
     */
    public $views = 0;

    public function __construct()
    {
        $this->created_at = new \DateTime();
    }

    /**
     * Determine if the news is published.
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published_at === null || $this->published_at <= new \DateTime();
    }

    /**
     * Schedule the publication of the news.
     *
     * @param \DateTime $publishDate
     */
    public function schedulePublication(\DateTime $publishDate): void
    {
        $this->published_at = $publishDate;
    }

    /**
     * Mark the news as notification sent.
     */
    public function markNotificationSent(): void
    {
        $this->notification_sent = true;
    }

    /**
     * Increment the view count.
     */
    public function incrementViews(): void
    {
        $this->views++;
    }
}