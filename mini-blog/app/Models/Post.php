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

    public function scopePublished($query)
    {
        return $query->where('status','published');
    }

    public function scopePending($query)
    {
        return $query->where('status','pending');
    }

    public function scopeDeleted($query)
    {
        return $query->where('status','deleted');
    }
}