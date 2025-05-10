<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function create(OrderRequest $request)
    {
        $validatedData = $request->validated();
        $order = $this->orderService->createOrder($validatedData);
    
        return response()->json(new OrderResource((object) $order), 201);
    }

    public function getAllOrders(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $orders = $this->orderService->getAllOrders($perPage);

        return response()->json([
            'data' => OrderResource::collection($orders),
            'links' => [
                'prev' => $orders->previousPageUrl(),
                'next' => $orders->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $orders->currentPage(),
                'total_pages' => $orders->lastPage(),
                'total_items' => $orders->total(),
            ]
        ]);
    }


    public function getOrderById($id)
    {
        $order = $this->orderService->getOrderById($id);

        if ($order) {
            return response()->json(new OrderResource((object) $order));
        }

        return response()->NotFound('Order not found');
    }

    public function updateOrder(OrderRequest $request, $id)
    {
        $validatedData = $request->validated();
        $order = $this->orderService->updateOrder($id, $validatedData);

        if ($order) {
            return response()->json(new OrderResource((object) $order));
        }

        return response()->NotFound('Order not found');
    }

    public function deleteOrder($id)
    {
        $deleted = $this->orderService->deleteOrder($id);

        if ($deleted) {
            return response()->json(['message' => 'Order deleted successfully']);
        }

        return response()->NotFound('Order not found');
    }

    public function getOrdersByDateRange(Request $request)
    {
        $orders = $this->orderService->getOrdersByDateRange(
            $request->input('start_date'),
            $request->input('end_date')
        );

        return response()->json(OrderResource::collection(collect($orders)));
    }

    public function getTotalSales()
    {
        $totalSales = $this->orderService->getTotalSales();

        return response()->json(['total_sales' => $totalSales]);
    }

    public function getOrdersBy(Request $request)
    {
        $orders = $this->orderService->getOrdersBy($request->input('condition'));

        return response()->json(OrderResource::collection(collect($orders)));
    }
}
