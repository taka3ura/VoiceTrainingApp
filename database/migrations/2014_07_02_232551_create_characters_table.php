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
        Schema::create('characters', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->string('name')->unique(); // キャラクターの名前 (ユニーク)
            $table->text('description')->nullable(); // キャラクターの説明 (任意)
            $table->integer('required_level'); // このキャラクターがアンロックされるのに必要なユーザーレベル
            $table->timestamps(); // created_at と updated_at カラム
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
