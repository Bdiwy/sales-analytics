<?php

namespace App\Services;

use App\Events\OrderCreated;
use App\Repo\OrderRepo;

class OrderService
{
    protected $orderRepo;

    public function __construct(OrderRepo $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function createOrder(array $data)
    {
        $order = $this->orderRepo->createOrder($data);
        event(new OrderCreated($order));
        return $order;
    }

    public function getAllOrders()
    {
        return $this->orderRepo->getAllOrders();
    }

    public function getOrderById($id)
    {
        return $this->orderRepo->getOrderById($id);
    }

    public function updateOrder($id, array $data)
    {
        return $this->orderRepo->updateOrder($id, $data);
    }

    public function deleteOrder($id)
    {
        return $this->orderRepo->deleteOrder($id);
    }

    public function getTotalSales()
    {
        return $this->orderRepo->getTotalSales();
    }

    public function getOrdersBy($condition)
    {
        return $this->orderRepo->getOrdersBy($condition);
    }
}
