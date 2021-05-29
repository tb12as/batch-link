<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $guarded = []; // change to fillable sometimes

    public function paste()
    {
    	return $this->belongsTo(Paste::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
