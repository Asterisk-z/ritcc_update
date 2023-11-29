<?php

namespace App\Http\Controllers\FMDQ;

use App\Http\Controllers\Controller;
use App\Mail\FMDQ\ApprovedMail;
use App\Mail\FMDQ\CreateMail;
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
                    'authoriser' => $approver->firstName,
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
    public function delete(Request $request, $id)
    {
        $user = Auth::user();
        //
        $previous = Institution::findOrFail($id);
        $updateStatus = Institution::where('ID', $id)->update(['status' => 4, 'deletingBy' => $user->email, 'deletingReason' => $request->reason, 'deletingDate' => now()]);
        if ($updateStatus) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Delete Institution';
            $activity->activity = $user->email . ' deleted institution: ' . $previous->institutionName . ' and sent it for approval.';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            // mail
            // $approver = Profile::where('email', $authoriser)->first();
            // $update = ([
            //     'name' => $approver->FirstName,
            //     'type' => 'institution',
            //     'previous' => $previous->institutionName,

            // ]);
            // Mail::to($approver->email)->send(new UpdateMail($update));

            return redirect()->back()->with('success', "Institution delete has been sent for approval.");
        }
    }

    // approve create
    public function approveCreate($id)
    {
        $user = Auth::user();
        // default password
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $uniqueString = substr(str_shuffle($characters), 0, 7);
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
            // mail
            $rejected = ([
                'name' => $user->firstName,
                'type' => 'profile',
                'reason' => $request->reason

            ]);
            Mail::to($profile->inputter)->send(new RejectedMail($rejected));
            return redirect()->back()->with('success', "New Profile has been rejected.");
        }
    }

    // approve delete
    public function approveDelete(Request $request, $id)
    {
        $user = Auth::user();
        //
        $institution = Institution::findOrFail($id);
        $temp = InstitutionTemp::where('institutionRef', $id)->first();

        $institutions = new InstitutionTemp();
        $institutions->institutionRef = $institution->ID;
        $institutions->code = $institution->code;
        $institutions->name = $institution->institutionName;
        $institutions->address = $institution->address;
        $institutions->email = $institution->institutionEmail;
        $institutions->chiefDealerEmail = $institution->chiefDealerEmail;
        $institutions->deletingBy = $user->email;
        $institutions->deletedDate = now();
        $institutions->reason = $request->reason;
        $institutions->status = 3;
        $approveDelete = $institutions->save();
        // $approveUpdate = InstitutionTemp::where('ID', $id)->update(['code' => $temp->code, 'institutionName' => $temp->name, 'address' => $temp->address, 'institutionEmail' => $temp->email, 'chiefDealerEmail' => $temp->chiefDealerEmail, 'status' => 1, 'modifiedDate' => now(), 'modifiedBy' => $user->email]);

        if ($approveDelete) {
            $delete = Institution::where('ID', $id)->delete();
        }

        if ($delete) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Approve Delete for Institution';
            $activity->activity = $user->email . ' approved delete for institution: ' . $institutions->name . '.';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            // mail
            // $approver = Profile::where('email', $authoriser)->first();
            // $update = ([
            //     'name' => $approver->FirstName,
            //     'type' => 'institution',
            //     'previous' => $previous->institutionName,

            // ]);
            // Mail::to($approver->email)->send(new UpdateMail($update));

            return redirect()->back()->with('success', "Institution delete has been approved.");
        }
    }

    // reject delete
    public function rejectDelete(Request $request, $id)
    {
        $user = Auth::user();
        //
        $institution = Institution::findOrFail($id);
        $temp = InstitutionTemp::where('institutionRef', $id)->first();
        $rejectDelete = Institution::where('ID', $id)->update(['status' => 1, 'deleteRejectReason' => $request->reason, 'deleteRejectBy' => $user->email, 'deletedDate' => now()]);
        if ($rejectDelete) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Reject Delete for Institution';
            $activity->activity = $user->email . ' rejected approval to delete institution: ' . $institution->institutionName . '.';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            // mail
            // $approver = Profile::where('email', $authoriser)->first();
            // $update = ([
            //     'name' => $approver->FirstName,
            //     'type' => 'institution',
            //     'previous' => $previous->institutionName,

            // ]);
            // Mail::to($approver->email)->send(new UpdateMail($update));

            return redirect()->back()->with('success', "Institution delete has been rejected.");
        }
    }
}