<?php

namespace App\Http\Controllers\Inputter;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
    public function __construct()
    {
        // dd('here');

        // $this->middleware(['auth']);
        // $this->middleware('auth');
    }

    //
    public function dashboard()
    {
        $user = Auth::user();
        return view('inputter.dashboard', compact('user'));
    }

    //
    public function profilesIndex()
    {
        $user = Auth::user();
        $profiles = Profile::orderBy('InputDate', 'ASC')->with('package')->get();
        $all = Profile::count();
        $approved = Profile::where('status', '1')->count();
        $pending = Profile::where('status', '0')->orWhere('status', '3')->orWhere('status', '4')->count();
        $rejected = Profile::where('status', '2')->count();
        return view('inputter.profile', compact('user', 'profiles', 'all', 'pending', 'approved', 'rejected'));
    }
}
