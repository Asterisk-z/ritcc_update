<?php

namespace App\Http\Controllers\FMDQ;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // iqx admin dashboard
    // inputter dashboard
    // authoriser dashboard
    // auctioneer dashboard
    // bidder dashboard
    // firs dashboard


    // all logs
    public function allLogs()
    {
        $logs = ActivityLog::orderBy('date', 'DESC')->get();
        return view('fmdq.logs.all-logs', compact('user', 'logs'));
    }

    // user logs
    public function userLogs()
    {
        $logs = ActivityLog::where('username', auth()->user()->email)->orderBy('date', 'DESC')->get();
        return view('fmdq.logs.user-logs', compact('user', 'logs'));
    }
}
