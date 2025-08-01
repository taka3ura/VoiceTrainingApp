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
            'name' => 'ナナ',
            'email' => 'nana@example.com',
            'image' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751473623/2_2_afbiq3.png',
            'profile_description' => "皆さんこんにちは ナナです\nわたしが応援するので歌の練習頑張ろうね！",
            'practice_menu' => "呼吸：腹式呼吸の練習\n発声：口を縦に開いてチェストを鳴らす\n意識すること：喉は意識せずに伸び伸びと歌う、毎日自分の歌声を録音する",
            'practice_days' => 100,
            'last_practice_date' => null,
            'current_character_id' => 1, // マイグレーションのデフォルト値に任せるか、ここで明示的に指定
            'email_verified_at' => now(),
            'password' => Hash::make(Str::random(12)), // Hash::make() を使用
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'テストユーザー',
            'email' => 'test@test.com',
            'image' => null,
            'profile_description' => "テスト用のアカウントです\n自己紹介",
            'practice_menu' => "呼吸：腹式呼吸の練習\n発声：口を縦に開いてチェストを鳴らす\n意識すること：喉は意識せずに伸び伸びと歌う、毎日自分の歌声を録音する",
            'practice_days' => 0,
            'last_practice_date' => null,
            'current_character_id' => 1, // マイグレーションのデフォルト値に任せるか、ここで明示的に指定
            'email_verified_at' => now(),
            'password' => Hash::make('test'), // Hash::make() を使用
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // 必要に応じて他のユーザーを追加
    }
}
