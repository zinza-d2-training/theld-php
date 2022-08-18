<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    const token_expired_minutes = 15;

    protected $fillable = [
        'email',
        'token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
