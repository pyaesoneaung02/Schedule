<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //comment
    protected $fillable=['teacher_id', 'user_id', 'message', 'status'];
}
