<?php

namespace App\Http\Controllers\FMDQ;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AuctionWindows;
use App\Models\Package;
use App\Models\PublicHoliday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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
    public function holidaysIndex()
    {
        $user = Auth::user();
        $holidays = PublicHoliday::all();
        return view('fmdq.settings.public-holidays', compact('user', 'holidays'));
    }
    //
    public function storeHoliday(Request $request)
    {
        $user = Auth::user();
        //
        //
        $validated = $request->validate([
            'date' => 'bail|required|unique:tblPublicHolidays|after:today',
        ], [
            'date.unique' => 'This date has already been registered.',
            'date.after' => 'You cannot register a date before today as a Public Holiday.',
        ]);
        //
        if ($validated) {
            $holiday = new PublicHoliday();
            $holiday->name = $request->name;
            $holiday->date = $request->date;
            $holiday->createdBy = $user->email;
            $create = $holiday->save();
            //
            if ($create) {
                // log activity
                $activity = new ActivityLog();
                $activity->date = now();
                $activity->app = 'RITCC';
                $activity->type = 'Create Public Holiday';
                $activity->activity = $user->email . ' created a public holiday named: ' . $request->name . '.';
                $activity->username = $user->email;
                $log = $activity->save();
            }
            if ($log) {
                return redirect()->back()->with('success', "Public Holiday created.");
            }
        } else {
            // If there are validation errors, you can return to the form with the errors
            return back()->withErrors($validated);
        }
    }
    //
    public function updateHoliday(Request $request)
    {
        $user = Auth::user();
        $id = $request->id;
        $holiday = PublicHoliday::findOrFail($id);
        $holiday->name = $request->name;
        $holiday->date = $request->date;
        $holiday->createdBy = $user->email;
        $update = $holiday->save();
        //
        if ($update) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Update Holiday';
            $activity->activity = $user->email . ' updated a public holiday named: ' . $holiday->name . '.';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            return redirect()->back()->with('success', "Holiday updated.");
        }
    }
    //
    public function deleteHoliday(Request $request)
    {
        $user = Auth::user();
        $id = $request->id;
        $holiday = PublicHoliday::findOrFail($id);
        $delete = $holiday->delete();
        //
        if ($delete) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Delete Holiday';
            $activity->activity = $user->email . ' deleted an holiday .';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            return redirect()->back()->with('success', "Holiday deleted.");
        }
    }
    //
    public function windowsIndex()
    {
        $user = Auth::user();
        $windows = AuctionWindows::all();
        return view('fmdq.settings.auction-windows', compact('user', 'windows'));
    }
    //
    public function storeWindow(Request $request)
    {
        $user = Auth::user();
        $window = new AuctionWindows();
        $window->start = $request->start;
        $window->end = $request->end;
        $window->createdBy = $user->email;
        $window->createdDate = now();
        $create = $window->save();
        //
        if ($create) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Create Auction Window';
            $activity->activity = $user->email . ' created an auction window.';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            return redirect()->back()->with('success', "Auction Window created.");
        }
        //
        // $validated = $request->validate([
        //     'start' => 'date|after_or_equal:today',
        //     'end' => 'date|after_or_equal:' . $request->start . '',
        // ], [
        //     'start.unique' => 'This auction window has already been registered.',
        //     // 'start.after' => 'You cannot register a date before today as a Public Holiday.',
        // ]);
        // //
        // if ($validated) {
        //     $window = new AuctionWindows();
        //     $window->start = $request->start;
        //     $window->end = $request->end;
        //     $window->createdBy = $user->email;
        //     $window->createdDate = now();
        //     $create = $window->save();
        //     //
        //     if ($create) {
        //         // log activity
        //         $activity = new ActivityLog();
        //         $activity->date = now();
        //         $activity->app = 'RITCC';
        //         $activity->type = 'Create Auction Window';
        //         $activity->activity = $user->email . ' created an auction window.';
        //         $activity->username = $user->email;
        //         $log = $activity->save();
        //     }
        //     if ($log) {
        //         return redirect()->back()->with('success', "Auction Window created.");
        //     }
        // } else {
        //     // If there are validation errors, you can return to the form with the errors
        //     return back()->withErrors($validated);
        // }
    }
    //
    public function updateWindow(Request $request)
    {
        $user = Auth::user();
        $id = $request->id;
        $window = AuctionWindows::findOrFail($id);
        $window->start = $request->start;
        $window->end = $request->end;
        $update = $window->save();
        //
        if ($update) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Update Auction Window';
            $activity->activity = $user->email . ' updated an auction window.';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            return redirect()->back()->with('success', "Auction Windows updated.");
        }
    }
    //
    public function deleteWindow(Request $request)
    {
        $user = Auth::user();
        $id = $request->id;
        $window = AuctionWindows::findOrFail($id);
        $delete = $window->delete();
        //
        if ($delete) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Delete Auction Window';
            $activity->activity = $user->email . ' deleted an auction window .';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            return redirect()->back()->with('success', "Auction Window deleted.");
        }
    }

    //
    public function executeCommands()
    {
        // Execute the desired commands using Artisan and exec
        // Artisan::call('migrate');
        // Artisan::call('db:seed');
        // Artisan::call('queue:restart');
        Artisan::call('optimize:clear');
        Artisan::call('view:clear');
        Artisan::call('config:cache');
        Artisan::call('config:clear');

        return redirect()->route('login')->with('success', "Command Executed Successfully.");
    }
}
