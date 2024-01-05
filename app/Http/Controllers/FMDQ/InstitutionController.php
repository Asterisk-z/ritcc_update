<?php

namespace App\Http\Controllers\FMDQ;

use App\Helpers\MailContents;
use App\Http\Controllers\Controller;
use App\Mail\FMDQ\ApprovedMail;
use App\Mail\FMDQ\CreateMail;
use App\Mail\FMDQ\DeleteMail;
use App\Mail\FMDQ\RejectedMail;
use App\Mail\FMDQ\UpdateMail;
use App\Models\ActivityLog;
use App\Models\Institution;
use App\Models\InstitutionTemp;
use App\Models\Profile;
use App\Notifications\InfoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

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
            // $authoriser = $request->input('authoriser');
            $inputter = $user->email;
            // You can now proceed with saving the other form data to your database or perform any other actions
            $institutions = new Institution();
            $institutions->code = $code;
            $institutions->institutionName = $name;
            $institutions->address = $address;
            $institutions->institutionEmail = $institutionEmail;
            $institutions->chiefDealerEmail = $chiefDealerEmail;
            $institutions->createdBy = $inputter;
            // $institutions->approvedBy = $request->authoriser;
            $institutions->status = 0;
            $institutions->createdDate = now();
            $create = $institutions->save();

            //
            if ($create) {
                // log activity
                $logMessage = $user->email . ' created institution: ' . $name . ' for approval.';
                logAction($user->email, 'Create Institution', $logMessage);
                //
                $authorisers = Profile::where('type', 'authoriser')->get();

                Notification::send(
                    $authorisers,
                    new InfoNotification(MailContents::createInstitutionMessage(), MailContents::createInstitutionSubject())
                );
                // Redirect or display a success message
                return redirect()->back()->with('success', "Institution has been sent for approval.");
            }
        } else {
            // If there are validation errors, you can return to the form with the errors
            return back()->withErrors($validated);
        }
    }
    //
    public function update(Request $request, $id)
    {
        $user = Auth::user();
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
                $updateStatus = Institution::where('ID', $id)->update(['status' => 3]);
            }
            if ($updateStatus) {
                // log activity
                $logMessage = $user->email . ' updated institution: ' . $previous->institutionName . ' and sent it for approval.';
                logAction($user->email, 'Update Institution', $logMessage);
                // notification
                $authorisers = Profile::where('type', 'authoriser')->get();
                Notification::send(
                    $authorisers,
                    new InfoNotification(MailContents::updateInstitutionMessage(), MailContents::updateInstitutionSubject())
                );
                // Redirect or display a success message
                return redirect()->back()->with('success', "Institution update has been sent for approval.");
            }
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
            $logMessage = $user->email . ' deleted institution: ' . $previous->institutionName . ' and sent it for approval.';
            logAction($user->email, 'Delete Institution', $logMessage);
            // notification
            $authorisers = Profile::where('type', 'authoriser')->first();
            Notification::send(
                $authorisers,
                new InfoNotification(MailContents::deleteInstitutionMessage($request->reason), MailContents::deleteInstitutionSubject())
            );
            //
            return redirect()->back()->with('success', "Institution delete has been sent for approval.");
        }
    }

    // approve create
    public function approveCreate($id)
    {
        $user = Auth::user();
        //
        $institution = Institution::find($id);
        $approveCreate = Institution::where('ID', $id)->update(['status' => 1, 'approvedDate' => now(), 'approvedBy' => $user->email]);
        if ($approveCreate) {
            // log activity
            $logMessage = $user->email . ' approve institution: ' . $institution->institutionName . '.';
            logAction($user->email, 'Approve New Institution', $logMessage);
            // notification
            $inputter = Institution::where('ID', $id)->where('createdBy', $institution->createdBy)->first();
            Notification::send(
                $inputter,
                new InfoNotification(MailContents::approveInstitutionCreateMessage(), MailContents::approveInstitutionCreateSubject())
            );
            // Redirect or display a success message
            return redirect()->back()->with('success', "Institution has been approved.");
        }
    }

    // reject create
    public function rejectCreate(Request $request, $id)
    {
        $user = Auth::user();
        //
        $institution = Institution::findOrFail($id);
        $reason = $request->reason;
        $rejectCreate = Institution::where('ID', $id)->update(['status' => 2, 'reason' => $reason, 'approvedBy' => $user->email, 'approvedDate' => now()]);
        if ($rejectCreate) {
            // log activity
            $logMessage = $user->email . ' rejected a new institution: ' . $institution->institutionName . '.';
            logAction($user->email, 'Reject New Institution', $logMessage);
            // notification
            $inputter = Institution::where('ID', $id)->where('createdBy', $institution->createdBy)->first();
            Notification::send(
                $inputter,
                new InfoNotification(MailContents::rejectInstitutionCreateMessage($reason), MailContents::rejectInstitutionCreateSubject())
            );
            // Redirect or display a success message
            return redirect()->back()->with('success', "Institution has been rejected.");
        }
    }

    // approve update
    public function approveUpdate($id)
    {
        $user = Auth::user();
        //
        $institution = Institution::findOrFail($id);
        $temp = InstitutionTemp::where('institutionRef', $id)->first();
        $approveUpdate = Institution::where('ID', $id)->update(['code' => $temp->code, 'institutionName' => $temp->name, 'address' => $temp->address, 'institutionEmail' => $temp->email, 'chiefDealerEmail' => $temp->chiefDealerEmail, 'status' => 1, 'modifiedDate' => now(), 'modifiedBy' => $user->email]);

        if ($approveUpdate) {
            $deleteTemp = InstitutionTemp::where('institutionRef', $id)->delete();
        }

        if ($deleteTemp) {
            // log activity
            $logMessage = $user->email . ' approved an update for institution: ' . $institution->institutionName . '.';
            logAction($user->email, 'Approve Institution Update', $logMessage);
            // notification
            $inputter = Profile::where('email', $institution->createdBy)->first();
            Notification::send(
                $inputter,
                new InfoNotification(MailContents::approveInstitutionUpdateMessage(), MailContents::approveInstitutionUpdateSubject())
            );
            //
            return redirect()->back()->with('success', "Institution update has been approved.");
        }
    }

    // reject update
    public function rejectUpdate(Request $request, $id)
    {
        $user = Auth::user();
        //
        $institution = Institution::findOrFail($id);
        $temp = InstitutionTemp::where('institutionRef', $id)->first();
        $rejectUpdate = Institution::where('ID', $id)->update(['status' => 1, 'reason' => $request->reason, 'modifyingBy' => $temp->modifyingBy, 'modifiedBy' => $user->email, 'modifiedDate' => now()]);
        if ($rejectUpdate) {
            // log activity
            $logMessage = $user->email . ' rejected updated for institution: ' . $institution->institutionName . '.';
            logAction($user->email, 'Reject Update for Institution', $logMessage);
            // notification
            $inputter = Profile::where('email', $institution->createdBy)->first();
            Notification::send(
                $inputter,
                new InfoNotification(MailContents::rejectInstitutionUpdateMessage($request->reason), MailContents::rejectInstitutionUpdateSubject())
            );
            //
            return redirect()->back()->with('success', "Institution update has been rejected.");
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
            $logMessage = $user->email . ' approved delete for institution: ' . $institutions->name . '.';
            logAction($user->email, 'Approve Delete for Institution', $logMessage);
            // notification
            $inputter = Profile::where('email', $institution->deletingBy)->first();
            Notification::send(
                $inputter,
                new InfoNotification(MailContents::approveInstitutionDeleteMessage($request->reason), MailContents::approveInstitutionDeleteSubject())
            );
            //
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
            $logMessage = $user->email . ' rejected approval to delete institution: ' . $institution->institutionName . '.';
            logAction($user->email, 'Reject Delete for Institution', $logMessage);
            // notification
            $inputter = Profile::where('email', $institution->deletingBy)->first();
            Notification::send(
                $inputter,
                new InfoNotification(MailContents::rejectInstitutionDeleteMessage($request->reason), MailContents::rejectInstitutionDeleteSubject())
            );
            //
            return redirect()->back()->with('success', "Institution delete has been rejected.");
        }
    }
}
