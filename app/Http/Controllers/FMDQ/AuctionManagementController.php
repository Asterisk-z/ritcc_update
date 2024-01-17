<?php

namespace App\Http\Controllers\FMDQ;

use App\Helpers\MailContents;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Auction;
use App\Models\Profile;
use App\Models\Security;
use App\Models\Transaction;
use App\Notifications\InfoNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class AuctionManagementController extends Controller
{
    // all auctions page
    public function index()
    {
        $page = 'All Auctions';
        $auctions = Auction::orderBy('createdDate', 'DESC')->get();
        $auctions_sec_id = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->pluck('securityRef');
        $securities = Security::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->whereNotIn('id', $auctions_sec_id)->orderBy('CreatedDate', 'DESC')->get();
        $auctions = Auction::orderBy('createdDate', 'DESC')->get();
        $authorisers = Profile::where('status', 1)->where('Package', '3')->get();
        $all = Auction::count();
        $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->count();

        return view('fmdq.auction.index', compact('securities', 'auctions', 'all', 'pending', 'approved', 'rejected', 'authorisers', 'page'));
    }

    // auctions index
    public function auctionsIndex()
    {
        $page = 'Auctions';
        $auctions = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->orderBy('createdDate', 'DESC')->get();
        $all = Auction::where('auctioneerRef', auth()->user()->id)->count();
        $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->count();
        $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->count();
        $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->count();
        $authorisers = Profile::where('status', 1)->where('Package', '3')->get();
        return view('fmdq.auction.list', compact('auctions', 'all', 'pending', 'approved', 'rejected', 'page', 'authorisers'));
    }

    // pending auction page
    public function pendingIndex()
    {
        $page = 'Pending Auctions';
        $securities = Security::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->orderBy('CreatedDate', 'DESC')->get();
        $auctions = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->orderBy('createdDate', 'DESC')->get();
        $all = Auction::count();
        $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->count();
        $authorisers = Profile::where('status', 1)->where('Package', '3')->get();
        return view('fmdq.auction.pending', compact('auctions', 'all', 'pending', 'approved', 'rejected', 'page', 'securities', 'authorisers'));
    }

    // rejected auction page
    public function rejectedIndex()
    {
        $page = 'Rejected Auctions';
        $securities = Security::orderBy('CreatedDate', 'DESC')->get();
        $auctions = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->orderBy('createdDate', 'DESC')->get();
        $all = Auction::count();
        $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->count();
        $authorisers = Profile::where('status', 1)->where('Package', '3')->get();
        return view('fmdq.auction.rejected', compact('securities', 'auctions', 'all', 'pending', 'approved', 'rejected', 'page', 'authorisers'));
    }

    // approved auction page
    public function approvedIndex()
    {
        $page = 'Approved Auctions';
        $securities = Security::orderBy('CreatedDate', 'DESC')->get();
        $auctions = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->orderBy('createdDate', 'DESC')->get();
        $all = Auction::count();
        $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->count();
        $authorisers = Profile::where('status', 1)->where('Package', '3')->get();
        return view('fmdq.auction.approved', compact('securities', 'auctions', 'all', 'pending', 'approved', 'rejected', 'page', 'authorisers'));
    }

    // auction history page
    public function auctionsHistory()
    {
        $page = 'Auctions History';
        $securities = Security::orderBy('CreatedDate', 'DESC')->get();

        $auctions = [];
        $all = Auction::count();
        $approved = Auction::where('approveFlag', 9)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 9)->where('deleteFlag', 0)->count();

        if (auth()->user()->type == 'super') {
            $auctions = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->orderBy('createdDate', 'DESC')->get();
        } else {
            $auctions = Auction::where('auctioneerEmail', auth()->user()->email)->where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->orderBy('createdDate', 'DESC')->get();
        }

        return view('fmdq.auction.history', compact('securities', 'auctions', 'all', 'pending', 'approved', 'rejected', 'page'));
    }

    // auction allocation page
    public function allocation()
    {
        $page = 'Auction Allocation';
        $securities = Security::orderBy('CreatedDate', 'DESC')->get();

        $auctions = Auction::where('auctioneerEmail', auth()->user()->email)->where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->orderBy('createdDate', 'DESC')->get();

        return view('fmdq.auction.allocation', compact('securities', 'auctions', 'page'));
    }

    // auction bids page
    public function auctionBids()
    {
        $page = 'Auctions History Bids';
        $bids = Transaction::where('auctionRef', request('id'))->orderBy('nominalAmount', 'DESC')->orderBy('timestamp', 'DESC')->get();
        $amountOffered = Transaction::where('auctionRef', request('id'))->orderBy('nominalAmount', 'DESC')->orderBy('timestamp', 'DESC')->sum('amountOffered');
        $offerAmount = Auction::where('id', request('id'))->first();
        $availableAmount = $offerAmount->offerAmount - $amountOffered;

        return view('fmdq.auction.bids', compact('bids', 'page', 'availableAmount'));
    }

    // auction results page
    public function results()
    {
        $page = 'Auctions History Bids';

        $bids = Transaction::pluck('auctionRef');
        // $auctions = Auction::whereIn('tblAuction.id', $bids)->withCount('transactions')->get();
        $auctions = Auction::whereIn('tblAuction.id', $bids)->get();
        $auction_list = [];
        foreach ($auctions as $auction) {

            $bids = Transaction::where('auctionRef', $auction->id)->sum('nominalAmount');
            $total_bid = Transaction::where('auctionRef', $auction->id)->count();
            $auction->total_bid_amount = $bids;
            $auction->total_bid = $total_bid;
            array_push($auction_list, $auction);
        }

        return view('fmdq.auction.results', compact('bids', 'auction_list', 'page'));
    }

    // close auction
    public function closeAuction(Request $request)
    {

        $validated = $request->validate([
            'auction_ref' => 'bail|required|exists:tblAuction,id',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $auction_ref = $request->input('auction_ref');

        $auction = Auction::where('id', $auction_ref)->where('rejectionFlag', 0)->where('approveFlag', 1)->first();

        if (!$auction) {
            return redirect()->back()->with('error', "Fail to Close Auction.");
        }

        $auction->bidCloseTime = now();

        $approve_action = $auction->save();

        if (!$approve_action) {
            return redirect()->back()->with('error', "Fail to approve Auction.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Closed Auction';
        $activity->activity = auth()->user()->email . ' closed Auction for bidding';
        $activity->username = auth()->user()->email;
        $activity->save();

        return redirect()->back()->with('success', "Auction Approved Successfully.");
    }

    // award auction to bidder
    public function awardAuction(Request $request)
    {

        $validated = $request->validate([
            'bid_ref' => 'bail|required|exists:tblTransaction,id',
            'bidder_email' => 'bail|required',
            'award_amount' => 'bail|required',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $bid_ref = $request->input('bid_ref');
        $bidder_email = $request->input('bidder_email');
        $award_amount = $request->input('award_amount');

        $bid = Transaction::where('id', $bid_ref)->where('bidder', $bidder_email)->first();

        if (!$bid) {
            return redirect()->back()->with('error', "Fail to Award Offer.");
        }

        $totalAwardedBids = Transaction::where('auctionRef', $bid->auctionRef)->where('awardedFlag', 1)->sum('amountOffered') + $award_amount;

        if ($totalAwardedBids > $bid->auction->offerAmount) {
            return redirect()->back()->with('error', "Fail to Award Offer.");
        }

        $bid->awardedFlag = 1;
        $bid->amountOffered = $award_amount;
        $approve_action = $bid->save();
        //
        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Awarded Offer';
        $activity->activity = auth()->user()->email . ' awarded bidding';
        $activity->username = auth()->user()->email;
        $activity->save();

        return redirect()->back()->with('success', "Bid Awarded Successfully.");
    }

    // cancel award auction
    public function awardCancelAuction(Request $request)
    {

        $validated = $request->validate([
            'bid_ref' => 'bail|required|exists:tblTransaction,id',
            'bidder_email' => 'bail|required',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $bid_ref = $request->input('bid_ref');
        $bidder_email = $request->input('bidder_email');

        $bid = Transaction::where('id', $bid_ref)->where('bidder', $bidder_email)->first();

        if (!$bid) {
            return redirect()->back()->with('error', "Fail to Award Offer.");
        }

        $bid->awardedFlag = 0;
        $bid->amountOffered = 0;

        $approve_action = $bid->save();

        if (!$approve_action) {
            return redirect()->back()->with('error', "Fail to approve Auction.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Cancel Awarded Offer';
        $activity->activity = auth()->user()->email . ' cancel awarded bidding';
        $activity->username = auth()->user()->email;
        $activity->save();

        return redirect()->back()->with('success', "Bid Awarded Successfully.");
    }

    // create auction
    public function create(Request $request)
    {
        $validated = $request->validate([
            'securityId' => 'bail|required|unique:tblAuction,securityRef',
            'offerDate' => 'bail|required|date|after_or_equal:today',
            'auction_start_time' => 'bail|required|date|after_or_equal:today',
            'bids_close_time' => 'bail|required|date|after_or_equal:today|after:auction_start_time',
            'bids_result_time' => 'bail|required|date|after_or_equal:today|after:auction_start_time|after:bids_close_time',
            'minimum_rate' => 'bail|required|numeric|min:0',
            'maximum_rate' => 'bail|required|numeric|min:0|gte:minimum_rate',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $securityId = $request->input('securityId');
        $offerDate = Carbon::create($request->input('offerDate'));
        $auction_start_time = Carbon::create($request->input('auction_start_time'));
        $bids_close_time = Carbon::create($request->input('bids_close_time'));
        $bids_result_time = Carbon::create($request->input('bids_result_time'));
        $minimum_rate = $request->input('minimum_rate');
        $maximum_rate = $request->input('maximum_rate');

        $security = Security::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('id', $securityId)->first();

        if (!$security) {
            return redirect()->back()->with('error', "Fail to create Auction.");
        }

        // You can now proceed with saving the other form data to your database or perform any other actions
        $auctions = new Auction();
        $auctions->securityRef = $securityId;
        $auctions->securityCode = $security->securityCode;
        $auctions->auctioneerRef = $security->auctioneerRef;
        $auctions->auctioneerEmail = $security->auctioneer->email;
        $auctions->offerAmount = $security->offerAmount;
        $auctions->isinNumber = $security->isinNumber;
        $auctions->offerDate = $offerDate;
        $auctions->auctionStartTime = $auction_start_time;
        $auctions->bidCloseTime = $bids_close_time;
        $auctions->bidResultTime = $bids_result_time;
        $auctions->minimumRate = $minimum_rate;
        $auctions->maximumRate = $maximum_rate;
        $auctions->status = 0;
        $auctions->createdBy = auth()->user()->email;
        $auctions->createdDate = now();
        $create_action = $auctions->save();

        if (!$create_action) {
            return redirect()->back()->with('error', "Fail to create Auction.");
        }
        // log activity
        $logMessage = auth()->user()->email . ' created an auction for Security ';
        logAction(auth()->user()->email, 'Create Auction', $logMessage, $request->ip());
        // mail
        $approver = Profile::where('email', $request->authoriser)->first();
        Notification::send(
            $approver,
            new InfoNotification(MailContents::createAuctionMessage(), MailContents::createAuctionSubject())
        );
        //
        return redirect()->back()->with('success', "Auction has been sent for approval.");
    }
    // approve create auction
    public function approveCreate(Request $request)
    {

        $validated = $request->validate([
            'auction_ref' => 'bail|required|exists:tblAuction,id',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $auction_ref = $request->input('auction_ref');

        $auction = Auction::where('id', $auction_ref)->where('rejectionFlag', 0)->where('approveFlag', 0)->first();

        if (!$auction) {
            return redirect()->back()->with('error', "Fail to Approve Auction.");
        }

        $auction->approveFlag = 1;
        $auction->approvedBy = auth()->user()->email;
        $auction->approvedDate = now();
        $auction->rejectedBy = null;
        $auction->rejectionFlag = 0;
        $auction->rejectionNote = null;
        $auction->rejectionDate = null;

        $approve_action = $auction->save();

        if (!$approve_action) {
            return redirect()->back()->with('error', "Fail to approve Auction.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Approve Auction';
        $activity->activity = auth()->user()->email . ' approve Auction for Security';
        $activity->username = auth()->user()->email;
        $activity->save();

        return redirect()->back()->with('success', "Auction Approved Successfully.");
    }
    // reject create auction
    public function rejectCreate(Request $request)
    {
        $validated = $request->validate([
            'auction_ref' => 'bail|required|exists:tblAuction,id',
            'reason' => 'bail|required',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $auction_ref = $request->input('auction_ref');
        $reason = $request->input('reason');

        $auction = Auction::where('id', $auction_ref)->where('rejectionFlag', 0)->where('approveFlag', 0)->first();

        if (!$auction) {
            return redirect()->back()->with('error', "Fail to Reject Auction.");
        }

        $auction->approveFlag = 0;
        $auction->approvedBy = null;
        $auction->approvedDate = null;

        $auction->rejectedBy = auth()->user()->email;
        $auction->rejectionFlag = 1;
        $auction->rejectionNote = $reason;
        $auction->rejectionDate = now();

        $reject_action = $auction->save();

        if (!$reject_action) {
            return redirect()->back()->with('error', "Fail to reject Auction.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Reject Auction';
        $activity->activity = auth()->user()->email . ' rejected Auction for Security';
        $activity->username = auth()->user()->email;
        $activity->save();

        return redirect()->back()->with('success', "Auction Approved Successfully.");
    }
    // update auction
    public function update(Request $request)
    {
        $validated = $request->validate([
            'auction_ref' => 'bail|required|exists:tblAuction,id',
            'securityId' => 'bail|required|exists:tblAuction,securityRef',
            'offerDate' => 'bail|required|date|after_or_equal:today',
            'auction_start_time' => 'bail|required|date|after_or_equal:today',
            'bids_close_time' => 'bail|required|date|after_or_equal:today|after:auction_start_time',
            'bids_result_time' => 'bail|required|date|after_or_equal:today|after:auction_start_time|after:bids_close_time',
            'minimum_rate' => 'bail|required|numeric|min:0',
            'maximum_rate' => 'bail|required|numeric|min:0|gte:minimum_rate',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $securityId = $request->input('securityId');
        $offerDate = Carbon::create($request->input('offerDate'));
        $auction_start_time = Carbon::create($request->input('auction_start_time'));
        $bids_close_time = Carbon::create($request->input('bids_close_time'));
        $bids_result_time = Carbon::create($request->input('bids_result_time'));
        $minimum_rate = $request->input('minimum_rate');
        $maximum_rate = $request->input('maximum_rate');
        $auction_ref = $request->input('auction_ref');

        $security = Security::where('id', $securityId)->first();

        if (!$security) {
            return redirect()->back()->with('error', "Fail to create Auction.");
        }

        $auction = Auction::where('id', $auction_ref)->first();

        // You can now proceed with saving the other form data to your database or perform any other actions
        // dd($security->offerAmount);
        $auctions = [];
        $auctions['securityRef'] = $securityId;
        $auctions['securityCode'] = $security->securityCode;
        $auctions['auctioneerRef'] = $security->auctioneerRef;
        $auctions['auctioneerEmail'] = $security->auctioneer->email;
        $auctions['offerAmount'] = $security->offerAmount;
        $auctions['isinNumber'] = $security->isinNumber;
        $auctions['offerDate'] = $offerDate;
        $auctions['auctionStartTime'] = $auction_start_time;
        $auctions['bidCloseTime'] = $bids_close_time;
        $auctions['bidResultTime'] = $bids_result_time;
        $auctions['minimumRate'] = $minimum_rate;
        $auctions['maximumRate'] = $maximum_rate;
        $auctions['approveFlag'] = $auction->approveFlag;
        $auctions['createdBy'] = auth()->user()->email;
        $auctions['createdDate'] = now();

        $modifyingData = json_encode($auctions);

        $auction->approveFlag = 0;
        $auction->approvedBy = null;
        $auction->approvedDate = null;
        $auction->modifyingBy = auth()->user()->email;
        $auction->modifyingFlag = 1;
        $auction->modifyingDate = now();
        $auction->modifyingData = $modifyingData;

        $update_action = $auction->save();

        if (!$update_action) {
            return redirect()->back()->with('error', "Fail to update Auction.");
        }

        // log activity
        $logMessage = auth()->user()->email . ' sent an auction update for approval';
        logAction(auth()->user()->email, 'Update Auction', $logMessage, $request->ip());
        // mail
        $approver = Profile::where('email', $request->authoriser)->first();
        Notification::send(
            $approver,
            new InfoNotification(MailContents::updateAuctionMessage(), MailContents::updateAuctionSubject())
        );
        //
        return redirect()->back()->with('success', "Auction update has been sent for approval.");
    }
    // approve update auction
    public function approveUpdate(Request $request)
    {
        $validated = $request->validate([
            'auction_ref' => 'bail|required|exists:tblAuction,id',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $auction_ref = $request->input('auction_ref');

        $auction = Auction::where('id', $auction_ref)->where('rejectionFlag', 0)->where('approveFlag', 0)->first();

        if (!$auction) {
            return redirect()->back()->with('error', "Fail to Approve update Auction.");
        }

        $modifyData = json_decode($auction->modifyingData);

        $auction->approveFlag = 0;
        $auction->approvedBy = null;
        $auction->approvedDate = null;
        $auction->rejectedBy = null;
        $auction->rejectionFlag = 0;
        $auction->rejectionNote = null;
        $auction->rejectionDate = null;
        $auction->modifyingBy = null;
        $auction->modifyingFlag = 0;
        $auction->modifyingDate = null;
        $auction->modifyingData = null;
        $auction->modifiedFlag = 1;
        $auction->modifiedBy = auth()->user()->email;
        $auction->modifiedDate = now();

        $auction->securityRef = $modifyData->securityRef;
        $auction->securityCode = $modifyData->securityCode;
        $auction->auctioneerRef = $modifyData->auctioneerRef;
        $auction->auctioneerEmail = $modifyData->auctioneerEmail;
        $auction->offerAmount = $modifyData->offerAmount;
        $auction->isinNumber = $modifyData->isinNumber;
        $auction->offerDate = $modifyData->offerDate;
        $auction->auctionStartTime = date('Y-m-d H:i:s', strtotime($modifyData->auctionStartTime));
        $auction->bidCloseTime = date('Y-m-d H:i:s', strtotime($modifyData->bidCloseTime));
        $auction->bidResultTime = date('Y-m-d H:i:s', strtotime($modifyData->bidResultTime));
        $auction->minimumRate = $modifyData->minimumRate;
        $auction->maximumRate = $modifyData->maximumRate;
        $auction->createdBy = $modifyData->createdBy;
        $auction->createdDate = date('Y-m-d H:i:s', strtotime($modifyData->createdDate));

        $approve_action = $auction->save();

        if (!$approve_action) {
            return redirect()->back()->with('error', "Fail to approve Auction.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Approve Auction';
        $activity->activity = auth()->user()->email . ' approve Auction for Security';
        $activity->username = auth()->user()->email;
        $activity->save();

        return redirect()->back()->with('success', "Auction Approved Successfully.");
    }
    // reject update auction
    public function rejectUpdate(Request $request)
    {
        $validated = $request->validate([
            'auction_ref' => 'bail|required|exists:tblAuction,id',
            'reason' => 'bail|required',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $auction_ref = $request->input('auction_ref');
        $reason = $request->input('reason');

        $auction = Auction::where('id', $auction_ref)->where('rejectionFlag', 0)->where('approveFlag', 0)->first();

        if (!$auction) {
            return redirect()->back()->with('error', "Fail to Approve update Auction.");
        }

        $modifyData = json_decode($auction->modifyingData);

        $auction->approveFlag = $modifyData->approveFlag;
        $auction->approvedBy = $modifyData->approvedBy;
        $auction->approvedDate = $modifyData->approvedDate;

        $auction->modifyingBy = null;
        $auction->modifyingFlag = 0;
        $auction->modifyingDate = null;
        $auction->modifyingData = null;
        $auction->modifiedFlag = 0;
        $auction->modifiedBy = null;
        $auction->modifiedDate = null;
        $auction->modifyingRejectionNote = $reason;

        $approve_action = $auction->save();

        if (!$approve_action) {
            return redirect()->back()->with('error', "Fail to approve Auction.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Reject Auction';
        $activity->activity = auth()->user()->email . ' rejected Auction for Security';
        $activity->username = auth()->user()->email;
        $activity->save();

        return redirect()->back()->with('success', "Auction Rejected Successfully.");
    }
    // delete auction
    public function delete(Request $request)
    {
        $validated = $request->validate([
            'auction_ref' => 'bail|required|exists:tblAuction,id',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $auction_ref = $request->input('auction_ref');

        $auction = Auction::where('id', $auction_ref)->where('rejectionFlag', 0)->where('approveFlag', 0)->where('deleteFlag', 0)->first();

        if (!$auction) {
            return redirect()->back()->with('error', "Fail to Delete Auction.");
        }

        $auction->deletingBy = auth()->user()->email;
        $auction->deletingFlag = 1;

        $approve_action = $auction->save();

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
    // approve delete auction
    public function approveDelete(Request $request)
    {
        $validated = $request->validate([
            'auction_ref' => 'bail|required|exists:tblAuction,id',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $auction_ref = $request->input('auction_ref');

        $auction = Auction::where('id', $auction_ref)->where('rejectionFlag', 0)->where('approveFlag', 0)->where('deleteFlag', 0)->first();

        if (!$auction) {
            return redirect()->back()->with('error', "Fail to Delete Auction.");
        }

        $auction->deletedBy = auth()->user()->email;
        $auction->deleteFlag = 1;
        $auction->deletedDate = now();

        $approve_action = $auction->save();

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
    // reject delete auction
    public function rejectDelete(Request $request)
    {
        $validated = $request->validate([
            'auction_ref' => 'bail|required|exists:tblAuction,id',
            'reason' => 'bail|required',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $auction_ref = $request->input('auction_ref');
        $reason = $request->input('reason');

        $auction = Auction::where('id', $auction_ref)->where('rejectionFlag', 0)->where('approveFlag', 0)->where('deleteFlag', 0)->first();

        if (!$auction) {
            return redirect()->back()->with('error', "Fail to Reject Delete Auction.");
        }

        $auction->modifyingBy = null;
        $auction->modifyingFlag = 0;
        $auction->modifyingDate = null;
        $auction->modifyingData = null;
        $auction->modifiedFlag = 0;
        $auction->modifiedBy = null;
        $auction->modifiedDate = null;
        $auction->modifyingRejectionNote = $reason;
        $auction->deletingBy = null;
        $auction->deletingFlag = 0;

        $approve_action = $auction->save();

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

        return redirect()->back()->with('success', "Auction Delete Rejected Successfully.");
    }
}
