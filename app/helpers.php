<?php

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;

if (!function_exists('logAction')) {
    function logAction($email, $type, $activity)
    {
        ActivityLog::create([
            'date' => now(),
            'app' => 'RITCC',
            'username' => $email,
            'type' => $type,
            'activity' => $activity,
            'IP' => Request::ip(),
        ]);
    }
}
