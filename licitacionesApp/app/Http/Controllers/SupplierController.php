<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierStoreRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    //
    public static function store(SupplierStoreRequest $request)
    {

        $validated = $request->validated();

        $supplier = Supplier::create($validated);

        return response([
            'supplier' => $supplier
        ]);
    }
    public static function index()
    {
        $suppliers = Supplier::all();

        return response([
            'suppliers' => $suppliers
        ]);
    }
    public static function replace(SupplierStoreRequest $request, Supplier $supplier)
    {
        $validated = $request->validated();
        $supplier->update($validated);

        return response([
            'supplier' => $supplier
        ]);
    }
    public static function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return response([
            'supplier' => $supplier
        ]);
    }
}
