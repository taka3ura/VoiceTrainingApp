<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CharacterImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'character_id',
        'image_url',
    ];

    /**
     * この画像が属するキャラクターを取得します。
     * 一対多（逆）のリレーションシップ。
     */
    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }
}
