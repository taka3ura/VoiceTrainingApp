<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Character;      // Characterモデルをインポート
use App\Models\CharacterImage; // CharacterImageモデルをインポート

class CharacterImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 既存のデータを削除（テスト実行時など、重複を避けるため）
        CharacterImage::truncate();

        // ナナ (夢の始まり) - レベル1
        $nanaLv1 = Character::where('name', 'ナナ (夢の始まり)')->first();
        if ($nanaLv1) {
            $nanaLv1->images()->createMany([
                ['image_url' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751433859/1_1_xavnvv.png'],
                ['image_url' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751473595/1_2_c1cvnn.png'],
                ['image_url' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751473609/1_3_ufa8jn.png'],
            ]);
        }

        // ナナ (基礎練習) - レベル2
        $nanaLv2 = Character::where('name', 'ナナ (基礎練習)')->first();
        if ($nanaLv2) {
            $nanaLv2->images()->createMany([
                ['image_url' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751473617/2_1_sfclzo.png'],
                ['image_url' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751473623/2_2_afbiq3.png'],
                ['image_url' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751473620/2_3_po8n8a.png'],
            ]);
        }

        // ナナ (小さな進歩) - レベル3
        $nanaLv3 = Character::where('name', 'ナナ (小さな進歩)')->first();
        if ($nanaLv3) {
            $nanaLv3->images()->createMany([
                ['image_url' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751473616/3_1_xeb3jd.png'],
                ['image_url' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751473614/3_2_xb01fl.png'],
                ['image_url' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751473611/3_3_deywj4.png'],
            ]);
        }

        // ナナ (ボイトレ教室) - レベル4
        $nanaLv4 = Character::where('name', 'ナナ (ボイトレ教室)')->first();
        if ($nanaLv4) {
            $nanaLv4->images()->createMany([
                ['image_url' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751473618/4_1_zteja0.png'],
                ['image_url' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751473613/4_2_uzyn5l.png'],
                ['image_url' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751473615/4_3_wbzgbu.png'],
            ]);
        }

        // ナナ (表現力の向上) - レベル5
        $nanaLv5 = Character::where('name', 'ナナ (表現力の向上)')->first();
        if ($nanaLv5) {
            $nanaLv5->images()->createMany([
                ['image_url' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751473611/5_1_xbk92a.png'],
                ['image_url' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751473612/5_2_tax8ge.png'],
                ['image_url' => 'https://res.cloudinary.com/dee34nq47/image/upload/v1751473616/5_3_gohxbi.png'],
            ]);
        }
    }
}
