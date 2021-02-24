<?php

namespace Bernhardh\NovaDynamicViews\Http\Controllers;

use Illuminate\Routing\Controller;
use \Laravel\Nova\Http\Requests\ResourceDetailRequest;
use \Illuminate\Support\Str;
/**
 * Class NovaDynamicViewsController
 * @package Bernhardh\NovaDynamicViews\Http\Controllers
 */
class NovaDynamicViewsController extends Controller
{
    /**
     * @param ResourceDetailRequest $request
     * @param $resource
     * @param $method
     * @return array
     */
    public function resourceRequestDetails(ResourceDetailRequest $request, $resource, $method) {
        $resourceClass = $request->resource();
        $model = $request->model();
        $method = Str::camel('custom-' . $method . '-components');
        $resource = new $resourceClass($model);

        if(method_exists($resource, $method)) {
            $data = $resource->$method();
            if($data) {
                return $data;
            }
        }

        return [];
    }
}