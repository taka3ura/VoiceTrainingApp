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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('body');
            $table->string('audio_url')->nullable();
            $table->unsignedBigInteger('user_id'); // 外部キーとして追加するカラム
            $table->timestamps(); // ここで created_at と updated_at が追加される
            $table->softDeletes();

            // 外部キー制約を追加
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // 外部キー制約の削除
        });

        Schema::dropIfExists('posts'); // テーブルの削除
    }
};
