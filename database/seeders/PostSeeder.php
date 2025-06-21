<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert(
            [
                'body' => 'これは最初の投稿です。',
                'user_id' => 1, // ユーザーIDを適切に設定
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'deleted_at' => null, // ソフトデリートを使用する場合
            ],
        );
    }
}
