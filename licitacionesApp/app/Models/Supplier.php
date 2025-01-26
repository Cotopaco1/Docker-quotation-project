<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $fillable = [
        'name',
        'email',
        'identification',
        'phone',
        'address',
        'city',
        'website',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
