<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function shortUrls()
    {
        return $this->hasMany(ShortUrl::class);
    }

    public function getLastFullShortenedUrl()
    {
        $lastShortUrl = $this->shortUrls()->latest()->first();
        return $lastShortUrl ? $lastShortUrl->full_shortened_url : null;
    }
}

