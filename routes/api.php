<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

 Route::get('{resource}/{method}', function (\Laravel\Nova\Http\Requests\ResourceDetailRequest $request, $resource, $method) {
     $resourceClass = $request->resource();
     $model = $request->model();
     $method = \Illuminate\Support\Str::camel('custom-' . $method . '-components');
     $resource = new $resourceClass($model);
     
     if(method_exists($resource, $method)) {
        $data = $resource->$method();
        if($data) {
            return $data;
        }
     }
     
     return [];
 });
