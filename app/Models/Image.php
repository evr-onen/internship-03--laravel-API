<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'path',
        'image_for',
        'imagetable_type',
        'imagetable_id',
        'status',
    ];
    public function imagetable()
    {

        return $this->morphTo();
    }
}
