<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use DB;
use App\Services\UploadFile;
use App\Services\ApiResponseService;

class DefaultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @author Razib Al Mamun
     */
    public function index(ApiResponseService $apiResponseService, Request $request)
    {
        $productList = ProductResource::collection(Product::filter($request)->get());
        return $apiResponseService->efflux($productList); 
    }
}
