<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    public function response_api($status, $message, $items = null)
    {
        $response = ['status' => $status, 'message' => $message];
        if ($status && isset($items)) {
            $response['item'] = $items;
        } else {
            $response['errors_object'] = $items;
        }
        return response()->json($response, $status);
    }
    
    public function exMessage($e)
    {
        return $e->getMessage();
    }
    
    public function filterDataTable($items, $request,$take = null,$resource = null)
    {
        if ($items->count() <= 0) {
            $data['recordsTotal'] = 0;
            $data['recordsFiltered'] = 0;
            $data['data'] = [];
            return $data;
        }

        if (!$resource) {
            $resource = $items->first()->resource;
        }

        if (isset($take)) {
            $items = $items->take($take)->get();
            $data = $resource->collection($items);
            return $data;
        }
        $per_page = isset($request->length) ? $request->length : 10;
        $start = isset($request->start) ? $request->start : 0;
        if ($per_page == -1 || $per_page == null) {
            $per_page = 10;
        }
        $itemsCount = $items->count();
        $items = $items->skip($start)->take($per_page)->get();
        $data['recordsTotal'] = $itemsCount;
        $data['recordsFiltered'] = $itemsCount;
        $data['data'] = $resource::collection($items);
        return $data;
    }
}
