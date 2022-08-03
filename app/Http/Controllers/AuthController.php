<?php
namespace app\Models;
namespace App\Http\Controllers;

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
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(Request $request)
    {
        
        $validator= validator()->make(request()->all(),[
            'name'      => 'required | string',
            'email'     => 'required | email',
            'password'              => 'required | string | min:6 | confirmed',
            

        ]);
        
        if($validator->fails()){
            return response($validator->errors());
            
        }
        $user = User::create([
            'name'      => request()-> get('name'),
            'email'     => request()-> get('email'),
            'password'  => bcrypt( request()-> get('password')),
            'email'     => request()-> get('email'),
            'user_spec' => !empty(request()->get('user_spec'))?request()->get('user_spec'):"3" ,
            'store_id'  => !empty(request()->get('store_id'))?request()->get('store_id'):"0",
        ]);
            return   $user;
}


    public function login()
    {
        $credentials = request(['email', 'password']);
        /* claims(['nam'=> 'Evren'])-> */
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized a'], 401);
        }
        
        return $this->respondWithToken(['token' => $token,  auth()->user()]);
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
