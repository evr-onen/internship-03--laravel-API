<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\tmpWorkerApp;
use Illuminate\Http\Request;

class TmpWorkerAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $validator = validator()->make(request()->all(), [
            'sender_id'      => 'required | integer',
            'user_id'        => 'required | integer',
            'status'         => 'required | integer',

        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }
        $createApp = new tmpWorkerApp();
        $createApp->sender_id = $request->sender_id;
        $createApp->sender_id = $request->user_id;
        $createApp->sender_id = $request->status;

        //$key = base64_encode(Hash::make(eee));
        $createApp->hash = $request->rand();
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
     * @param  \App\Models\tmpWorkerApp  $tmpWorkerApp
     * @return \Illuminate\Http\Response
     */
    public function show(tmpWorkerApp $tmpWorkerApp, $id)
    {
        return   tmpWorkerApp::with('User')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tmpWorkerApp  $tmpWorkerApp
     * @return \Illuminate\Http\Response
     */
    public function edit(tmpWorkerApp $tmpWorkerApp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tmpWorkerApp  $tmpWorkerApp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tmpWorkerApp $tmpWorkerApp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tmpWorkerApp  $tmpWorkerApp
     * @return \Illuminate\Http\Response
     */
    public function destroy(tmpWorkerApp $tmpWorkerApp)
    {
        //
    }
}
