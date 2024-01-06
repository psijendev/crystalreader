<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Catalog extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'metadata',
        'cover',
    ];
    protected $hidden = [];
    protected $casts = [
        'metadata' => 'array',
        'cover' => 'array'
    ];

    public function documents(): hasMany {
        return $this->hasMany(Document::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
