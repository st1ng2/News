<?php

class create_news extends \Spiral\Migrations\Migration
{
    public function up()
    {
        $this->table('news')
            ->addColumn('id', 'primary')
            ->addColumn('slug', 'string')
            ->addColumn('title', 'string')
            ->addColumn('description', 'string')
            ->addColumn('image', 'string')
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP'
            ])
            ->setPrimaryKeys(['id'])
            ->addIndex(['slug'], ['unique' => true])
            ->create();
    }

    public function down()
    {
        $this->table('news')->drop();
    }
}