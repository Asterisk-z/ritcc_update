<?php

namespace App\Http\Controllers\FMDQ;

use App\Helpers\MailContents;
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
use App\Notifications\InfoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

use function PHPUnit\Framework\assertNotTrue;

class ProfileController extends Controller
{
    // all profiles
    public function index()
    {
        $user = Auth::user();
        $profiles = Profile::orderBy('inputDate', 'ASC')->with('package', 'institution')->get();
        $all = Profile::count();
        $approved = Profile::where('status', '1')->count();
        $pending = Profile::where('status', '0')->orWhere('updateFlag', '0')->orWhere('deleteFlag', '0')->count();
        $rejected = Profile::where('status', '2')->count();
        $authorisers = Profile::where('status', '1')->where('package', '3')->get();
        $packages = Package::all();
        $institutions = Institution::where('status', '1')->get();
        return view('fmdq.profile.index', compact('user', 'profiles', 'all', 'pending', 'approved', 'rejected', 'authorisers', 'packages', 'institutions'));
    }

    // pending profiles
    public function pending()
    {
        $user = Auth::user();
        $page = 'Pending Profiles';
        $profiles = Profile::where('status', '0')->orWhere('deleteFlag', '0')->orWhere('updateFlag', '0')->orderBy('inputDate', 'ASC')->get();
        $all = Profile::count();
        $approved = Profile::where('status', '1')->count();
        $pending = Profile::where('status', '0')->orWhere('updateFlag', '0')->orWhere('deleteFlag', '0')->count();
        $rejected = Profile::where('status', '2')->count();
        $authorisers = Profile::where('status', '1')->where('package', '3')->get();
        $packages = Package::get();
        $institutions = Institution::where('status', '1')->get();
        return view('fmdq.profile.pending', compact('user', 'profiles', 'all', 'pending', 'approved', 'rejected', 'page', 'authorisers', 'packages', 'institutions'));
    }

    // rejected profiles
    public function rejected()
    {
        $user = Auth::user();
        $page = 'Rejected Profiles';
        $profiles = Profile::where('status', '2')->orderBy('inputDate', 'ASC')->get();
        $all = Profile::count();
        $approved = Profile::where('status', '1')->count();
        $pending = Profile::where('status', '0')->orWhere('updateFlag', '0')->orWhere('deleteFlag', '0')->count();
        $rejected = Profile::where('status', '2')->count();
        $authorisers = Profile::where('status', '1')->where(function ($query) {
            $query->where('Package', '3')->orWhere('Package', '5');
        })->get();
        $packages = Package::all();
        $institutions = Institution::where('status', '1')->get();
        return view('fmdq.profile.rejected', compact('user', 'profiles', 'all', 'pending', 'approved', 'rejected', 'page', 'authorisers', 'packages', 'institutions'));
    }

    // approved profiles
    public function approved()
    {
        $user = Auth::user();
        $page = 'Approved Profiles';
        $profiles = Profile::where('status', '1')->orderBy('inputDate', 'ASC')->get();
        $all = Profile::count();
        $approved = Profile::where('status', '1')->count();
        $pending = Profile::where('status', '0')->orWhere('updateFlag', '0')->orWhere('deleteFlag', '0')->count();
        $rejected = Profile::where('status', '2')->count();
        $authorisers = Profile::where('status', '1')->where(function ($query) {
            $query->where('Package', '3')->orWhere('Package', '5');
        })->get();
        $packages = Package::all();
        $institutions = Institution::where('status', '1')->get();
        return view('fmdq.profile.approved', compact('user', 'profiles', 'all', 'pending', 'approved', 'rejected', 'page', 'authorisers', 'packages', 'institutions'));
    }

    // create profile
    public function create(Request $request)
    {
        $user = Auth::user();
        //
        $validated = $request->validate([
            'email' => 'bail|required|email|unique:tblProfile',
            // 'fmdqNumber' => 'nullable|integer|min:1|unique:tblProfile',
            // 'rtgsNumber' => 'nullable|integer|min:1|unique:tblProfile',
            'fmdqNumber' => 'nullable|integer|min:1|required_if:user_type,bidder,auctioneer|unique:tblProfile',
            'rtgsNumber' => 'nullable|integer|min:1|required_if:user_type,bidder,auctioneer|unique:tblProfile',
            'mobile' => 'bail|required|unique:tblProfile|integer|min:1',
        ]);

        if ($validated) {
            $email = $request->input('email');
            $package = $request->input('package');
            $firstName = $request->input('firstName');
            $lastName = $request->input('lastName');
            $institution = $request->input('institution');
            $mobile = $request->input('mobile');
            $inputter = $user->email;
            $fmdqNumber = $request->input('FMDQ');
            $rtgsNumber = $request->input('RTGS');
            $authoriser = $request->input('authoriser');
            // validate account numbers
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
            $profile->mobile = $mobile;
            $profile->authoriser = $authoriser;
            $profile->status = $status;
            $profile->passwordStatus = $passwordStatus;
            $profile->type = $type;
            $profile->fmdqNumber = $fmdqNumber;
            $profile->rtgsNumber = $rtgsNumber;
            $profile->inputDate = now();
            $create = $profile->save();
            if ($create) {
                // log activity
                $logMessage = $user->email . ' created a new profile : ' . $request->firstName . ' ' . $request->lastName;
                logAction($user->email, 'Create Profile', $logMessage, $request->ip());
                // mail
                $approver = Profile::where('email', $authoriser)->first();
                $institutionName = Institution::where('ID', $institution)->first('institutionName');
                $packageName = Package::where('ID', $package)->first('Name');
                $profileName = $firstName . ' ' . $lastName;
                Notification::send(
                    $approver,
                    new InfoNotification(MailContents::createProfileMessage($profileName, $institutionName->institutionName, $packageName->Name), MailContents::createProfileSubject())
                );
                //
                return redirect()->back()->with('success', "Profile has been sent for approval.");
            }
        } else {
            // If there are validation errors, you can return to the form with the errors
            return back()->withErrors($validated);
        }
    }

    // edit profile
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        //
        $validated = $request->validate([
            'email' => 'bail|required|email',
            // 'fmdqNumber' => 'nullable|integer|min:1|unique:tblProfile',
            // 'rtgsNumber' => 'nullable|integer|min:1|unique:tblProfile',
            'profileRef' => 'unique:tblProfileTemp',
            'fmdqNumber' => 'nullable|integer|min:1|required_if:user_type,bidder,auctioneer|unique:tblProfile',
            'rtgsNumber' => 'nullable|integer|min:1|required_if:user_type,bidder,auctioneer|unique:tblProfile',
            'mobile' => 'bail|required|integer|min:1',
        ]);

        if ($validated) {
            $email = $request->input('email');
            $package = $request->input('package');
            $firstName = $request->input('firstName');
            $lastName = $request->input('lastName');
            $institution = $request->input('institution');
            $mobile = $request->input('mobile');
            $fmdqNumber = $request->input('FMDQ');
            $rtgsNumber = $request->input('RTGS');
            $authoriser = $request->input('authoriser');
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
            //
            $profile = Profile::find($id);
            // update status
            $updateStatus = Profile::where('id', $id)->update(['updateFlag' => 0, 'updateRequestedBy' => auth()->user()->email]);
            //    move information to Profile Temp
            if ($updateStatus) {
                $temp = new ProfileTemp();
                $temp->profileRef = $profile->id;
                $temp->email = $email;
                $temp->firstName = $firstName;
                $temp->lastName = $lastName;
                $temp->package = $package;
                $temp->institution = $institution;
                $temp->mobile = $mobile;
                $temp->type = $type;
                $temp->fmdqNumber = $fmdqNumber;
                $temp->rtgsNumber = $rtgsNumber;
                $temp->createdBy = auth()->user()->email;
                $temp->createdDate = now();
                $create = $temp->save();
            }

            if ($create) {
                // log activity
                $logMessage = $user->email . ' edited profile : ' . $profile->firstName . ' ' . $profile->lastName;
                logAction($user->email, 'Update Profile', $logMessage, $request->ip());
                // mail
                $approver = Profile::where('email', $authoriser)->first();
                Notification::send(
                    $approver,
                    new InfoNotification(MailContents::updateProfileMessage(), MailContents::updateProfileSubject())
                );
                //
                return redirect()->back()->with('success', "Profile update has been sent for approval.");
            }
        } else {
            // If there are validation errors, you can return to the form with the errors
            return back()->withErrors($validated);
        }
    }

    // deactivate profile
    public function deactivateProfile(Request $request, $id)
    {
        $user = Auth::user();
        //
        $profile = Profile::find($id);
        $reason = $request->reason;
        $updateStatus = Profile::where('id', $id)->update(['deleteFlag' => '0', 'deactivateReason' => $reason, 'deactivateRequestedBy' => $user->email, 'deactivatedRequestDate' => now()]);
        if ($updateStatus) {
            // log activity
            $logMessage = $user->email . ' deactivated profile: ' . $profile->firstName . ' ' . $profile->lastName . ' and sent it for approval.';
            logAction($user->email, 'Deactivate Profile', $logMessage, $request->ip());
            // mail
            $approver = Profile::where('email', $request->authoriser)->first();
            $institutionName = Institution::where('ID', $profile->Institution)->first('institutionName');
            $packageName = Package::where('ID', $profile->Package)->first('Name');
            $profileName = $profile->firstName . ' ' . $profile->lastName;

            Notification::send(
                $approver,
                new InfoNotification(MailContents::deactivateProfileMessage($profileName, $institutionName->institutionName, $packageName->Name, $reason), MailContents::deactivateProfileSubject())
            );
            //
            return redirect()->back()->with('success', "Profile has been sent for deactivation.");
        }
    }

    // approve create
    public function approveCreate($id)
    {
        $user = Auth::user();
        // default password
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@$&()_';
        $uniqueString = substr(str_shuffle($characters), 0, 8);
        $defaultPassword = Hash::make($uniqueString);
        //
        $profile = Profile::find($id);
        // $approver = Profile::where('email', $authoriser)->first();
        $approveCreate = Profile::where('id', $id)->update(['status' => 1, 'defaultPassword' => $defaultPassword, 'password' => $defaultPassword, 'passwordStatus' => false, 'authoriserDate' => now(), 'authoriser' => $user->email]);
        //
        if ($approveCreate) {
            // log activity
            $profileEmail = Profile::where('email', $profile->email)->first();
            $logMessage = $user->email . ' approved new profile:  ' . $profile->firstName . ' ' . $profile->lastName;
            logAction($user->email, 'Approve New Profile', $logMessage);
            //
            Notification::send(
                $profileEmail,
                new InfoNotification(MailContents::approveProfileCreateMessage($profile->email, $uniqueString), MailContents::approveProfileCreateSubject())
            );
            //
            return redirect()->back()->with('success', "New Profile has been approved.");
        }
    }

    // reject create
    public function rejectCreate(Request $request, $id)
    {
        $user = Auth::user();
        //
        $profile = Profile::find($id);
        $inputter = Profile::where('email', $profile->inputter)->first();
        $reason = $request->reason;
        $rejectCreate = Profile::where('id', $id)->update(['status' => 2, 'rejectReason' => $reason, 'authoriser' => $user->email, 'authoriserDate' => now()]);
        if ($rejectCreate) {
            // log activity
            $logMessage = $user->email . ' rejected a new profile: ' . $profile->firstName . ' ' . $profile->lastName;
            logAction($user->email, 'Reject New Profile', $logMessage);
            //
            $inputterEmail = Profile::where('email', $profile->email)->first();
            $institutionName = Institution::where('ID', $profile->Institution)->first('institutionName');
            $packageName = Package::where('ID', $profile->Package)->first('Name');
            $profileName = $profile->firstName . ' ' . $profile->lastName;
            Notification::send(
                $inputter,
                new InfoNotification(MailContents::rejectProfileCreateMessage($profileName, $institutionName->institutionName, $packageName->Name, $reason), MailContents::rejectProfileCreateSubject())
            );
            return redirect()->back()->with('success', "New Profile has been rejected.");
        }
    }

    // approve update
    public function approveUpdate($id)
    {
        $user = Auth::user();
        $profile = Profile::find($id);
        $temp = ProfileTemp::where('profileRef', $id)->first();
        $approveUpdate = Profile::where('id', $id)->update(['firstName' => $temp->firstName, 'lastName' => $temp->lastName, 'email' => $temp->email, 'Package' => $temp->package, 'Institution' => $temp->institution, 'updateFlag' => '1', 'updateRequestedBy' => $temp->createdBy, 'updateApprovedBy' => auth()->user()->email, 'updatedApprovedDate' => now()]);
        //
        if ($approveUpdate) {
            // delete data from profile temp
            $temp->delete();
            // inputter email
            $profileEmail = Profile::where('email', $profile->updateRequestedBy)->first();
            // log activity
            $logMessage = $user->email . ' approved update for profile.';
            logAction($user->email, 'Approve Profile Updated', $logMessage);
            //
            Notification::send(
                $profileEmail,
                new InfoNotification(MailContents::approveProfileUpdateMessage(), MailContents::approveProfileUpdateSubject())
            );
            return redirect()->back()->with('success', "Profile update has been approved");
        }
    }

    // reject update
    public function rejectUpdate(Request $request, $id)
    {
        $user = Auth::user();
        $profile = Profile::find($id);
        $temp = ProfileTemp::where('profileRef', $id)->first();
        $reason = $request->reason;
        $rejectUpdate = Profile::where('id', $id)->update(['updateFlag' => '1', 'updateRejectReason' => $reason, 'updateRejectedBy' => $user->email, 'updateRejectedDate' => now()]);

        if ($rejectUpdate) {
            // delete data from profile temp
            $temp->delete();
            // log activity
            $logMessage = $user->email . ' rejected update for profile.';
            logAction($user->email, 'Reject Profile Rejected', $logMessage);
            //
            $inputterEmail = Profile::where('email', $profile->email)->get();
            Notification::send(
                $inputterEmail,
                new InfoNotification(MailContents::rejectProfileUpdateMessage($reason), MailContents::rejectProfileUpdateSubject())
            );
            return redirect()->back()->with('success', "Profile update has been rejected.");
        }
    }

    // approve delete
    public function approveDelete($id)
    {
        $user = Auth::user();
        //
        $profile = Profile::find($id);
        $temp = ProfileTemp::where('profileRef', $id)->first();
        $updateStatus = Profile::where('id', $id)->update(['deleteFlag' => '1', 'deactivateApprovedBy' => auth()->user()->email, 'deactivateApprovedDate' => now()]);
        //
        if ($updateStatus) {
            $temp = new ProfileTemp();
            $temp->profileRef = $profile->id;
            $temp->email = $profile->email;
            $temp->firstName = $profile->firstName;
            $temp->lastName = $profile->lastName;
            $temp->package = $profile->package;
            $temp->institution = $profile->institution;
            $temp->mobile = $profile->mobile;
            $temp->type = $profile->type;
            $temp->fmdqNumber = $profile->fmdqNumber;
            $temp->rtgsNumber = $profile->rtgsNumber;
            $temp->createdBy = auth()->user()->email;
            $temp->createdDate = now();
            $approveDelete = $temp->save();
        }

        //
        if ($approveDelete) {
            $delete = Profile::where('id', $id)->delete();
        }

        if ($delete) {
            // log activity
            $logMessage = $user->email . ' approved deactivated for profile.';
            logAction($user->email, 'Approve Deactivate for Institution', $logMessage);
            // notification
            $inputter = Profile::where('email', $profile->updateRequestedBy)->get();
            Notification::send(
                $inputter,
                new InfoNotification(MailContents::approveProfileDeleteMessage(), MailContents::approveProfileDeleteSubject())
            );
            //
            return redirect()->back()->with('success', "Profile deactivate has been approved");
        }
    }

    // reject deactivate
    public function rejectDeactivate(Request $request, $id)
    {
        $user = Auth::user();
        $profile = Profile::find($id);
        $reason = $request->reason;
        $rejectUpdate = Profile::where('id', $id)->update(['deleteFlag' => '1', 'deactivateRejectReason' => $reason, 'deactivateApprovedBy' => $user->email, 'deactivateApprovedDate' => now()]);

        if ($rejectUpdate) {
            // log activity
            $logMessage = $user->email . ' rejected deactivation for profile.';
            logAction($user->email, 'Reject Profile Deactivation', $logMessage);
            //
            $inputterEmail = Profile::where('deactivateRequestedBy', $profile->email)->get();
            Notification::send(
                $inputterEmail,
                new InfoNotification(MailContents::rejectProfileDeleteMessage($reason), MailContents::rejectProfileDeleteSubject())
            );
            return redirect()->back()->with('success', "Profile deactivation has been rejected");
        }
    }
}
