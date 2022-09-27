<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_WAITING = 0;
    const STATUS_DESOLVED = 1;
    const STATUS_RESOLVED = 2;
    const STATUS_REJECTED = -1;

    protected $fillable = [
        'title',
        'description',
        'topic_id',
        'user_id',
        'status'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function postTags()
    {
        return $this->hasMany(PostTag::class);
    }
}
