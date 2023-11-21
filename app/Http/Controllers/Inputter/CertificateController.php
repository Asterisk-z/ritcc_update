<?php

namespace App\Http\Controllers\inputter;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Security;
use App\Models\SecurityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {

        $user = Auth::user();
        $page = 'All Certificate';
        $securityTypes = SecurityType::orderBy('Description', 'DESC')->get();
        $securities = Security::orderBy('CreatedDate', 'DESC')->get();
        $all = Security::count();
        $approved = Security::where('ApproveFlag', '1')->count();
        $pending = Security::where('ApproveFlag', '0')->where('RejectionFlag', '0')->count();
        $rejected = Security::where('RejectionFlag', '1')->count();

        $auctioneers = Profile::where('status', '1')->where(function ($query) {
            $query->where('Package', '7')->orWhere('Package', '9')->orWhere('Package', '11');
        })->get();

        return view('inputter.certificate', compact('user', 'securities', 'all', 'pending', 'approved', 'rejected', 'page', 'auctioneers', 'securityTypes'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'SecurityCode' => 'bail|required|unique:tblSecurity',
            'Description' => 'bail|string|required',
            'ISINNumber' => 'bail|string|required',
            'SecurityType' => 'bail|string|required',
            'IssuerCode' => 'bail|string|required|max:4',
            'IssuerDate' => 'bail|string|required',
            'OfferAmount' => 'bail|number|required',
            'ValidationStatus' => 'bail|boolean|required',
        ]);

        if ($validated) {

            $SecurityCode = $request->input('SecurityCode');
            $Description = $request->input('Description');
            $ISINNumber = $request->input('ISINNumber');
            $SecurityType = $request->input('SecurityType');
            $IssuerCode = $request->input('IssuerCode');
            $IssuerDate = $request->input('IssuerDate');
            $OfferAmount = $request->input('OfferAmount');
            $ValidationStatus = $request->input('ValidationStatus');

            $inputter = $user->email;
            // You can now proceed with saving the other form data to your database or perform any other actions
            $security_object = new Security();
            $security_object->SecurityCode = $SecurityCode;
            $security_object->Description = $Description;
            $security_object->ISINNumber = $ISINNumber;
            $security_object->SecurityType = $SecurityType;
            $security_object->IssuerCode = $IssuerCode;
            $security_object->IssuerDate = $IssuerDate;
            $security_object->OfferAmount = $OfferAmount;
            $security_object->ValidationStatus = $ValidationStatus;
            $security_object->status = 0;
            $security_object->createdDate = now();
            $save_object = $security_object->save();

            if ($save_object) {
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
