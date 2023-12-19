<?php

namespace App\Http\Controllers\FMDQ;

use App\Http\Controllers\Controller;
use App\Mail\FMDQ\ApprovedMail;
use App\Mail\FMDQ\CreateMail;
use App\Mail\FMDQ\DeleteMail;
use App\Mail\FMDQ\RejectedMail;
use App\Models\ActivityLog;
use App\Models\Institution;
use App\Models\Package;
use App\Models\Profile;
use App\Models\ProfileTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use function PHPUnit\Framework\assertNotTrue;

class ProfileController extends Controller
{
    //
    // public function __construct()
    // {
    //     $this->middleware(['auth']);
    // }

    //
    public function index()
    {
        $user = Auth::user();
        $profiles = Profile::orderBy('inputDate', 'ASC')->with('package', 'institution')->get();
        $all = Profile::count();
        $approved = Profile::where('status', '1')->count();
        $pending = Profile::where('status', '0')->orWhere('status', '3')->orWhere('status', '4')->count();
        $rejected = Profile::where('status', '2')->count();
        $authorisers = Profile::where('status', '1')->where(function ($query) {
            $query->where('Package', '3')->orWhere('Package', '5');
        })->get();
        $packages = Package::all();
        $institutions = Institution::where('status', '1')->get();

        // dd($uniqueString);
        return view('fmdq.profile.index', compact('user', 'profiles', 'all', 'pending', 'approved', 'rejected', 'authorisers', 'packages', 'institutions'));
    }
    //
    public function pending()
    {
        $user = Auth::user();
        $page = 'Pending Institutions';
        $profiles = Profile::where('status', '0')->orWhere('status', '4')->orderBy('inputDate', 'ASC')->get();
        $all = Profile::count();
        $approved = Profile::where('status', '1')->count();
        $pending = Profile::where('status', '0')->orWhere('status', '4')->count();
        $rejected = Profile::where('status', '2')->count();
        $authorisers = Profile::where('status', '1')->where(function ($query) {
            $query->where('Package', '3')->orWhere('Package', '5');
        })->get();
        $packages = Package::all();
        $institutions = Institution::where('status', '1')->get();
        return view('fmdq.profile.pending', compact('user', 'profiles', 'all', 'pending', 'approved', 'rejected', 'page', 'authorisers', 'packages', 'institutions'));
    }

    //
    public function rejected()
    {
        $user = Auth::user();
        $page = 'Rejected Profiles';
        $profiles = Profile::where('status', '2')->orderBy('inputDate', 'ASC')->get();
        $all = Profile::count();
        $approved = Profile::where('status', '1')->count();
        $pending = Profile::where('status', '0')->orWhere('status', '3')->orWhere('status', '4')->count();
        $rejected = Profile::where('status', '2')->count();
        $authorisers = Profile::where('status', '1')->where(function ($query) {
            $query->where('Package', '3')->orWhere('Package', '5');
        })->get();
        $packages = Package::all();
        $institutions = Institution::where('status', '1')->get();
        return view('fmdq.profile.rejected', compact('user', 'profiles', 'all', 'pending', 'approved', 'rejected', 'page', 'authorisers', 'packages', 'institutions'));
    }

    public function approved()
    {
        $user = Auth::user();
        $page = 'Approved Profiles';
        $profiles = Profile::where('status', '1')->orderBy('inputDate', 'ASC')->get();
        $all = Profile::count();
        $approved = Profile::where('status', '1')->count();
        $pending = Profile::where('status', '0')->orWhere('status', '3')->orWhere('status', '4')->count();
        $rejected = Profile::where('status', '2')->count();
        $authorisers = Profile::where('status', '1')->where(function ($query) {
            $query->where('Package', '3')->orWhere('Package', '5');
        })->get();
        $packages = Package::all();
        $institutions = Institution::where('status', '1')->get();
        return view('fmdq.profile.approved', compact('user', 'profiles', 'all', 'pending', 'approved', 'rejected', 'page', 'authorisers', 'packages', 'institutions'));
    }

    // inputter
    public function create(Request $request)
    {
        $user = Auth::user();
        //
        $validated = $request->validate([
            'email' => 'bail|required|email|unique:tblProfile',
        ]);

        if ($validated) {
            $email = $request->input('email');
            $package = $request->input('package');
            $firstName = $request->input('firstName');
            $lastName = $request->input('lastName');
            $institution = $request->input('institution');
            $authoriser = $request->input('authoriser');
            $inputter = $user->email;
            $fmdqNumber = $request->input('FMDQ');
            $rtgsNumber = $request->input('RTGS');
            // default password
            // $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            // $uniqueString = substr(str_shuffle($characters), 0, 7);
            // $defaultPassword = Hash::make($uniqueString);
            // type
            if ($package === '1') {
                $type = 'super';
            } elseif ($package === '2' || $package === '4') {
                $type = 'inputter';
            } elseif ($package === '3' || $package === '5') {
                $type = 'authoriser';
            } elseif ($package === '6') {
                $type = 'firs';
            } elseif ($package === '7' || $package === '9' || $package === '11') {
                $type = 'auctioneer';
            } elseif ($package === '8' || $package === '10' || $package === '12') {
                $type = 'bidder';
            }
            // status
            $status = 0;
            $passwordStatus = 0;
            // You can now proceed with saving the other form data to your database or perform any other actions
            $profile = new Profile();
            $profile->email = $email;
            $profile->Package = $package;
            $profile->firstName = $firstName;
            $profile->lastName = $lastName;
            $profile->institution = $institution;
            $profile->inputter = $inputter;
            // $profile->approvedBy = $authoriser;
            $profile->status = $status;
            $profile->passwordStatus = $passwordStatus;
            // $profile->defaultPassword = $defaultPassword;
            $profile->type = $type;
            $profile->fmdqNumber = $fmdqNumber;
            $profile->rtgsNumber = $rtgsNumber;
            $profile->inputDate = now();
            $create = $profile->save();
            if ($create) {
                // log activity
                $activity = new ActivityLog();
                $activity->date = now();
                $activity->app = 'RITCC';
                $activity->type = 'Create Profile';
                $activity->activity = $user->email . ' created a profile named: ' . $firstName . ' ' . $lastName . ' for approval.';
                $activity->username = $user->email;
                $log = $activity->save();
            }
            if ($log) {
                // mail
                $approver = Profile::where('email', $authoriser)->first();
                $create = ([
                    'name' => $approver->firstName,
                    'type' => 'profile',
                    // 'profileName' => $firstName . ' ' . $lastName,
                ]);
                Mail::to($authoriser)->send(new CreateMail($create));
                return redirect()->back()->with('success', "Profile has been sent for approval.");
            }
            // Redirect or display a success message
        } else {
            // If there are validation errors, you can return to the form with the errors
            return back()->withErrors($validated);
        }
    }

    //
    public function deactivateProfile(Request $request, $id)
    {
        $user = Auth::user();
        //
        $profile = Profile::findOrFail($id);
        $updateStatus = Profile::where('id', $id)->update(['status' => 4, 'deactivateReason' => $request->reason, 'deactivateRequestedBy' => $user->email, 'deactivatedRequestDate' => now()]);
        if ($updateStatus) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Request to Deactivate Profile';
            $activity->activity = $user->email . ' made a request to deactivate profile: ' . $profile->firstName . ' ' . $profile->lastName . ' and sent it for approval.';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            // mail
            $authoriser = Profile::where('email', $request->authoriser)->first();
            $delete = ([
                'authoriser' => $authoriser->firstName,
                'type' => 'profile',
                'reason' => $request->reason,
                'profile' => $profile->firstName . ' ' . $profile->lastName,

            ]);

            Mail::to($authoriser->email)->send(new DeleteMail($delete));

            return redirect()->back()->with('success', "Profile has been sent for deactivation.");
        }
    }

    // approve create
    public function approveCreate($id)
    {
        $user = Auth::user();
        // default password
        $characters = '!@#$%^&*0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $uniqueString = substr(str_shuffle($characters), 0, 8);
        $defaultPassword = Hash::make($uniqueString);
        //
        $profile = Profile::findOrFail($id);
        // $approver = Profile::where('email', $authoriser)->first();
        $approveCreate = Profile::where('id', $id)->update(['status' => 1, 'defaultPassword' => $defaultPassword, 'password' => $defaultPassword, 'passwordStatus' => false, 'authoriserDate' => now(), 'authoriser' => $user->email]);
        //
        if ($approveCreate) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Approve New Profile';
            $activity->activity = $user->email . ' approved a new profile: ' . $profile->firstName . ' ' . $profile->lastName . '.';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            // mail
            $approved = ([
                'name' => $profile->firstName,
                'type' => 'profile',
                'email' => $profile->email,
                'password' => $uniqueString

            ]);
            Mail::to($profile->email)->send(new ApprovedMail($approved));

            return redirect()->back()->with('success', "New Profile has been approved.");
        }
    }

    // reject create
    public function rejectCreate(Request $request, $id)
    {
        $user = Auth::user();
        //
        $profile = Profile::findOrFail($id);
        $rejectCreate = Profile::where('id', $id)->update(['status' => 2, 'rejectReason' => $request->reason, 'authoriser' => $user->email, 'authoriserDate' => now()]);
        if ($rejectCreate) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Reject New Profile';
            $activity->activity = $user->email . ' rejected a new profile: ' . $profile->firstName . ' ' . $profile->lastName . '.';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            $inputter = Profile::where('email', $profile->inputter)->first();
            // mail
            $rejected = ([
                'name' => $inputter->firstName,
                'type' => 'reject_create_profile',
                'reason' => $request->reason

            ]);
            Mail::to($profile->inputter)->send(new RejectedMail($rejected));
            return redirect()->back()->with('success', "New Profile has been rejected.");
        }
    }

    // approve delete
    public function approveDelete($id)
    {
        $user = Auth::user();
        //
        $profile = Profile::findOrFail($id);
        //
        $dump = new ProfileTemp();
        $dump->firstName = $profile->firstName;
        $dump->lastName = $profile->lastName;
        $dump->email = $profile->email;
        $dump->institution = $profile->institution;
        $dump->mobile = $profile->mobile;
        $dump->package = $profile->Package;
        $dump->institution = $profile->Institution;
        $dump->password = $profile->password;
        $dump->reason = $profile->deactivatingReason;
        $dump->createdBy = $profile->inputter;
        $dump->createdDate = $profile->inputDate;
        $dump->approvedBy = $profile->authoriser;
        $dump->approvedDate = $profile->authoriserDate;
        $dump->deleteRequestedBy = $profile->deactivateRequestedBy;
        $dump->deleteApprovedBy = $user->email;
        $dump->deleteApprovedDate = now();
        $dump->profileRef = $profile->id;
        $approveDelete = $dump->save();
        //
        if ($approveDelete) {
            $delete = Profile::where('id', $id)->delete();
        }
        //
        if ($delete) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Approve Delete for Profile';
            $activity->activity = $user->email . ' approved delete for profile: ' . $dump->firstName . ' ' . $dump->lastName . '.';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            // mail
            $inputter = Profile::where('email', $dump->deleteRequestedBy)->first();
            $delete = ([
                'inputter' => $inputter->firstName,
                'name' => $dump->firstName . ' ' . $dump->lastName,
                'type' => 'approve_delete',
            ]);
            Mail::to($user->email)->send(new DeleteMail($delete));

            return redirect()->back()->with('success', "Profile delete has been approved.");
        }
    }

    // reject delete
    public function rejectDelete(Request $request, $id)
    {
        $user = Auth::user();
        //
        $profile = Profile::findOrFail($id);
        $rejectDelete = Profile::where('id', $id)->update(['status' => 1, 'deactivatedRejectReason' => $request->reason, 'deactivateApprovedBy' => $user->email, 'deactivateApprovedDate' => now()]);
        if ($rejectDelete) {
            // log activity2
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Reject Delete for Profile';
            $activity->activity = $user->email . ' rejected approval to delete profile: ' . $profile->firstName . ' ' . $profile->lastName . '.';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            // Mail
            $inputter = Profile::where('email', $profile->modifiedBy)->first();
            $rejected = ([
                'name' => $inputter->firstName,
                'type' => 'rejected_delete',
                'reason' => $request->reason

            ]);
            Mail::to($profile->modifiedBy)->send(new RejectedMail($rejected));

            return redirect()->back()->with('success', "Profile delete has been rejected.");
        }
    }
}
