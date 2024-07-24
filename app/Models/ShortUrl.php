<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'original_url',
        'short_url_key',
        'full_shortened_url',
        'clicks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
