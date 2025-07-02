<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'HIKAKIN',
                'email' => 'hikakin@example.com',
                'image' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751206242/d1yyyuw9koonvzul201w.jpg',
                'practice_days' => 0, // 練習した日数の初期値
                'last_practice_date' => null, // 最終処理した日付
                'email_verified_at' => now(),
                'password' => bcrypt('password123'), // パスワードはハッシュ化
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SEIKIN',
                'email' => 'seikin@example.com',
                'image' => null,
                'practice_days' => 0, // 練習した日数の初期値
                'last_practice_date' => null, // 最終処理した日付
                'email_verified_at' => now(),
                'password' => bcrypt('password456'), // パスワードはハッシュ化
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 必要に応じて他のユーザーを追加
        ]);
    }
}
