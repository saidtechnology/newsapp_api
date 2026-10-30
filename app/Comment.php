<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', 'date_written', 'user_id', 'post_id',
    ];

    /**
     * The post this comment belongs to.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * The author of this comment.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
