<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_ACTIVATE = 1;
    const STATUS_DEACTIVATE = 0;

    protected $fillable = [
        'name',
        'logo',
        'address',
        'max_user',
        'expired_at',
        'status'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function companyAccount()
    {
        return $this->hasOne(User::class)->where('role_id', User::ROLE_COMPANY_ACCOUNT);
    }
}
