<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Http\Request;

class CustomerHomeController extends Controller
{
    public function index(){
        $total_completed_orders = Order::where('status','Completed')->where('customer_id',Auth::guard('customer')->user()->id)->count();
        $total_pending_orders = Order::where('status','Pending')->where('customer_id',Auth::guard('customer')->user()->id)->count();
        return view('customer.home',compact('total_completed_orders', 'total_pending_orders')) ;
    }
}
