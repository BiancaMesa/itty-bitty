<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    use HasFactory;

    // The attributes that are mass assignable
    protected $fillable = [
        'user_id',
        'original_url',
        'short_url_key',
        'full_shortened_url',
        'clicks',
    ];

    // Get the user that owns the ShortUrl
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
