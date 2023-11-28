<?php

namespace App\Http\Controllers\FMDQ;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Security;
use Illuminate\Http\Request;

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
        $securities = Security::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->where('modifyingFlag', 0)->where('deletingFlag', 0)->orderBy('createdDate', 'DESC')->get();
        $all = Auction::where('deleteFlag', 0)->count();
        $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->count();

        return view('fmdq.trade.index', compact('securities', 'auctions', 'all', 'pending', 'approved', 'rejected', 'page'));
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
        $page = 'Pending Auctions';
        $auctions = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->orderBy('createdDate', 'DESC')->get();
        $all = Auction::count();
        $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->count();

        return view('fmdq.trade.pending', compact('auctions', 'all', 'pending', 'approved', 'rejected', 'page'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $page = 'Rejected Auctions';
        $securities = Security::where('status', '1')->orderBy('CreatedDate', 'DESC')->get();
        $auctions = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->orderBy('createdDate', 'DESC')->get();
        $all = Auction::count();
        $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->count();

        return view('fmdq.trade.rejected', compact('securities', 'auctions', 'all', 'pending', 'approved', 'rejected', 'page'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $page = 'Rejected Auctions';
        $securities = Security::where('status', '1')->orderBy('CreatedDate', 'DESC')->get();
        $auctions = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->orderBy('createdDate', 'DESC')->get();
        $all = Auction::count();
        $approved = Auction::where('approveFlag', 1)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $pending = Auction::where('approveFlag', 0)->where('rejectionFlag', 0)->where('deleteFlag', 0)->count();
        $rejected = Auction::where('approveFlag', 0)->where('rejectionFlag', 1)->where('deleteFlag', 0)->count();

        return view('fmdq.trade.rejected', compact('securities', 'auctions', 'all', 'pending', 'approved', 'rejected', 'page'));
    }

}
