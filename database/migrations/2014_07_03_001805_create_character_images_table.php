<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('character_images', function (Blueprint $table) {
            $table->id();
            // どのキャラクターの画像かを示す外部キー (charactersテーブルのidを参照)
            // キャラクターが削除されたら、関連する画像も自動的に削除されます
            $table->foreignId('character_id')->constrained()->onDelete('cascade');
            $table->string('image_url'); // 画像ファイルの保存パス
            $table->timestamps(); // created_at と updated_at カラム
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_images');
    }
};
