<?php

namespace App\Http\Controllers\Admin;


use App\Order;
use App\Services\UserService;
use App\Http\Resources\OrderResource;

class OrderController
{

    public function index()
    {
        (new UserService())->allows('view', 'orders');

        $orders = Order::paginate();

        return OrderResource::collection($orders);
    }

    public function show($id)
    {
        (new UserService())->allows('view', 'orders');

        $order = Order::findOrFail($id);

        return new OrderResource($order);
    }

    public function export()
    {
        (new UserService())->allows('view', 'orders');

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=orders.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $callback = function () {
            $orders = Order::all();
            $file = fopen('php://output', 'w');

            //Header Row
            fputcsv($file, ['ID', 'Name', 'Email', 'Order Title', 'Price', 'Quantity']);

            //Body
            foreach ($orders as $order) {
                fputcsv($file, [$order->id, $order->name, $order->email, '', '', '']);

                foreach ($order->orderItems as $orderItem) {
                    fputcsv($file, ['', '', '', $orderItem->product_title, $orderItem->product_price, $orderItem->quantity]);
                }
            }

            fclose($file);
        };

        return \Response::stream($callback, 200, $headers);
    }
}
