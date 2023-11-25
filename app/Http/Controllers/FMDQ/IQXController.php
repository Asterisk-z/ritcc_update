<?php

namespace App\Http\Controllers\FMDQ;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class IQXController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profiles = Profile::orderBy('InputDate', 'ASC')->with('package')->get();
        $all = Profile::count();
        $approved = Profile::where('status', '1')->count();
        $pending = Profile::where('status', '0')->orWhere('status', '3')->orWhere('status', '4')->count();
        $rejected = Profile::where('status', '2')->count();
        return view('fmdq.iqx.dashboard', compact('user', 'profiles', 'all', 'pending', 'approved', 'rejected'));
    }

    //
    public function activityLog()
    {
        $user = Auth::user();
        $logs = ActivityLog::orderBy('date', 'DESC')->get();
        return view('fmdq.iqx.activity-logs', compact('user', 'logs'));
    }
}
