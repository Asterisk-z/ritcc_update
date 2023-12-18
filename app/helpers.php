<?php

use App\Helpers\ResponseStatusCodes;
use App\Models\ActivityLog;
use App\Models\Audit;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;
use Symfony\Component\HttpFoundation\Response;


if (!function_exists('logAction')) {
    function logAction($username, $type, $activity)
    {
        ActivityLog::create([
            'username' => $username,
            'app' => 'RITCC',
            'type' => $type,
            'activity' => $activity,
            'date' => now(),
        ]);
    }
}