<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\SecurityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = Auth::user();
        $types = SecurityType::all();
        return view('fmdq.settings.security-type', compact('user', 'types'));
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
        $user = Auth::user();
        //
        $validated = $request->validate([
            'securityTypeCode' => 'unique:tblSecurityType',
        ], [
            'securityTypeCode.unique' => 'This security code has already been registered.',
        ]);
        //
        if ($validated) {
            $type = new SecurityType();
            $type->securityTypeCode = $request->securityTypeCode;
            $type->description = $request->description;
            $create = $type->save();
            //
            if ($create) {
                // log activity
                $activity = new ActivityLog();
                $activity->date = now();
                $activity->app = 'RITCC';
                $activity->type = 'Create Security Type';
                $activity->activity = $user->email . ' created a security type named: ' . $request->code . '.';
                $activity->username = $user->email;
                $log = $activity->save();
            }
            if ($log) {
                return redirect()->back()->with('success', "Security Type created.");
            }
        } else {
            // If there are validation errors, you can return to the form with the errors
            return back()->withErrors($validated);
        }
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
    public function update(Request $request)
    {
        $user = Auth::user();
        $id = $request->id;
        $type = SecurityType::findOrFail($id);
        $type->securityTypeCode = $request->securityTypeCode;
        $type->description = $request->description;
        $update = $type->save();
        //
        if ($update) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Update Security Type';
            $activity->activity = $user->email . ' updated a security type.';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            return redirect()->back()->with('success', "Security type updated.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $user = Auth::user();
        $id = $request->id;
        $type = SecurityType::findOrFail($id);
        $delete = $type->delete();
        //
        if ($delete) {
            // log activity
            $activity = new ActivityLog();
            $activity->date = now();
            $activity->app = 'RITCC';
            $activity->type = 'Delete Security Type';
            $activity->activity = $user->email . ' deleted an security type .';
            $activity->username = $user->email;
            $log = $activity->save();
        }
        if ($log) {
            return redirect()->back()->with('success', "Security type deleted.");
        }
    }
}
