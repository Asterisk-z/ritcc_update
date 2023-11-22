<?php

namespace App\Http\Controllers\FMDQ;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Institution;
use App\Models\InstitutionTemp;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstitutionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $page = 'All Institutions';
        $institutions = Institution::orderBy('CreatedDate', 'ASC')->get();
        $all = Institution::count();
        $approved = Institution::where('status', '1')->count();
        $pending = Institution::where('status', '0')->orWhere('status', '3')->orWhere('status', '4')->count();
        $rejected = Institution::where('status', '2')->count();
        $authorisers = Profile::where('status', '1')->where(function ($query) {
            $query->where('Package', '3')->orWhere('Package', '5');
        })->get();

        return view('fmdq.institution.index', compact('user', 'institutions', 'all', 'pending', 'approved', 'rejected', 'page', 'authorisers'));
    }

    //
    public function pending()
    {
        $user = Auth::user();
        $page = 'All Institutions';
        $institutions = Institution::where('status', '0')->orWhere('status', '3')->orWhere('status', '4')->orderBy('CreatedDate', 'ASC')->get();
        $all = Institution::count();
        $approved = Institution::where('status', '1')->count();
        $pending = Institution::where('status', '0')->orWhere('status', '3')->orWhere('status', '4')->count();
        $rejected = Institution::where('status', '2')->count();
        $authorisers = Profile::where('status', '1')->where(function ($query) {
            $query->where('Package', '3')->orWhere('Package', '5');
        })->get();

        return view('fmdq.institution.pending', compact('user', 'institutions', 'all', 'pending', 'approved', 'rejected', 'page', 'authorisers'));
    }

    //
    public function rejected()
    {
        $user = Auth::user();
        $page = 'All Institutions';
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
        $page = 'All Institutions';
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
            'code' => 'bail|required|unique:tblInstitution',
            // 'InstitutionName' => 'bail|required|unique:tblInstitution',
            'institutionEmail' => 'bail|required|email|unique:tblInstitution',
            'chiefDealerEmail' => 'bail|required|email|unique:tblInstitution',
        ], [
            // 'end.after_or_equal' => 'The end date must not be before the start date.',
        ]);

        if ($validated) {
            $code = $request->input('code');
            $name = $request->input('name');
            $address = $request->input('address');
            $institutionEmail = $request->input('institutionEmail');
            $chiefDealerEmail = $request->input('chiefDealerEmail');
            $authoriser = $request->input('authoriser');
            $inputter = $user->email;
            // You can now proceed with saving the other form data to your database or perform any other actions
            $institutions = new Institution();
            $institutions->code = $code;
            $institutions->institutionName = $name;
            $institutions->address = $address;
            $institutions->institutionEmail = $institutionEmail;
            $institutions->chiefDealerEmail = $chiefDealerEmail;
            $institutions->createdBy = $inputter;
            $institutions->approvedBy = $authoriser;
            $institutions->status = 0;
            $institutions->createdDate = now();
            $create = $institutions->save();
            if ($create) {
                // log activity
                $activity = new ActivityLog();
                $activity->date = now();
                $activity->app = 'RITCC';
                $activity->type = 'Create Institution';
                $activity->activity = $user->email . ' created institution: ' . $name . ' for approval.';
                $activity->username = $user->email;
                $log = $activity->save();
            }
            if ($log) {
                // // mail
                // $approver = Profile::where('email', $authoriser)->first();
                // $new = ([
                //     'name' => $approver->FirstName,
                // ]);
                // Mail::to($authoriser)->send(new CreateInstitutionMail($new));

                return redirect()->back()->with('success', "Institution has been sent for approval.");
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
        //
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
            //

            // You can now proceed with saving the other form data to your database or perform any other actions
            $institutions = new InstitutionTemp();
            $institutions->institutionRef = $previous->ID;
            $institutions->code = $code;
            $institutions->name = $name;
            $institutions->address = $address;
            $institutions->email = $institutionEmail;
            $institutions->chiefDealerEmail = $chiefDealerEmail;
            $institutions->createdBy = $inputter;
            // $institutions->approvedBy = $authoriser;
            $institutions->status = 3;
            // $institutions->createdDate = now();
            $create = $institutions->save();
            if ($create) {
                //
                $previous = Institution::findOrFail($id);
                $updateStatus = Institution::where('ID', $id)->update(['status' => 3]);
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
        $updateStatus = Institution::where('ID', $id)->update(['status' => 4]);
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
    //
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
