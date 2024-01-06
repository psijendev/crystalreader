<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;
use App\Models\Bookmark;

class Document extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'status',
        'isCatalog',
        'catalog_id',
        'user_id',
        'metadata',
        'attachment',
    ];
    protected $hidden = [];
    protected $casts = [
        'metadata' => 'array',
        'isCatalog' => 'string',
        'attachment' => 'array',
    ];

    public function catalog(): BelongsTo {
        return $this->belongsTo(Catalog::class);
    }

    public function bookmarks(): hasMany {
        return $this->hasMany(Bookmark::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
