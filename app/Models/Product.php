<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use App\Models\StoreProduct;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'cat_id',

    ];

    public function category()
    {
        return $this->hasMany(Category::class, 'id', 'cat_id');
    }



    public function images()
    {

        return $this->morphMany(Image::class, 'imagetable');
    }

    public function productToSore()
    {

        return $this->belongsToMany(StoreProduct::class, "id", "product_id");
    }
}
