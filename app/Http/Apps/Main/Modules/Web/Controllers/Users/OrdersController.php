<?php

namespace App\Http\Apps\Main\Modules\Web\Controllers\Users;

use App\Classes\Base\Routing\Controller;

class OrdersController extends Controller
{
    public function getOrders()
    {
        $user = _user();
        $paginator = $user->orders()->with("transactions")->latest()->_basePaginate(["limit" => 18]);
        return view("pages.users.orders", ["paginator" => $paginator]);
    }
    public function getOrder($order_id)
    {
        $user = _user();
        $order = $user->orders()->findOrFail($order_id);
        $order->load("items.productSu.product.image", "address");
        return view("pages.users.order-detail", ["order" => $order]);
    }
    public function getPayOrder($order_id)
    {
        $user = _user();
        $order = $user->orders()->findOrFail($order_id);
        if ($order->status !== "pending") _http_abort(403);
        return $order->payWithIPG($user);
    }
}
