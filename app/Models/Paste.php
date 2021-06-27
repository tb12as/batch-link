<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paste extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id', 'slug', 'privacy'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
            ->translatedFormat('l, d M Y - H:i:s') . " (" . Carbon::parse($this->attributes['created_at'])->diffForHumans() . ")";
    }
}
