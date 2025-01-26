<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    //
    protected $fillable = [
        'name',
        'tax_percentage',
        'tax_multiplier',
        'total_with_tax_multiplier'
    ];
}
