<?php

namespace App\Http\Controllers\inputter;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Security;
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
        $securities = Security::orderBy('CreatedDate', 'DESC')->get();
        $all = Security::count();
        $approved = Security::where('ApproveFlag', '1')->count();
        $pending = Security::where('ApproveFlag', '0')->where('RejectionFlag', '0')->count();
        $rejected = Security::where('RejectionFlag', '1')->count();

        $auctioneers = Profile::where('status', '1')->where(function ($query) {
            $query->where('Package', '7')->orWhere('Package', '9')->orWhere('Package', '11');
        })->get();

        return view('inputter.certificate', compact('user', 'securities', 'all', 'pending', 'approved', 'rejected', 'page', 'auctioneers'));

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
