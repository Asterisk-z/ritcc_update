<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    //

    public function index()
    {
        $auctions = Auction::all();
        return view('fmdq.settlement.auctions', compact('auctions'));
    }

    public function bidder()
    {
        $transactions = Transaction::where('auctionRef', request('id'))->where('settlementFlag', '0')->orderBy('amountOffered', 'DESC')->orderBy('timestamp', 'DESC')->get();
        return view('fmdq.settlement.bidders', compact('transactions'));
    }

    public function settle(Request $request)
    {

        $validated = $request->validate([
            'bid_ref' => 'bail|required',
            'settlement_date' => 'bail|required|date',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }


        dd($request->all());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'auctioneer' => 'bail|required',
            'securityType' => 'bail|required',
            'securityCode' => 'bail|required',
            'description' => 'bail|required',
            'isinNumber' => 'bail|required',
            'issueDate' => 'bail|required',
            'transactionFee' => 'bail|required',
            'offerAmount' => 'bail|required',
            'validationStatus' => 'bail|required',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $auctioneerID = $request->input('auctioneer');
        $securityType = $request->input('securityType');
        $securityCode = $request->input('securityCode');
        $isinNumber = $request->input('isinNumber');
        $description = $request->input('description');
        $transactionFee = $request->input('transactionFee');
        $offerAmount = $request->input('offerAmount');
        $validationStatus = $request->input('validationStatus');
        $issueDate = Carbon::create($request->input('issueDate'));

        $auctioneer = Profile::where('id', $auctioneerID)->where('status', '1')->first();

        if (!$auctioneer) {
            return redirect()->back()->with('error', "Fail to find auctioneer.");
        }

        // You can now proceed with saving the other form data to your database or perform any other actions
        $certificate = new Security();
        $certificate->securityType = $securityType;
        $certificate->securityCode = $securityCode;
        $certificate->isinNumber = $isinNumber;
        $certificate->issuerCode = $auctioneer->user_inst->code;
        $certificate->description = $description;
        $certificate->issueDate = $issueDate;
        $certificate->transactionSettlementFeeRate = $transactionFee;
        $certificate->offerAmount = $offerAmount;
        $certificate->securityValidationStatus = $validationStatus;
        $certificate->auctioneerRef = $auctioneer->id;
        $certificate->status = 0;
        $certificate->createdBy = auth()->user()->email;
        $certificate->createdDate = now();
        $create_action = $certificate->save();

        if (!$create_action) {
            return redirect()->back()->with('error', "Fail to create certificate.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Create Certificate';
        $activity->activity = auth()->user()->email . ' created a certificate ';
        $activity->username = auth()->user()->email;
        $activity->save();
        // mail
        $authorisers = Profile::where('status', '1')->where('type', 'firs')->get();
        foreach ($authorisers as $authoriser) {
            $create = ([
                'authoriser' => $authoriser->firstName,
                'type' => 'certificate',
            ]);
            Mail::to($authoriser)->send(new CreateMail($create));
        }
        return redirect()->back()->with('success', "Certificate has been sent for approval.");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approveCreate(Request $request)
    {

        $validated = $request->validate([
            'security_ref' => 'bail|required|exists:tblSecurity,id',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $security_ref = $request->input('security_ref');

        $security = Security::where('id', $security_ref)->where('rejectionFlag', 0)->where('approveFlag', 0)->first();

        if (!$security) {
            return redirect()->back()->with('error', "Fail to Approve Security.");
        }

        $security->approveFlag = 1;
        $security->approvedBy = auth()->user()->email;
        $security->approvedDate = now();
        $security->rejectedBy = null;
        $security->rejectionFlag = 0;
        $security->rejectionNote = null;
        $security->rejectionDate = null;

        $approve_action = $security->save();

        if (!$approve_action) {
            return redirect()->back()->with('error', "Fail to approve Security.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Approve Security';
        $activity->activity = auth()->user()->email . ' approve Security';
        $activity->username = auth()->user()->email;
        $activity->save();

        return redirect()->back()->with('success', "Security Approved Successfully.");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rejectCreate(Request $request)
    {
        $validated = $request->validate([
            'security_ref' => 'bail|required|exists:tblSecurity,id',
            'reason' => 'bail|required',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $security_ref = $request->input('security_ref');
        $reason = $request->input('reason');

        $security = Security::where('id', $security_ref)->where('rejectionFlag', 0)->where('approveFlag', 0)->first();

        if (!$security) {
            return redirect()->back()->with('error', "Fail to Reject Security.");
        }

        $security->approveFlag = 0;
        $security->approvedBy = null;
        $security->approvedDate = null;

        $security->rejectedBy = auth()->user()->email;
        $security->rejectionFlag = 1;
        $security->rejectionNote = $reason;
        $security->rejectionDate = now();

        $reject_action = $security->save();

        if (!$reject_action) {
            return redirect()->back()->with('error', "Fail to reject Security.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Reject Security';
        $activity->activity = auth()->user()->email . ' rejected Security';
        $activity->username = auth()->user()->email;
        $activity->save();
        //
        $approver = Profile::where('email', $security->createdBy)->first();
        $rejected = ([
            'name' => $approver->firstName,
            'type' => 'rejectCreateCertificate',
            'reason' => $reason,
        ]);
        Mail::to($security->createdBy)->send(new RejectedMail($rejected));
        //
        return redirect()->back()->with('success', "Security Rejected Successfully.");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'security_ref' => 'bail|required|exists:tblSecurity,id',
            'auctioneer' => 'bail|required',
            'securityType' => 'bail|required',
            'description' => 'bail|required',
            'securityCode' => 'bail|required',
            'isinNumber' => 'bail|required',
            'issueDate' => 'bail|required',
            'transactionFee' => 'bail|required',
            'offerAmount' => 'bail|required',
            'validationStatus' => 'bail|required',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $auctioneerID = $request->input('auctioneer');
        $securityRef = $request->input('security_ref');
        $securityType = $request->input('securityType');
        $description = $request->input('description');
        $securityCode = $request->input('securityCode');
        $isinNumber = $request->input('isinNumber');
        $transactionFee = $request->input('transactionFee');
        $offerAmount = $request->input('offerAmount');
        $validationStatus = $request->input('validationStatus');
        $issueDate = Carbon::create($request->input('issueDate'));

        $security = Security::where('id', $securityRef)->first();

        if (!$security) {
            return redirect()->back()->with('error', "Fail to create Auction.");
        }

        $auctioneer = Profile::where('id', $auctioneerID)->first();

        if (!$auctioneer) {
            return redirect()->back()->with('error', "Fail to find auctioneer.");
        }

        // You can now proceed with saving the other form data to your database or perform any other actions
        $certificate = [];
        $certificate['securityType'] = $securityType;
        $certificate['securityCode'] = $securityCode;
        $certificate['isinNumber'] = $isinNumber;
        $certificate['issuerCode'] = $auctioneer->user_inst->code;
        $certificate['description'] = $description;
        $certificate['issueDate'] = $issueDate;
        $certificate['transactionSettlementFeeRate'] = $transactionFee;
        $certificate['offerAmount'] = $offerAmount;
        $certificate['securityValidationStatus'] = $validationStatus;
        $certificate['auctioneerRef'] = $auctioneer->id;
        $certificate['auctioneerEmail'] = $auctioneer->email;
        $certificate['status'] = 0;
        $certificate['createdBy'] = auth()->user()->email;
        $certificate['createdDate'] = now();

        $modifyingData = json_encode($certificate);

        $security->modifyingBy = auth()->user()->email;
        $security->modifyingFlag = 1;
        $security->modifyingDate = now();
        $security->modifyingData = $modifyingData;

        $update_action = $security->save();

        if (!$update_action) {
            return redirect()->back()->with('error', "Fail to update Security.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Updating Security';
        $activity->activity = auth()->user()->email . ' Send Auction Update for approval';
        $activity->username = auth()->user()->email;
        $activity->save();

        return redirect()->back()->with('success', "Security has been sent for approval.");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approveUpdate(Request $request)
    {
        $validated = $request->validate([
            'security_ref' => 'bail|required|exists:tblSecurity,id',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $security_ref = $request->input('security_ref');

        $security = Security::where('id', $security_ref)->where('rejectionFlag', 0)->where('approveFlag', 0)->first();

        if (!$security) {
            return redirect()->back()->with('error', "Fail to Approve update Security.");
        }

        $modifyData = json_decode($security->modifyingData);

        $security->approveFlag = 0;
        $security->approvedBy = null;
        $security->approvedDate = null;
        $security->rejectedBy = null;
        $security->rejectionFlag = 0;
        $security->rejectionNote = null;
        $security->rejectionDate = null;
        $security->modifyingBy = null;
        $security->modifyingFlag = 0;
        $security->modifyingDate = null;
        $security->modifyingData = null;
        $security->modifiedFlag = 1;
        $security->modifiedBy = auth()->user()->email;
        $security->modifiedDate = now();

        $security->securityCode = $modifyData->securityCode;
        $security->auctioneerRef = $modifyData->auctioneerRef;
        $security->description = $modifyData->description;
        $security->offerAmount = $modifyData->offerAmount;
        $security->isinNumber = $modifyData->isinNumber;
        $security->issueDate = $modifyData->issueDate;
        $security->securityType = $modifyData->securityType;
        $security->issuerCode = $modifyData->issuerCode;
        $security->transactionSettlementFeeRate = $modifyData->transactionSettlementFeeRate;
        $security->securityValidationStatus = $modifyData->securityValidationStatus;
        $security->createdBy = $modifyData->createdBy;
        $security->createdDate = Carbon::create($modifyData->createdDate);

        $approve_action = $security->save();

        if (!$approve_action) {
            return redirect()->back()->with('error', "Fail to approve Security.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Approve Security';
        $activity->activity = auth()->user()->email . ' approve Auction for Security';
        $activity->username = auth()->user()->email;
        $activity->save();

        return redirect()->back()->with('success', "Security Approved Successfully.");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rejectUpdate(Request $request)
    {
        $validated = $request->validate([
            'security_ref' => 'bail|required|exists:tblSecurity,id',
            'reason' => 'bail|required',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $security_ref = $request->input('security_ref');
        $reason = $request->input('reason');

        $security = Security::where('id', $security_ref)->where('rejectionFlag', 0)->where('approveFlag', 0)->first();

        if (!$security) {
            return redirect()->back()->with('error', "Fail to Approve update Security.");
        }

        $security->modifyingBy = null;
        $security->modifyingFlag = 0;
        $security->modifyingDate = null;
        $security->modifyingData = null;
        $security->modifiedFlag = 0;
        $security->modifiedBy = null;
        $security->modifiedDate = null;
        $security->modifyingRejectionNote = $reason;

        $approve_action = $security->save();

        if (!$approve_action) {
            return redirect()->back()->with('error', "Fail to approve Security.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Reject Security';
        $activity->activity = auth()->user()->email . ' rejected Security';
        $activity->username = auth()->user()->email;
        $activity->save();

        return redirect()->back()->with('success', "Auction Rejected Successfully.");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $validated = $request->validate([
            'security_ref' => 'bail|required|exists:tblSecurity,id',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $security_ref = $request->input('security_ref');

        $security = Security::where('id', $security_ref)->where('rejectionFlag', 0)->where('approveFlag', 0)->where('deleteFlag', 0)->first();

        if (!$security) {
            return redirect()->back()->with('error', "Fail to Delete Security.");
        }

        $security->deletingBy = auth()->user()->email;
        $security->deletingFlag = 1;

        $approve_action = $security->save();

        if (!$approve_action) {
            return redirect()->back()->with('error', "Fail to delete Security.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Delete Security';
        $activity->activity = auth()->user()->email . ' deleted Security for Security';
        $activity->username = auth()->user()->email;
        $activity->save();

        return redirect()->back()->with('success', "Security Rejected Successfully.");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approveDelete(Request $request)
    {
        $validated = $request->validate([
            'security_ref' => 'bail|required|exists:tblSecurity,id',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $security_ref = $request->input('security_ref');

        $security = Security::where('id', $security_ref)->where('rejectionFlag', 0)->where('approveFlag', 0)->where('deleteFlag', 0)->first();

        if (!$security) {
            return redirect()->back()->with('error', "Fail to Delete Security.");
        }

        $security->deletedBy = auth()->user()->email;
        $security->deleteFlag = 1;
        $security->deletedDate = now();

        $approve_action = $security->save();

        if (!$approve_action) {
            return redirect()->back()->with('error', "Fail to delete Auction.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Delete Auction';
        $activity->activity = auth()->user()->email . ' deleted Auction for Security';
        $activity->username = auth()->user()->email;
        $activity->save();

        return redirect()->back()->with('success', "Auction Rejected Successfully.");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rejectDelete(Request $request)
    {
        $validated = $request->validate([
            'security_ref' => 'bail|required|exists:tblSecurity,id',
            'reason' => 'bail|required',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $security_ref = $request->input('security_ref');
        $reason = $request->input('reason');

        $security = Security::where('id', $security_ref)->where('rejectionFlag', 0)->where('approveFlag', 0)->where('deleteFlag', 0)->first();

        if (!$security) {
            return redirect()->back()->with('error', "Fail to Reject Delete Security.");
        }

        $security->modifyingBy = null;
        $security->modifyingFlag = 0;
        $security->modifyingDate = null;
        $security->modifyingData = null;
        $security->modifiedFlag = 0;
        $security->modifiedBy = null;
        $security->modifiedDate = null;
        $security->modifyingRejectionNote = $reason;
        $security->deletingBy = null;
        $security->deletingFlag = 0;

        $approve_action = $security->save();

        if (!$approve_action) {
            return redirect()->back()->with('error', "Fail to delete Security.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Delete Auction';
        $activity->activity = auth()->user()->email . ' deleted Auction for Security';
        $activity->username = auth()->user()->email;
        $activity->save();

        return redirect()->back()->with('success', "Auction Delete Rejected Successfully.");
    }

}
