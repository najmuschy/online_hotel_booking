<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;
use App\Models\Customer ;
use App\Models\Order;
use App\Models\OrderDetail ;

class CustomerOrderController extends Controller
{
    public function index(){

        $orders = Order::where('customer_id',Auth::guard('customer')->user()->id)->get() ;
        return view('customer.orders', compact('orders')) ;
    }

    public function invoice($id){
        
        $orders = Order::where('id',$id)->first() ;
        $orders_detail = OrderDetail::where('order_id',$id)->get() ;
        return view('customer.invoice', compact('orders','orders_detail')) ;
    }
}
