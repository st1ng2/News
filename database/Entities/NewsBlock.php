<?php

namespace Flute\Modules\News\database\Entities;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\BelongsTo;

/**
 * @Entity(readonlySchema=true)
 */
class NewsBlock
{
    /** @Column(type="primary") */
    public $id;

    /** @BelongsTo(target="News", nullable=false) */
    public $news;

    /** @Column(type="json") */
    public $json;
}