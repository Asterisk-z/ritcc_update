<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BankDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            $auctions = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->where('auctionStartTime', '>=', now())->where('bidCloseTime', '>=', now())->orderBy('createdDate', 'DESC')->get();
            $all = Auction::where('auctioneerRef', auth()->user()->id)->count();
            $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->where('bidCloseTime', '>=', now())->count();
            $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->count();
            $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->where('auctioneerRef', auth()->user()->id)->count();
        }

        if (auth()->user()->type == 'bidder') {

            $trades = Transaction::where('bidderRef', auth()->user()->id)->orderBy('timestamp', 'DESC')->get();
            $auctions = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('modifyingFlag', 0)->where('deletingFlag', 0)->where('auctionStartTime', '>=', now())->where('bidCloseTime', '>=', now())->orderBy('createdDate', 'DESC')->get();
            $all = Auction::where('deleteFlag', 0)->count();
            $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('auctionStartTime', '>=', now())->where('bidCloseTime', '>=', now())->count();
            $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
            $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->count();

        }
        // dd($auctions);
// ->where('auctionStartTime', '>=', now())->where('bidCloseTime', '<=', now())
        return view('bank.dashboard', compact('user', 'auctions', 'trades', 'all', 'pending', 'approved', 'rejected'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
