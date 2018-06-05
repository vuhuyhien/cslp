<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'intro',
        'image',
        'type',
        'category_id',
        'title'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
}
