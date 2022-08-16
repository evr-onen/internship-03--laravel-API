<?php

namespace App\Http\Controllers;

use App\Mail\Worker;
use Illuminate\Support\Facades\Hash;
use App\Models\tmpWorkerApp;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;




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
            'user_mail'        => 'required | email',


        ]);
        if ($validator->fails()) {
            return response($validator->errors());
        }



        $createApp = new tmpWorkerApp();

        $createApp->sender_id = $request->sender_id;
        $createApp->user_id = $request->user_mail;
        $createApp->status = 1;
        $createApp->hash = rand();
        $createApp->save();

        $email = $request->user_id;

        $array = [
            'hashmail' => "localhost:3000/register-user?key=" . $createApp->hash
        ];
        Mail::to($request->user_mail)->send(new Worker($array));

        // Mail::send('mail', $array, function ($message) use ($email) {
        //     $message->subject('worker Application');
        //     $message->to($email);
        // });


           return $createApp;
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
        return   tmpWorkerApp::where('sender_id', $id)->with('User')->get();
    }

    public function showAll(tmpWorkerApp $tmpWorkerApp, $id)
    {
        return   tmpWorkerApp::where('sender_id', 5)->with('User');
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
    public function destroy(tmpWorkerApp $tmpWorkerApp, $id)
    {
        return tmpWorkerApp::whereId($id)->delete();
    }
}
