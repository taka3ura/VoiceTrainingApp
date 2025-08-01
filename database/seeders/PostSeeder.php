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
        // 既存のデータを削除（オプション、重複を避けるため）
        // DB::table('posts')->truncate(); // すでにデータがある場合に全て削除したいならこれを使用
        // または、特定の条件で削除する場合は以下のように
        // DB::table('posts')->where('user_id', 2)->delete(); // 例：user_idが2の投稿を削除

        // 投稿データの挿入部分を全て削除しました。
        // DB::table('posts')->insert([
        //     [
        //         'body' => 'これは最初の投稿です。',
        //         'audio_url' => null,
        //         'user_id' => 2,
        //         'created_at' => new DateTime(),
        //         'updated_at' => new DateTime(),
        //         'deleted_at' => null,
        //     ],
        //     // ... 他の投稿データも削除 ...
        // ]);
    }
}
