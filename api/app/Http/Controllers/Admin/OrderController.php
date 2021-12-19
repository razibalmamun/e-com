<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use DB;
use App\Services\ApiResponseService;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @author Razib Al Mamun
     */
    public function index(ApiResponseService $apiResponseService, Request $request)
    {
        $orders = OrderResource::collection(Order::filter($request)->get());
        return $apiResponseService->efflux($orders); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author Razib Al Mamun
     */
    public function store(ApiResponseService $apiResponseService, Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author Razib Al Mamun
     */
    public function show(ApiResponseService $apiResponseService, Order $order)
    {
        $single = new OrderResource($order);
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
    public function update(ApiResponseService $apiResponseService, Request $request, Order $order)
    {
        DB::beginTransaction();
        try {
            $fillableData = $request->only($order->getFillable());
            $order->fill($fillableData)->update();
            DB::commit();

            $single = new OrderResource($order);
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
    public function delete(ApiResponseService $apiResponseService, Order $order)
    {
        DB::beginTransaction();
        try {
            $order->delete();
            $order->details()->delete();
            DB::commit();
            return $apiResponseService->efflux($order->id);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            return $apiResponseService->efflux(null, $th->getMessage());
        }
    }
}
