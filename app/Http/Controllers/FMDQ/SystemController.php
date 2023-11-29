<?php

namespace App\Http\Controllers\FMDQ;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemController extends Controller
{
    //
    public function index()
    {
        return view('fmdq.settings.index');
    }

    //
    public function packagesIndex()
    {
        $user = Auth::user();
        $packages = Package::all();
        return view('fmdq.settings.packages', compact('user', 'packages'));
    }
    //
    public function packageStore(Request $request)
    {
        $user = Auth::user();
        $package = new Package();
        $package->Name = $request->Name;
        $create = $package->save();
        //
        if ($create) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Create Package';
            $activity->activity = $user->email . ' created a package named: ' . $request->Name . '.';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            return redirect()->back()->with('success', "Package created.");
        }
    }
    //
    public function packageUpdate(Request $request, $id)
    {
        $user = Auth::user();
        $package = Package::findOrFail($id);
        $package->Name = $request->Name;
        $update = $package->save();
        // $update = Package::where('ID', $id)->update(['Name', $request->Name]);
        //
        if ($update) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Update Package';
            $activity->activity = $user->email . ' updated a package named: ' . $package->Name . '.';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            return redirect()->back()->with('success', "Package updated.");
        }
    }
    //
    public function packageDelete($id)
    {
        $user = Auth::user();
        $package = Package::find($id);
        $delete = $package->delete();
        //
        if ($delete) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Delete Package';
            $activity->activity = $user->email . ' deleted a package .';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            return redirect()->back()->with('success', "Package deleted.");
        }
    }
    //
    public function auctionWindowsIndex()
    {
        return view('fmdq.settings.auction-windows');
    }

    //
    public function publicHolidaysIndex()
    {
        return view('fmdq.settings.public-holidays');
    }

    //
}
