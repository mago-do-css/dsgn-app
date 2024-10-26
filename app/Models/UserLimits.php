<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLimits extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'day_limit',
        'date_time_today',
    ];
}
