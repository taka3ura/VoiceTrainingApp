<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Character;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // キャラクターデータの定義
        $characters = [
            [
                'name' => 'ナナ (夢の始まり)', // ★変更: nameをユニークにする
                'description' => '夢の始まり - 自宅の部屋でひっそりと練習',
                'required_level' => 1, // レベル1でアンロック
            ],
            [
                'name' => 'ナナ (基礎練習)', // ★変更
                'description' => '基礎練習の日々 - 練習着で真剣に',
                'required_level' => 2, // レベル2でアンロック
            ],
            [
                'name' => 'ナナ (小さな進歩)', // ★変更
                'description' => '小さな進歩 - 友達とカラオケで練習',
                'required_level' => 3, // レベル3でアンロック
            ],
            [
                'name' => 'ナナ (ボイトレ教室)', // ★変更
                'description' => 'ボイトレ教室へ - プロの指導を受け始める',
                'required_level' => 4, // レベル4でアンロック
            ],
            [
                'name' => 'ナナ (表現力の向上)', // ★変更
                'description' => '表現力の向上 - 感情を込めて歌い始める',
                'required_level' => 5, // レベル5でアンロック
            ],
        ];

        foreach ($characters as $characterData) {
            Character::create($characterData);
        }
    }
}
