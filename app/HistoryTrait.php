<?php

namespace App;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLimits;

trait HistoryTrait
{
    public function getUserLimitData()
    {
        $userId = Auth::user()->getAuthIdentifier();
        return UserLimits::where('user_id', $userId)->first();
    }
}
