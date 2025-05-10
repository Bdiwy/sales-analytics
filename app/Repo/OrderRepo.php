<?php

namespace App\Repo;

use Illuminate\Support\Facades\DB;

class OrderRepo
{
    protected $table = 'orders';

    public function createOrder(array $data)
    {
        $id = DB::table($this->table)->insertGetId($data);
        return DB::table($this->table)->where('id', $id)->select([
            'id',
            'product_name',
            'quantity',
            'price',
            'created_at'
        ])->first();
    }

    public function getAllOrders()
    {
        return DB::table($this->table)->get();
    }

    public function getOrderById($id)
    {
        return DB::table($this->table)->where('id', $id)->first();
    }

    public function updateOrder($id, array $data)
    {
        $updated = DB::table($this->table)->where('id', $id)->update($data);
        return $updated ? DB::table($this->table)->where('id', $id)->first() : null;
    }

    public function deleteOrder($id)
    {
        return DB::table($this->table)->where('id', $id)->delete() > 0;
    }

    public function getOrdersByDateRange($startDate, $endDate)
    {
        return DB::table($this->table)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
    }

    public function getTotalSales()
    {
        return DB::table($this->table)->sum('price');
    }

    public function getOrdersBy($condition)
    {
        return DB::table($this->table)->where($condition)->get();
    }
}
