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
        Schema::create('user_characters', function (Blueprint $table) {
            $table->id(); // 主キー
            // user_id と character_id の外部キー設定
            // ユーザーまたはキャラクターが削除されたら、関連する紐付けも削除されます
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('character_id')->constrained()->onDelete('cascade');
            $table->timestamps(); // created_at と updated_at カラム

            // 同じユーザーが同じキャラクターを複数回紐付けできないようにするユニーク制約
            $table->unique(['user_id', 'character_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_characters');
    }
};
