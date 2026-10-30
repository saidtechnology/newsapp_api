<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'content', 'date_written', 'featured_image', 'votes_up', 'votes_down', 'user_id', 'category_id',
    ];

    /**
     * The author of the post.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Comments on the post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The category the post belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
