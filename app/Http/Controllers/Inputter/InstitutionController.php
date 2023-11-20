<?php

namespace App\Http\Controllers\Inputter;

use App\Http\Controllers\Controller;
use App\Mail\Authoriser\CreateInstitutionMail;
use App\Models\ActivityLog;
use App\Models\Institution;
use App\Models\InstitutionTemp;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InstitutionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    //
    public function institutionsIndex()
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

        return view('inputter.institution', compact('user', 'institutions', 'all', 'pending', 'approved', 'rejected', 'page', 'authorisers'));
    }

    //
    public function createInstitution(Request $request)
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
                // mail
                $approver = Profile::where('email', $authoriser)->first();
                $new = ([
                    'name' => $approver->FirstName,
                ]);
                Mail::to($authoriser)->send(new CreateInstitutionMail($new));

                return redirect()->back()->with('success', "Institution has been sent for approval.");
            }
            // Redirect or display a success message
        } else {
            // If there are validation errors, you can return to the form with the errors
            return back()->withErrors($validated);
        }
    }
    //
    public function updateInstitution(Request $request, $id)
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
            $previous = Institution::findOrFail($id);
            $institutions = new InstitutionTemp();
            $institutions->code = $code;
            $institutions->institutionName = $name;
            $institutions->address = $address;
            $institutions->institutionEmail = $institutionEmail;
            $institutions->chiefDealerEmail = $chiefDealerEmail;
            $institutions->createdBy = $inputter;
            // $institutions->approvedBy = $authoriser;
            $institutions->status = 0;
            $institutions->createdDate = now();
            $create = $institutions->save();
            if ($create) {
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
                $approver = Profile::where('email', $authoriser)->first();
                $new = ([
                    'name' => $approver->FirstName,
                ]);
                Mail::to($authoriser)->send(new CreateInstitutionMail($new));

                return redirect()->back()->with('success', "Institution has been sent for approval.");
            }
            // Redirect or display a success message
        } else {
            // If there are validation errors, you can return to the form with the errors
            return back()->withErrors($validated);
        }
    }
}
