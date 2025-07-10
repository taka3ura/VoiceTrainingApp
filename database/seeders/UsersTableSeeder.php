<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB; // DBファサードは不要になる
use Illuminate\Support\Str;
use App\Models\User; // Userモデルをインポート
use Illuminate\Support\Facades\Hash; // パスワードハッシュ化のために追加

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 既存のデータを削除（オプション、重複を避けるため）
        // User::truncate(); // これを使う場合は、外部キー制約に注意が必要な場合があります。
        // migrate:fresh --seed を使う場合は不要です。

        // User::create() を使ってユーザーを作成
        User::create([
            'name' => 'HIKAKIN',
            'email' => 'hikakin@example.com',
            'image' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751206242/d1yyyuw9koonvzul201w.jpg',
            'profile_description' => 'ブンブンハローYouTube どうもヒカキンです',
            'practice_days' => 0,
            'last_practice_date' => null,
            'current_character_id' => 1, // マイグレーションのデフォルト値に任せるか、ここで明示的に指定
            'email_verified_at' => now(),
            'password' => Hash::make('password123'), // Hash::make() を使用
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'SEIKIN',
            'email' => 'seikin@example.com',
            'image' => null,
            'profile_description' => '皆さんこんにちは SEIKINTVのSEIKINです',
            'practice_days' => 0,
            'last_practice_date' => null,
            'current_character_id' => 1, // マイグレーションのデフォルト値に任せるか、ここで明示的に指定
            'email_verified_at' => now(),
            'password' => Hash::make('password456'), // Hash::make() を使用
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 必要に応じて他のユーザーを追加
    }
}
