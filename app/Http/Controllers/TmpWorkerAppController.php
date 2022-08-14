<?php

namespace App\Http\Controllers;

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

        $user = User::where('email', $request->user_mail)->get();

        $createApp = new tmpWorkerApp();

        $createApp->sender_id = $request->sender_id;

        $createApp->user_id = $user[0]->id;
        $createApp->status = 1;

        $createApp->hash = rand();
        $createApp->save();

        $email = $request->user_mail;

        $array = [
            'hashmail' => "localhost:3000/" . $createApp->hash
        ];

        Mail::send('mail', $array, function ($message) use ($email) {
            $message->subject('worker Application');
            $message->to('evr.onen@gmail.com');
        });

        // Mail::send('mail.worker',  $array, function ($message) use ($email) {
        //     $message->to($data['email'])
        //         ->subject($data['subject']);
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
