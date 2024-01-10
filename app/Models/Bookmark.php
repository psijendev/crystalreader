<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookmark extends Model
{
    use HasFactory;
    protected $fillable = [
        'document_id',
        'user_id',
        'status',
    ];
    protected $hidden = [
        'user_id',
    ];
    protected $casts = [];

    public function document(): BelongsTo {
        return $this->belongsTo(Document::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
