<?php

namespace App\Models;

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
}
