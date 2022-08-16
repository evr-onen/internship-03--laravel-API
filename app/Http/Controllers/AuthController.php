<?php

namespace app\Models;

namespace App\Http\Controllers;

use App\Models\tmpWorkerApp;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'logout']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(Request $request)
    {


      if($request->url){

        $validator = validator()->make(request()->all(), [
            'name'      => 'required | string',
            'email'     => 'required | email',
            'password'  => 'required | string | min:6 | confirmed',


        ]);

        if ($validator->fails()) {
            return response($validator->errors());
        }

        $tmp=tmpWorkerApp::where('hash', '=', $request->url)->first();
        if(!$tmp){
            return response()->json([
                'message' => 'wrong parameters'
            ]);
        }


        $worker=User::where('email', '=', $request->email)->first();

        if(!$worker){
            $worker= new User([
            'name'      => request()->get('name'),
            'email'     => request()->get('email'),
            'password'  => bcrypt(request()->get('password')),
            'email'     => request()->get('email'),
            'user_spec' => 2,
            'store_id'  =>  $tmp->sender_id,
            ]);
            $worker->save();
            return $worker;
        }else{
            $worker->store_id = $tmp->sender_id;
            $worker->user_spec = '2';
            $worker->save();
            return $worker;

        }
    }else{

        $validator = validator()->make(request()->all(), [
            'name'      => 'required | string',
            'email'     => 'required | email',
            'password'  => 'required | string | min:6 | confirmed',


        ]);

        if ($validator->fails()) {
            return response($validator->errors());
        }

        $user = User::create([
            'name'      => request()->get('name'),
            'email'     => request()->get('email'),
            'password'  => bcrypt(request()->get('password')),
            'email'     => request()->get('email'),
            'user_spec' => 3,
            'store_id'  => 0,
        ]);
        $user->save();

        return   $user;
    }


    }


    public function login()
    {

        $credentials = request(['email', 'password']);
        // return auth();
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }




    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 600000
        ]);
    }
}
