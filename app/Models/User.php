<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pastes()
    {
        return $this->hasMany(Paste::class);
    }

    // untuk sekarang sepertinya tidak perlu relasi links
    // update : sepertinya perlu relasi links
    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function bookmarks()
    {
        return $this->belongsToMany(Paste::class, 'bookmarks')
            ->withTimestamps()
            ->orderByPivot('created_at', 'desc');
    }
}
