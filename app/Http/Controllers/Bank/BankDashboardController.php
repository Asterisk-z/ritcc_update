<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankDashboardController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $auctions = [];
        $trades = [];
        $all = 0;
        $approved = 0;
        $pending = 0;
        $rejected = 0;
        if (auth()->user()->type == 'auctioneer') {
            $auctions = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->where('auctionStartTime', '<=', now())->where('bidCloseTime', '<=', now())->orderBy('createdDate', 'DESC')->get();
            $all = Auction::where('auctioneerRef', auth()->user()->id)->count();
            $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->where('bidCloseTime', '<=', now())->count();
            $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->count();
            $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->count();
        }

        if (auth()->user()->type == 'bidder') {

            $trades = Transaction::where('bidderRef', auth()->user()->id)->orderBy('timestamp', 'DESC')->get();
            // dd($trades);
            $bidder = auth()->user()->email;
            $auctions = Auction::where('approveFlag', 1)
                ->where('rejectionFlag', 0)
                ->where('deleteFlag', 0)
                ->where('modifyingFlag', 0)
                ->where('deletingFlag', 0)
                ->where('auctionStartTime', '<=', now())
                ->where('bidCloseTime', '>=', now())
                ->whereNotIn('securityCode', function ($query) use ($bidder) {
                    $query->select('securityCode')
                        ->from('tblTransaction')
                        ->where('bidder', '=', $bidder);
                })
                ->orderBy('createdDate', 'DESC')
                ->get();
            $all = Auction::where('deleteFlag', 0)->count();
            $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctionStartTime', '>=', now())->where('bidCloseTime', '<=', now())->count();
            $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
            $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->count();
        }
        return view('bank.dashboard', compact('user', 'auctions', 'trades', 'all', 'pending', 'approved', 'rejected'));
    }
    // bidder dashboard
    public function bidderDashboard()
    {
        $page = 'My Trades';
        $user = auth()->user();
        $trades = Transaction::where('bidderRef', auth()->user()->id)->orderBy('timestamp', 'DESC')->get();
        // dd($trades);
        $bidder = auth()->user()->email;
        $auctions = Auction::where('approveFlag', 1)
            ->where('rejectionFlag', 0)
            ->where('deleteFlag', 0)
            ->where('modifyingFlag', 0)
            ->where('deletingFlag', 0)
            ->where('auctionStartTime', '<=', now())
            ->where('bidCloseTime', '>=', now())
            ->whereNotIn('securityCode', function ($query) use ($bidder) {
                $query->select('securityCode')
                    ->from('tblTransaction')
                    ->where('bidder', '=', $bidder);
            })
            ->orderBy('createdDate', 'DESC')
            ->get();
        $all = Transaction::where('bidder', $bidder)->count();
        $approved = Transaction::where('bidder', $bidder)->where('awardedFlag', 1)->count();
        $pending = Transaction::where('bidder', $bidder)->where('awardedFlag', 0)->count();
        return view('fmdq.trade.bidder.dashboard', compact('user', 'auctions', 'trades', 'all', 'pending', 'approved', 'page'));
    }

    //
    public function myPendingTrades()
    {
        $page = 'My Pending Trades';
        $user = auth()->user();
        $trades = Transaction::where('bidderRef', auth()->user()->id)->where('awardedFlag', 0)->orderBy('timestamp', 'DESC')->get();
        // dd($trades);
        $bidder = auth()->user()->email;
        $auctions = Auction::where('approveFlag', 1)
            ->where('rejectionFlag', 0)
            ->where('deleteFlag', 0)
            ->where('modifyingFlag', 0)
            ->where('deletingFlag', 0)
            ->where('auctionStartTime', '<=', now())
            ->where('bidCloseTime', '>=', now())
            ->whereNotIn('securityCode', function ($query) use ($bidder) {
                $query->select('securityCode')
                    ->from('tblTransaction')
                    ->where('bidder', '=', $bidder);
            })
            ->orderBy('createdDate', 'DESC')
            ->get();
        $all = Transaction::where('bidder', $bidder)->count();
        $approved = Transaction::where('bidder', $bidder)->where('awardedFlag', 1)->count();
        $pending = Transaction::where('bidder', $bidder)->where('awardedFlag', 0)->count();
        return view('fmdq.trade.bidder.pending', compact('user', 'auctions', 'trades', 'all', 'pending', 'approved', 'page'));
    }

    //
    public function myAwardedTrades()
    {
        $page = 'My Awarded Trades';
        $user = auth()->user();
        $trades = Transaction::where('bidderRef', auth()->user()->id)->where('awardedFlag', 1)->orderBy('timestamp', 'DESC')->get();
        // dd($trades);
        $bidder = auth()->user()->email;
        $auctions = Auction::where('approveFlag', 1)
            ->where('rejectionFlag', 0)
            ->where('deleteFlag', 0)
            ->where('modifyingFlag', 0)
            ->where('deletingFlag', 0)
            ->where('auctionStartTime', '<=', now())
            ->where('bidCloseTime', '>=', now())
            ->whereNotIn('securityCode', function ($query) use ($bidder) {
                $query->select('securityCode')
                    ->from('tblTransaction')
                    ->where('bidder', '=', $bidder);
            })
            ->orderBy('createdDate', 'DESC')
            ->get();
        $all = Transaction::where('bidder', $bidder)->count();
        $approved = Transaction::where('bidder', $bidder)->where('awardedFlag', 1)->count();
        $pending = Transaction::where('bidder', $bidder)->where('awardedFlag', 0)->count();
        return view('fmdq.trade.bidder.awarded', compact('user', 'auctions', 'trades', 'all', 'pending', 'approved', 'page'));
    }

    // all my(auctioneer's) auctions
    public function myAuctions()
    {
        $page = 'My Auctions';
        $user = auth()->user();
        $auctions = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->where('auctionStartTime', '<=', now())->where('bidCloseTime', '<=', now())->orderBy('createdDate', 'DESC')->get();
        $all = Auction::where('auctioneerRef', auth()->user()->id)->count();
        $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->where('bidCloseTime', '<=', now())->count();
        $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->count();
        $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->count();
        return view('fmdq.trade.auctioneer.dashboard', compact('user', 'auctions', 'all', 'pending', 'approved', 'rejected', 'page'));
    }
    // all pending my(auctioneer's) auctions
    public function myPendingAuctions()
    {
        $page = 'My Pending Auctions';
        $user = auth()->user();
        $auctions = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->orderBy('createdDate', 'DESC')->get();
        $all = Auction::where('auctioneerRef', auth()->user()->id)->count();
        $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->where('bidCloseTime', '<=', now())->count();
        $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->count();
        $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->count();
        return view('fmdq.trade.auctioneer.pending', compact('user', 'auctions', 'all', 'pending', 'approved', 'page', 'rejected'));
    }
    // all approved my(auctioneer's) auctions
    public function myApprovedAuctions()
    {
        $page = 'My Approved Auctions';
        $user = auth()->user();
        $auctions = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('auctioneerRef', auth()->user()->id)->orderBy('createdDate', 'DESC')->get();
        $all = Auction::where('auctioneerRef', auth()->user()->id)->count();
        $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->where('bidCloseTime', '<=', now())->count();
        $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->count();
        $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->count();
        return view('fmdq.trade.auctioneer.approved', compact('user', 'auctions', 'all', 'pending', 'approved', 'page', 'rejected'));
    }
    // all rejected my(auctioneer's) auctions
    public function myRejectedAuctions()
    {
        $page = 'My Rejected Auctions';
        $user = auth()->user();
        $auctions = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('auctioneerRef', auth()->user()->id)->orderBy('createdDate', 'DESC')->get();
        $all = Auction::where('auctioneerRef', auth()->user()->id)->count();
        $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->where('bidCloseTime', '<=', now())->count();
        $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->count();
        $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->count();
        return view('fmdq.trade.auctioneer.rejected', compact('user', 'auctions', 'all', 'pending', 'approved', 'page', 'rejected'));
    }
}
