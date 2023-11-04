<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Post
 * @package App
 */

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title' , 'content' , 'date_written' , 'featured_image' , 'votes_up' , 'votes_down' , 'user_id' , 'category_id'
    ];


    /**
     *
     * Relation Ship.
     */

    public function author(){
        return $this->belongsTo( User::class ,'user_id' ,'id' );

    }

    public function comments(){
        return $this->hasMany( Comment::class );

    }

    public function category(){
        return $this->belongsTo( Category::class );

    }
}
