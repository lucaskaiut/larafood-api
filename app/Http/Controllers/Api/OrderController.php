<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrder;
use App\Http\Requests\Api\TenantFormRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(StoreOrder $request)
    {
        $order = $this->orderService->createNewOrder($request->all());

        return new OrderResource($order);
    }

    public function show(Request $request)
    {
        if(!$request->identify)
            return response()->json(['message' => 'The order identify is required'], 400);
        if(!$order = $this->orderService->getOrderByIdentify($request->identify))
            return response()->json(['message' => 'Order Not Found'], 404);

        return new OrderResource($order);
    }

    public function getClientAuthenticatedOrders()
    {
        $orders = $this->orderService->getClientAuthenticatedOrders();

        return OrderResource::collection($orders);
    }
}
