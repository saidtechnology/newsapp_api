<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find($id)
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
