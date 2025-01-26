<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralQuerys extends Controller
{
    //
    /* Solo retorna las columnas 'id' y 'name' de cada modelo. */
    public static function list(Request $request)
    {
        $query = $request->query('list');
        $data = [];

        $models = explode(',', $query);
        
        foreach($models as $modelName){
            $model = "App\Models\\$modelName" ;
            $data[$modelName] = $model::query()->select('id', 'name')->get();
        }

        return response([
            'data' => $data
        ]);
        

    }

}
