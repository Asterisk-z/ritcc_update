<?php

namespace App\Http\Controllers\FMDQ;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Profile;
use App\Models\Security;
use Illuminate\Http\Request;

class AuctionManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'All Auctions';
        $securities = Security::where('status', '1')->orderBy('CreatedDate', 'ASC')->get();

        $institutions = Auction::orderBy('CreatedDate', 'ASC')->get();
        $all = Auction::count();
        $approved = Auction::where('status', '1')->count();
        $pending = Auction::where('status', '0')->orWhere('status', '3')->orWhere('status', '4')->count();
        $rejected = Auction::where('status', '2')->count();
        $authorisers = Profile::where('status', '1')->where(function ($query) {
            $query->where('Package', '3')->orWhere('Package', '5');
        })->get();

        return view('fmdq.auction.index', compact('securities', 'institutions', 'all', 'pending', 'approved', 'rejected', 'page', 'authorisers'));
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
