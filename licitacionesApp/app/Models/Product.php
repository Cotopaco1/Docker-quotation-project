<?php

namespace App\Models;

use App\Models\Supplier;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Search;
/* Spatie sercheable */
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model implements Searchable
{
    use HasFactory;
    //
    protected $fillable = [
        'name',
        'description',
        'unit_price_withouth_tax',
        'description',
        'unit_of_measure',
        'brand',
        'notes',
        'url_data',
        'supplier_id',
    ];

    protected $appends = ['supplier'];

    public function supplier_relation()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
    
    public function getSupplierAttribute()
    {
        return $this->supplier_relation->name ?? null;
    }


    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->name,
        );
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('withSupplier', function ($builder) {
            $builder->with('supplier_relation');
        });
    }

}
