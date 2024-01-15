<?php

namespace App\Http\Controllers\FMDQ;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Auction;
use App\Models\Security;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TradeManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'Trade Management';
        if (request('id')) {
            $trades = Transaction::where('bidderRef', auth()->user()->id)->where('awardedFlag', 1)->orderBy('timestamp', 'DESC')->get();
            $auctions = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('modifyingFlag', 0)->where('deletingFlag', 0)->orderBy('createdDate', 'DESC')->get();
            $all = Auction::where('deleteFlag', 0)->count();
            $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
            $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
            $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->count();
            return view('fmdq.trade.awarded', compact('auctions', 'all', 'pending', 'approved', 'rejected', 'page', 'trades'));
        } else {
            $trades = Transaction::where('bidderRef', auth()->user()->id)->where('awardedFlag', 0)->orderBy('timestamp', 'DESC')->get();
            // $auctions = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('modifyingFlag', 0)->where('deletingFlag', 0)->orderBy('createdDate', 'DESC')->get();
            $auctioneerEmail = auth()->user()->email;
            $auctions =  Auction::where('approveFlag', 1)
                ->where('rejectionFlag', 0)
                ->where('deleteFlag', 0)
                ->where('modifyingFlag', 0)
                ->where('deletingFlag', 0)
                ->whereIn('securityCode', function ($query) use ($auctioneerEmail) {
                    $query->select('securityCode')
                        ->from('tblTransaction')
                        ->where('auctioneerEmail', $auctioneerEmail);
                })
                ->orderBy('createdDate', 'DESC')
                ->get();

            $all = Auction::where('deleteFlag', 0)->count();
            $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
            $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
            $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->count();
            return view('fmdq.trade.index', compact('auctions', 'all', 'pending', 'approved', 'rejected', 'page', 'trades'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bidIndex()
    {
        $page = 'Auctions';
        $auctions = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('createdBy', auth()->user()->email)->orderBy('createdDate', 'DESC')->get();
        $all = Auction::where('deleteFlag', 0)->count();
        $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('createdBy', auth()->user()->email)->count();
        $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('createdBy', auth()->user()->email)->count();
        $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->where('createdBy', auth()->user()->email)->count();

        return view('fmdq.trade.list', compact('auctions', 'all', 'pending', 'approved', 'rejected', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'certificate' => 'bail|required',
            'settlementAccount' => 'bail|required|numeric|min:1',
            'nominalAmount' => 'bail|required|numeric|min:1',
            'discountRate' => 'bail|required|numeric|min:1',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $securityId = $request->input('certificate');
        $settlementAccount = $request->input('settlementAccount');
        $nominalAmount = $request->input('nominalAmount');
        $discountRate = $request->input('discountRate');

        $auction = Auction::where('id', $securityId)->where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->first();

        if (!$auction) {
            return redirect()->back()->with('error', "Fail to place bid.");
        }

        if (now() < Carbon::create($auction->auctionStartTime)) {
            return redirect()->back()->with('error', "Auction Not Open for biding.");
        }
        if (now() > Carbon::create($auction->bidCloseTime)) {
            return redirect()->back()->with('error', "Auction is closed for biding.");
        }

        $check_auction_bit = Transaction::where('auctionRef', $auction->id)->where('bidder', auth()->user()->email)->first();

        if ($check_auction_bit) {
            return redirect()->back()->with('error', "Placed bids can only be updated from your bid section.");
        }

        $transactions = new Transaction();
        $transactions->settlementAccount = $settlementAccount;
        $transactions->securityCode = $auction->security->securityCode;
        $transactions->nominalAmount = $nominalAmount;
        $transactions->auctionRef = $auction->id;
        $transactions->auctioneerEmail = $auction->security->auctioneer->email;
        $transactions->discountRate = $discountRate;
        $transactions->institutionCode = $auction->security->issuerCode;
        $transactions->bidDateTime = now();
        $transactions->bidderRef = auth()->user()->id;
        $transactions->bidder = auth()->user()->email;
        $transactions->timestamp = now();

        // $transactions->createdBy = auth()->user()->email;
        // $transactions->createdDate = now();
        $create_action = $transactions->save();

        if (!$create_action) {
            return redirect()->back()->with('error', "Fail to place bid.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Place Auction Bid';
        $activity->activity = auth()->user()->email . ' placed bid for an auction for Security';
        $activity->username = auth()->user()->email;
        $activity->save();

        return redirect()->back()->with('success', "Bid Placed successfully.");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $validated = $request->validate([
            'transaction_ref' => 'bail|required',
            'auction_ref' => 'bail|required',
            'settlementAccount' => 'bail|required|numeric|min:1',
            'nominalAmount' => 'bail|required|numeric|min:1',
            'discountRate' => 'bail|required|numeric|min:1',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $transaction_ref = $request->input('transaction_ref');
        $securityId = $request->input('auction_ref');
        $settlementAccount = $request->input('settlementAccount');
        $nominalAmount = $request->input('nominalAmount');
        $discountRate = $request->input('discountRate');

        $auction = Auction::where('id', $securityId)->where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->first();

        if (!$auction) {
            return redirect()->back()->with('error', "Fail to place bid.");
        }

        if (now() < Carbon::create($auction->auctionStartTime)) {
            return redirect()->back()->with('error', "Auction Not Open for biding.");
        }
        if (now() > Carbon::create($auction->bidCloseTime)) {
            return redirect()->back()->with('error', "Auction is closed for biding.");
        }

        $transaction = Transaction::where('id', $transaction_ref)->where('bidder', auth()->user()->email)->first();

        if (!$transaction) {
            return redirect()->back()->with('error', "Placed bids can only be updated from your bid section.");
        }

        $transaction->settlementAccount = $settlementAccount;
        $transaction->securityCode = $auction->security->securityCode;
        $transaction->nominalAmount = $nominalAmount;
        $transaction->auctionRef = $auction->id;
        $transaction->auctioneerEmail = $auction->security->auctioneer->email;
        $transaction->discountRate = $discountRate;
        $transaction->institutionCode = $auction->security->issuerCode;
        $transaction->bidDateTime = now();
        $transaction->bidderRef = auth()->user()->id;
        $transaction->bidder = auth()->user()->email;
        $transaction->timestamp = now();

        $create_action = $transaction->save();

        if (!$create_action) {
            return redirect()->back()->with('error', "Fail to place bid.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Place Bid';
        $activity->activity = auth()->user()->email . ' place bid for Security';
        $activity->username = auth()->user()->email;
        $activity->save();

        // mail
        // $approver = Profile::where('email', $authoriser)->first();
        // $new = ([
        //     'name' => $approver->FirstName,
        // ]);
        // Mail::to($authoriser)->send(new CreateInstitutionMail($new));

        return redirect()->back()->with('success', "Bid Updated successfully.");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {

        $validated = $request->validate([
            'transaction_ref' => 'bail|required',
        ], []);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $transaction_ref = $request->input('transaction_ref');

        $transaction = Transaction::where('id', $transaction_ref)->where('bidder', auth()->user()->email)->first();

        if (!$transaction) {
            return redirect()->back()->with('error', "Placed bids can only be updated from your bid section.");
        }

        $auction = Auction::where('id', $transaction->auctionRef)->where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->first();

        if (!$auction) {
            return redirect()->back()->with('error', "Fail to place bid.");
        }

        if (now() < Carbon::create($auction->auctionStartTime)) {
            return redirect()->back()->with('error', "Auction Not Open for biding.");
        }
        if (now() > Carbon::create($auction->bidCloseTime)) {
            return redirect()->back()->with('error', "Auction is closed for biding.");
        }

        $create_action = $transaction->delete();

        if (!$create_action) {
            return redirect()->back()->with('error', "Fail to place bid.");
        }

        $activity = new ActivityLog();
        $activity->date = now();
        $activity->app = 'RITCC';
        $activity->type = 'Place Bid';
        $activity->activity = auth()->user()->email . ' place bid for Security';
        $activity->username = auth()->user()->email;
        $activity->save();

        // mail
        // $approver = Profile::where('email', $authoriser)->first();
        // $new = ([
        //     'name' => $approver->FirstName,
        // ]);
        // Mail::to($authoriser)->send(new CreateInstitutionMail($new));

        return redirect()->back()->with('success', "Bid Updated successfully.");
    }
}
