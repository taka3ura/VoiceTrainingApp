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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('image')->nullable(); // プロフィール画像など
            $table->integer('practice_days')->default(0); // 練習日数 (ユーザーレベル算出に使用)
            $table->date('last_practice_date')->nullable();
            // 現在設定されているキャラクターのIDを保持する外部キー
            $table->foreignId('current_character_id')->nullable()->default(1)->constrained('characters')->onDelete('set null');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
