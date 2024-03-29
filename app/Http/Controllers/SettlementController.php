<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Auction;
use App\Models\Profile;
use App\Models\PublicHoliday;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    //
    public function index()
    {
        $auctions = Auction::where('bidResultTime', '<', now())->get();
        return view('fmdq.settlement.auctions', compact('auctions'));
    }

    // to view the the bids for the auctioneers
    public function bidder()
    {
        $transactions = Transaction::where('auctionRef', request('id'))->with('bidder_obj')->orderBy('amountOffered', 'DESC')->orderBy('timestamp', 'DESC')->get();
        $authorisers = Profile::where('Package', 5)->where('status', 1)->get();
        return view('fmdq.settlement.bidders', compact('transactions', 'authorisers'));
    }

    // to display the list of settlements that has been settled
    public function depository()
    {
        $transactions = Transaction::where('settlementFlag', '1')->with('bidder_obj')->orderBy('amountOffered', 'DESC')->orderBy('timestamp', 'DESC')->get();

        return view('fmdq.settlement.depository', compact('transactions'));
    }

    // to display the list of approved settlements
    public function approval_list()
    {
        $transactions = Transaction::where('settlementFlag', '0')->where('settlementPendingApprovalFlag', 1)->where('settlementRejectedFlag', 0)->where('settlementApprovalFlag', 0)->with('bidder_obj')->orderBy('amountOffered', 'DESC')->orderBy('timestamp', 'DESC')->get();

        return view('fmdq.settlement.approve', compact('transactions'));
    }

    // depository inputter to create settlement
    public function settle(Request $request)
    {

        $validated = $request->validate([
            'bid_ref' => 'bail|required',
            'settlement_date' => 'bail|required|date',
        ]);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $transaction = Transaction::where('id', request('bid_ref'))->where('settlementFlag', 0)->where('awardedFlag', 1)->first();

        if (!$transaction) {
            return redirect()->back()->with('error', "Fail to find bid.");
        }

        $settlement_date = $this->updateTimeBasedOnPublicHoliday(Carbon::create(request('settlement_date')));

        if ($settlement_date->weekday() > 5) {
            $daysToAdd = ($settlement_date->weekday() - 5) + 1;
            $settlement_date = $settlement_date->addDays($daysToAdd);
        }
        //
        $transaction->settlementFlag = '0';
        $transaction->settlementPendingApprovalFlag = '1';
        $transaction->settlementRejectedFlag = '0';
        $transaction->settlementApprovalFlag = '0';
        $transaction->settlementDate = $settlement_date;

        $settle = $transaction->save();
        if ($settle) {
            // log activity
            $logMessage = auth()->user()->email . ' sent transaction settlement for approval';
            logAction(auth()->user()->email, 'Transaction Settlement Sent for Approval', $logMessage, $request->ip());

            //

            return redirect()->back()->with('success', "Transaction Settlement has been set for approval");
        }
    }

    // authoriser to approve settlement
    public function approve_settle(Request $request)
    {

        $validated = $request->validate([
            'bid_ref' => 'bail|required',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $transaction = Transaction::where('id', request('bid_ref'))->where('settlementFlag', 0)->where('awardedFlag', 1)->where('settlementPendingApprovalFlag', 1)->first();

        if (!$transaction) {
            return redirect()->back()->with('error', "Fail to find bid.");
        }

        $transaction->settlementFlag = '1';
        $transaction->settlementPendingApprovalFlag = '0';
        $transaction->settlementRejectedFlag = '0';
        $transaction->settlementApprovalFlag = '0';

        $transaction->save();
        // log activity
        $logMessage = auth()->user()->email . ' approved transaction settlement.';
        logAction(auth()->user()->email, 'Transaction Settlement Approved', $logMessage, $request->ip());
        //

        return redirect()->back()->with('success', "Transaction Settlement Approved.");
    }

    // authoriser to decline settlement
    public function decline_settle(Request $request)
    {

        $validated = $request->validate([
            'bid_ref' => 'bail|required',
            'reason' => 'bail|required',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $transaction = Transaction::where('id', request('bid_ref'))->where('settlementFlag', 0)->where('awardedFlag', 1)->where('settlementPendingApprovalFlag', 1)->first();

        if (!$transaction) {
            return redirect()->back()->with('error', "Fail to find bid.");
        }

        $transaction->settlementFlag = '0';
        $transaction->settlementPendingApprovalFlag = '0';
        $transaction->settlementRejectedFlag = '1';
        $transaction->settlementApprovalFlag = '0';
        $transaction->settlementRejectReason = request('reason');
        $transaction->settlementDate = null;

        $transaction->save();

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Transaction Settlement Sent for Approval';
        $activity->activity = auth()->user()->email . ' sent transaction settlement for approval';
        $activity->username = auth()->user()->email;
        $activity->save();

        return redirect()->back()->with('success', "Transaction Settlement Approved.");
    }

    // function to make sure that trade does not go on Public Holidays
    private function updateTimeBasedOnPublicHoliday($settlement_date)
    {

        $publicHolidays = PublicHoliday::get();

        foreach ($publicHolidays as $publicHoliday) {
            $publicHolidayDate = Carbon::create($publicHoliday->date);
            if ($settlement_date->isoFormat('MM-DD') == $publicHolidayDate->isoFormat('MM-DD')) {
                $settlement_date = $settlement_date->addDays(1);
                $this->updateTimeBasedOnPublicHoliday($settlement_date);
            }
        }
        return $settlement_date;
    }
}
