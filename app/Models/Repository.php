<?php

namespace App\Models;

use App\Support\URL;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Repository extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'url',
        'description',
    ];

    /**
     * The owner of the repository.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the repository path.
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return URL::getPath($this->url);
    }
}
