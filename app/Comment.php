<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    
    protected $tillable = [
        'content' , 'date_written' , 'user_id' , 'post_id'
    ];
}
