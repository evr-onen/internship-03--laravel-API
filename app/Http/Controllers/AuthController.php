<?php
namespace app\Models;
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

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

    public function register()
    {
        $validator= validator()->make(request()->all(),[
            'name'      => 'required | string',
            'email'     => 'required | email',
            'password'  => 'required | string | min:6',
            'password_confirmation' => 'required_with:password|same:password|min:6',

        ]);

        if($validator->fails()){
            return response()-> json([
                'message'   => request()-> get('name'). ' '. request()-> get('email'). ' ' . request()-> get('password')
            ]);
        }
        $user = User::create([
            'name'      => request()-> get('name'),
            'email'     => request()-> get('email'),
            'password'  => bcrypt( request()-> get('password')),
            'email'     => request()-> get('email'),
            'user_spec' => !empty(request()->get('user_spec'))?request()->get('user_spec'):"3" ,
            'store_id'  => !empty(request()->get('store_id'))?request()->get('store_id'):"0",
        ]);
return response()-> json([
    'message'   => 'User Created',
    'user'      => $user
]);
}


    public function login()
    {
        $credentials = request(['email', 'password']);
        
        if (! $token = auth()->claims(['nam'=> 'Evren'])->attempt($credentials)) {
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
