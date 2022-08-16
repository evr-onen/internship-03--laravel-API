<?php

namespace App;

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\tmpWorkerApp;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {

        $tmp = tmpWorkerApp::where('user_id', $this->id)->get();

        return [
            'name'               => $this->name,
            'store_id'           => $this->store_id,
            'user_spec'          => $this->user_spec,
            'hash'               =>  isset($tmp[0])  ? $tmp[0]->hash : "",
            'sender_id'          =>  isset($tmp[0])  ? $tmp[0]->sender_id : "",
            // "siteUrl"   =>  url('/')

        ];
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'store_id',
        'user_spec'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function storeToUser()
    {
        return $this->hasOne(Store::class, 'store_id', 'id');
    }
    public function tmp()
    {

        return $this->hasOne(tmpWorkerApp::class, 'user_id', 'id');
    }
}
