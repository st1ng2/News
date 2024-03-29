<?php

class create_news_blocks extends \Spiral\Migrations\Migration
{
    public function up()
    {
        $this->table('news_blocks')
            ->addColumn('id', 'primary')
            ->addColumn('news_id', 'integer')
            ->addColumn('json', 'json')
            ->addForeignKey(['news_id'], 'news', ['id'], ['delete' => 'CASCADE'])
            ->create();
    }

    public function down()
    {
        $this->table('news_blocks')->drop();
    }
}