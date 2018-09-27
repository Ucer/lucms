<?php

namespace App\Models;

class AdminMessage extends Model
{

    protected $fillable = [
        'user_id', 'title', 'content', 'status'
    ];

}
