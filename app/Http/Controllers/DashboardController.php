<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class DashboardController extends Controller
{

    public function __construct(){
        $this->middleware('checkRole');
    }

    function show(){
        $num_per_page=5;
        $orders= Order::orderBy('created_at','desc')->paginate($num_per_page);
        $count_order_active= Order::count();
        $count_order_trash= Order::onlyTrashed()->count();
        return view('admin/dashboard',compact('orders','num_per_page','count_order_active','count_order_trash'));
    }
}
