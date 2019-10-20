<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $tillable = [
        'content' , 'date_written' , 'user_id' , 'post_id'
    ];
}
