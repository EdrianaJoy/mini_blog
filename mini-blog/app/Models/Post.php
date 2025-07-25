<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; 

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
    ];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }
}