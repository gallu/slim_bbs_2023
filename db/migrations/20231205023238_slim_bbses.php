<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SlimBbses extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('slim_bbses', [
            'id' => false,
            'primary_key' => 'bbs_id',
            'comment' => '掲示板テーブル',
        ]);
        $table
            ->addColumn('bbs_id', 'biginteger', ['null' => false, 'signed' => false, 'identity' => true,])
            ->addColumn('name', 'string', ['limit' => 128, 'null' => false, 'comment' => '投稿者名', ])
            ->addColumn('title', 'string', ['limit' => 128, 'null' => false, 'comment' => 'タイトル', ])
            ->addColumn('body', 'text', ['comment' => '本文'])
            ->addColumn('user_agent', 'text', ['comment' => 'ブラウザ名'])
            ->addColumn('from_ip', 'string', ['limit' => 128, 'null' => false, 'comment' => '接続元IP', ])
            // ->addColumn('created_at', 'datetime', [/*'null' => false, 　'default' => 'CURRENT_TIMESTAMP'　MariaDBなので使えない orz　*/])
            ->addColumn('created_at', 'datetime', [])
            ->create();
    }
}
