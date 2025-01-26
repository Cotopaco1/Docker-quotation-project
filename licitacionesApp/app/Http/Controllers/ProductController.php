<?php

namespace App\Http\Controllers;

use App\Exports\GenerateQuotation;
use App\Http\Requests\ProductReplaceRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Searchable\Search;
use ZipArchive;

class ProductController extends Controller
{

    //
    public static function store(ProductStoreRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName =  time() . '_' .  $file->getClientOriginalName(); 
            $filePath = $file->storeAs('products-files', $fileName, 'local'); 
            $validated['url_data'] = $filePath; 
        }
        
        $product = Product::create($validated);

        return response([
            'product' => $product
        ]);
    }
    public static function index()
    {
        return response([
            'products' => Product::all()
        ]);
    }

    public static function search(Request $request)
    {

        
        $searchResults = (new Search())
            ->registerModel(Product::class, 'name')
            ->search($request->input('query'));
        return response([
            'searchResults' => $searchResults
        ]);
    }

    public static function download(Product $product)
    {
        if(!$product->url_data) {
            return response()->json([
                'message' => 'No file found'
            ], 404);
        }
        
        $path = Storage::disk('local')->path($product->url_data);
        $fileName = basename($path);
        return response()->download($path, $fileName, [
            'Content-Type' => mime_content_type($path),
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    public static function quotation(Request $request)
    {
        $items = $request->items;
        $excelData = Excel::raw(new GenerateQuotation($request->profit_percentage, $items), \Maatwebsite\Excel\Excel::XLSX);

        $zip = new ZipArchive();
        $zipFileName = Storage::disk('local')->path('temp/quotation_with_files_'. time() .'.zip');

        if ($zip->open($zipFileName, ZipArchive::CREATE) !== TRUE) {
            return response()->json(['message' => 'No se pudo crear el archivo ZIP'], 500);
        }

        $zip->addFromString('cotizacion-app.xlsx', $excelData);

        foreach($items as $item){
            if(isset($item['url_data']) && !empty($item['url_data'])){
                try {
                    $path = Storage::disk('local')->path($item['url_data']);
                    $fileName = basename($path);
                    $zip->addFile($path, 'fichas-tecnicas/'.$fileName);
                } catch (\Throwable $th) {
                    continue;
                }
                
            }
        }

        $zip->close();

        return response()->download($zipFileName, 'cotizacion-app.zip')->deleteFileAfterSend(true);
        
    }

    public static function destroy(Product $product)
    {
        if($product->url_data){
            Storage::disk('local')->delete($product->url_data);
        }
        $product->delete();
        return response()->noContent(200);
    }

    public static function replace(ProductReplaceRequest $request , Product $product )
    {
        $validated = $request->validated();
        if(isset($validated['url_data'])){
            unset($validated['url_data']);
        }
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName =  time() . '_' .  $file->getClientOriginalName(); 
            $filePath = $file->storeAs('products-files', $fileName, 'local'); 
            $validated['url_data'] = $filePath; 

            if($product->url_data){
                Storage::disk('local')->delete($product->url_data);
            }
        }
        $product->update($validated);

        return response()->noContent(200);
    }
}
