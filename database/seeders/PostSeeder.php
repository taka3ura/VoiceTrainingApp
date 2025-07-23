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
        DB::table('posts')->insert([
            [
                'body' => 'これは最初の投稿です。',
                'audio_url' => null,
                'user_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'deleted_at' => null,
            ],
            [
                'body' => 'これは二番目の投稿です。',
                'audio_url' => null,
                'user_id' => 3,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'deleted_at' => null,
            ],
            [
                'body' => 'これは三番目の投稿です。',
                'audio_url' => null,
                'user_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'deleted_at' => null,
            ],
            [
                'body' => 'これは四番目の投稿です。',
                'audio_url' => null,
                'user_id' => 3,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'deleted_at' => null,
            ],
            [
                'body' => 'これは五番目の投稿です。',
                'audio_url' => null,
                'user_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'deleted_at' => null,
            ],
            [
                'body' => 'これは六番目の投稿です。',
                'audio_url' => null,
                'user_id' => 3,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'deleted_at' => null,
            ],
            [
                'body' => 'これは七番目の投稿です。',
                'audio_url' => null,
                'user_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'deleted_at' => null,
            ],
            [
                'body' => 'これは八番目の投稿です。',
                'audio_url' => null,
                'user_id' => 3,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'deleted_at' => null,
            ],
            [
                'body' => 'これは九番目の投稿です。',
                'audio_url' => null,
                'user_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'deleted_at' => null,
            ],
            [
                'body' => 'これは十番目の投稿です。',
                'audio_url' => null,
                'user_id' => 3,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'deleted_at' => null,
            ],
            [
                'body' => 'これは十一番目の投稿です。',
                'audio_url' => null,
                'user_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
                'deleted_at' => null,
            ],
        ]);
    }
}
