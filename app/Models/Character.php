<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'required_level',
    ];

    /**
     * このキャラクターに関連する画像を全て取得します。
     * 一対多のリレーションシップ。
     */
    public function images(): HasMany
    {
        return $this->hasMany(CharacterImage::class);
    }

    /**
     * このキャラクターを所有するユーザーを全て取得します。
     * 多対多のリレーションシップ。
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_characters');
    }

    /**
     * このキャラクターを現在設定しているユーザーを全て取得します。
     * 一対多のリレーションシップ。
     */
    public function currentUsers(): HasMany
    {
        return $this->hasMany(User::class, 'current_character_id');
    }
}
