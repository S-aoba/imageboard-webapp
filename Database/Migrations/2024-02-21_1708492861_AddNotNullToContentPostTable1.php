<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class AddNotNullToContentPostTable1 implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "ALTER TABLE posts MODIFY content TEXT NOT NULL"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "ALTER TABLE posts MODIFY content TEXT"
        ];
    }
}
