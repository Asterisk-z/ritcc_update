<?php

namespace App\Http\Controllers\Authoriser;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
    //
    public function __construct()
    {
        // dd('here');

        // $this->middleware(['auth']);
        // $this->middleware('auth');
    }
    //
    public function index()
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
