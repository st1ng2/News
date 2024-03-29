<?php

namespace Flute\Modules\News\database\Entities;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasOne;
use Cycle\Annotated\Annotation\Table;
use Cycle\Annotated\Annotation\Table\Index;

/**
 * @Entity(readonlySchema=true)
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

    public function __construct()
    {
        $this->created_at = new \DateTime();
    }
}