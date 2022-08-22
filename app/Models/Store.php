<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Image;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'address',
        'phone',
        'status',
    ];

    public function storeToUser()
    {
        // $this->hasOne(Main::class, 'id', 'main_id');
        return $this->hasOne(User::class, 'store_id', 'id');
    }
public function storeToProducts()
    {
        // $this->hasOne(Main::class, 'id', 'main_id');
        return $this->hasMany(StoreProduct::class, 'store_id', 'id');
    }
    
    public function images()
    {

        return $this->morphMany(Image::class, 'imagetable');
    }
}
