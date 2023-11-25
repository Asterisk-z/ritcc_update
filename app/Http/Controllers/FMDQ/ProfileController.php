<?php

namespace App\Http\Controllers\FMDQ;

use App\Http\Controllers\Controller;
use App\Mail\FMDQ\CreateMail;
use App\Models\ActivityLog;
use App\Models\Institution;
use App\Models\Package;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
        $institutions = Institution::where('status', '0')->orWhere('status', '3')->orWhere('status', '4')->orderBy('CreatedDate', 'ASC')->get();
        $institutionIds = $institutions->pluck('ID'); // Extract IDs from $institutions
        $institutionTempRecords = InstitutionTemp::whereIn('institutionRef', $institutionIds)
            ->get();
        $all = Institution::count();
        $approved = Institution::where('status', '1')->count();
        $pending = Institution::where('status', '0')->orWhere('status', '3')->orWhere('status', '4')->count();
        $rejected = Institution::where('status', '2')->count();
        $authorisers = Profile::where('status', '1')->where(function ($query) {
            $query->where('Package', '3')->orWhere('Package', '5');
        })->get();

        return view('fmdq.institution.pending', compact('user', 'institutions', 'all', 'pending', 'approved', 'rejected', 'page', 'authorisers', 'institutionIds', 'institutionTempRecords'));
    }

    //
    public function rejected()
    {
        $user = Auth::user();
        $page = 'Rejected Institutions';
        $institutions = Institution::where('status', '2')->orderBy('CreatedDate', 'ASC')->get();
        $all = Institution::count();
        $approved = Institution::where('status', '1')->count();
        $pending = Institution::where('status', '0')->orWhere('status', '3')->orWhere('status', '4')->count();
        $rejected = Institution::where('status', '2')->count();
        $authorisers = Profile::where('status', '1')->where(function ($query) {
            $query->where('Package', '3')->orWhere('Package', '5');
        })->get();

        return view('fmdq.institution.rejected', compact('user', 'institutions', 'all', 'pending', 'approved', 'rejected', 'page', 'authorisers'));
    }

    public function approved()
    {
        $user = Auth::user();
        $page = 'Approved Institutions';
        $institutions = Institution::where('status', '1')->orderBy('CreatedDate', 'ASC')->get();
        $all = Institution::count();
        $approved = Institution::where('status', '1')->count();
        $pending = Institution::where('status', '0')->orWhere('status', '3')->orWhere('status', '4')->count();
        $rejected = Institution::where('status', '2')->count();
        $authorisers = Profile::where('status', '1')->where(function ($query) {
            $query->where('Package', '3')->orWhere('Package', '5');
        })->get();

        return view('fmdq.institution.approved', compact('user', 'institutions', 'all', 'pending', 'approved', 'rejected', 'page', 'authorisers'));
    }

    // inputter
    public function create(Request $request)
    {
        $user = Auth::user();
        //
        $validated = $request->validate([
            'email' => 'bail|required|email|unique:tblProfile',
        ], [
            // 'end.after_or_equal' => 'The end date must not be before the start date.',
        ]);

        if ($validated) {
            $email = $request->input('email');
            $package = $request->input('package');
            $firstName = $request->input('firstName');
            $lastName = $request->input('lastName');
            $institution = $request->input('institution');
            $authoriser = $request->input('authoriser');
            $inputter = $user->email;
            // default password
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $uniqueString = substr(str_shuffle($characters), 0, 7);
            $defaultPassword = Hash::make($uniqueString);
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
            $profile->defaultPassword = $defaultPassword;
            $profile->type = $type;
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
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        // dd($request->institutionEmail);
        $validated = $request->validate([
            'code' => 'bail|unique:tblInstitutionTemp',
            'email' => 'bail|email|unique:tblInstitutionTemp',
            'chiefDealerEmail' => 'bail|email|unique:tblInstitutionTemp',
        ]);
        $previous = Institution::findOrFail($id);
        // dd($previous);
        if ($validated) {
            $code = $request->code;
            $name = $request->name;
            $address = $request->address;
            $institutionEmail = $request->institutionEmail;
            $chiefDealerEmail = $request->chiefDealerEmail;
            $authoriser = $request->authoriser;
            $inputter = $user->email;
            // You can now proceed with saving the other form data to your database or perform any other actions
            $institutions = new InstitutionTemp();
            $institutions->institutionRef = $previous->ID;
            $institutions->code = $code;
            $institutions->name = $name;
            $institutions->address = $address;
            $institutions->email = $institutionEmail;
            $institutions->chiefDealerEmail = $chiefDealerEmail;
            $institutions->modifyingBy = $inputter;
            $institutions->modifyingDate = now();
            $institutions->status = 3;
            $create = $institutions->save();
            if ($create) {
                //
                $previous = Institution::findOrFail($id);
                $updateStatus = Institution::where(
                    'ID',
                    $id
                )->update(['status' => 3]);
            }
            if ($updateStatus) {
                // log activity
                $activity = new ActivityLog();
                $activity->date = now();
                $activity->app = 'RITCC';
                $activity->type = 'Update Institution';
                $activity->activity = $user->email . ' updated institution: ' . $previous->institutionName . ' and sent it for approval.';
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

                return redirect()->back()->with('success', "Institution update has been sent for approval.");
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
        //
        $previous = Institution::findOrFail($id);
        $approveCreate = Institution::where('ID', $id)->update(['status' => 1, 'approvedDate' => now(), 'approvedBy' => $user->email]);
        if ($approveCreate) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Approve Institution';
            $activity->activity = $user->email . ' approve institution: ' . $previous->institutionName . '.';
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

            return redirect()->back()->with('success', "Institution has been approved.");
        }
    }
    // reject create
    public function rejectCreate(Request $request, $id)
    {
        $user = Auth::user();
        //
        $institution = Institution::findOrFail($id);
        $rejectCreate = Institution::where('ID', $id)->update(['status' => 2, 'reason' => $request->reason, 'approvedBy' => $user->email, 'approvedDate' => now()]);
        if ($rejectCreate) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Reject Institution';
            $activity->activity = $user->email . ' approved institution: ' . $institution->institutionName . '.';
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

            return redirect()->back()->with('success', "Institution has been rejected.");
        }
    }
}
