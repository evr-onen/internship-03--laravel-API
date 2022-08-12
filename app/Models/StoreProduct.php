<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'product_id',
        'price',
        'stock',
    ];

    public function storeToProduct()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
