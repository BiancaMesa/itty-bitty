<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // The attributes that are mass assignable
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // The attributes that should be hidden for serialization
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // The attributes that should be cast
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Get the short URLs associated with the user
    public function shortUrls()
    {
        return $this->hasMany(ShortUrl::class);
    }

    // Get the latest full shortened URL for the user
    public function getLastFullShortenedUrl()
    {
        $lastShortUrl = $this->shortUrls()->latest()->first();
        return $lastShortUrl ? $lastShortUrl->full_shortened_url : null;
    }
}

