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

    public function getAllOrders($perPage = 10)
    {
        return DB::table($this->table)->paginate($perPage);
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

    public function getTotalSales()
    {
        return DB::table($this->table)->sum('price');
    }

    public function getMostSoldProductPrice()
    {
        $product= DB::table($this->table)
                    ->select('product_name', \DB::raw('SUM(quantity) as total_quantity'))
                    ->groupBy('product_name')
                    ->orderByDesc('total_quantity')
                    ->first();
        return response()->json($product);
    }

    public function getMostSoldProducts()
    {
        return DB::table($this->table)
                    ->select('product_name', \DB::raw('SUM(quantity) as total_quantity'))
                    ->groupBy('product_name')
                    ->orderByDesc('total_quantity')
                    ->get();
    }
}
