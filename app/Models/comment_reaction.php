<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment_reaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'comment_id'
    ];
}
