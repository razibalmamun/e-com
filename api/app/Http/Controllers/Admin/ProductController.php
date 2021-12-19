<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use DB;
use App\Services\UploadFile;
use App\Services\ApiResponseService;

class ProductController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author Razib Al Mamun
     */
    public function store(ApiResponseService $apiResponseService, ProductRequest $request, UploadFile $uploadFile)
    {
        DB::beginTransaction();
        try {
            $product = new Product();
            $fillableData = $request->only($product->getFillable());
            $product->fill($fillableData)->save();
            $product->image()->create(['filename' => $uploadFile->imageUpload($request)]);
            DB::commit();

            $single = new ProductResource($product);
            return $apiResponseService->efflux($single); 
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            return $apiResponseService->efflux(null, $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author Razib Al Mamun
     */
    public function show(ApiResponseService $apiResponseService, Product $product)
    {
        $single = new ProductResource($product);
        return $apiResponseService->efflux($single); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author Razib Al Mamun
     */
    public function update(ApiResponseService $apiResponseService, ProductRequest $request, Product $product, UploadFile $uploadFile)
    {
        DB::beginTransaction();
        try {
            $fillableData = $request->only($product->getFillable());
            $product->fill($fillableData)->update();
            if($request->image) {
                $product->image()->update(['filename' => $uploadFile->imageUpload($request)]);
            }
            DB::commit();

            $single = new ProductResource($product);
            return $apiResponseService->efflux($single);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            return $apiResponseService->efflux(null, $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author Razib Al Mamun
     */
    public function delete(ApiResponseService $apiResponseService, Product $product)
    {
        DB::beginTransaction();
        try {
            $product->delete();
            DB::commit();
            return $apiResponseService->efflux($product->id);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            return $apiResponseService->efflux(null, $th->getMessage());
        }
    }
}
