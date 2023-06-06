<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Mail ;
use App\Models\Admin ;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order ;
use App\Models\OrderDetail;
use App\Models\Room;
use App\Mail\WebsiteMail ;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Order as ApiOrder;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;


class BookingController extends Controller
{
    public function cart_submit(Request $request)
    {

        $request->validate([
            'room_id' => 'required',
            'checkin_checkout' => 'required',
            'adult' => 'required'
        ]);

        $date = explode('-', $request->checkin_checkout);
        $checkin_date = $date[0];
        $checkout_date = $date[1];

        session()->push('cart_room_id', $request->room_id);
        session()->push('cart_checkin_date', $checkin_date);
        session()->push('cart_checkout_date', $checkout_date);
        session()->push('cart_adult', $request->adult);
        session()->push('cart_children', $request->children);

        return redirect()->back()->with('success', 'Room is added to cart successfully');
    }
    public function cart_view()
    {
        return view('front.cart');
    }
    public function cart_delete($id)
    {


        $arr_cart_room_id = array();
        $i = 0;
        foreach (session()->get('cart_room_id') as $value) {
            $arr_cart_room_id[$i] = $value;
            $i++;
        }

        $arr_cart_checkin_date = array();
        $i = 0;
        foreach (session()->get('cart_checkin_date') as $value) {
            $arr_cart_checkin_date[$i] = $value;
            $i++;
        }

        $arr_cart_checkout_date = array();
        $i = 0;
        foreach (session()->get('cart_checkout_date') as $value) {
            $arr_cart_checkout_date[$i] = $value;
            $i++;
        }

        $arr_cart_adult = array();
        $i = 0;
        foreach (session()->get('cart_adult') as $value) {
            $arr_cart_adult[$i] = $value;
            $i++;
        }

        $arr_cart_children = array();
        $i = 0;
        foreach (session()->get('cart_children') as $value) {
            $arr_cart_children[$i] = $value;
            $i++;
        }

        session()->forget('cart_room_id');
        session()->forget('cart_checkin_date');
        session()->forget('cart_checkout_date');
        session()->forget('cart_adult');
        session()->forget('cart_children');

        for ($i = 0; $i < count($arr_cart_room_id); $i++) {
            if ($arr_cart_room_id[$i] == $id) {
                continue;
            } else {
                session()->push('cart_room_id', $arr_cart_room_id[$i]);
                session()->push('cart_checkin_date', $arr_cart_checkin_date[$i]);
                session()->push('cart_checkout_date', $arr_cart_checkout_date[$i]);
                session()->push('cart_adult', $arr_cart_adult[$i]);
                session()->push('cart_children', $arr_cart_children[$i]);
            }
        }

        return redirect()->back()->with('success', 'Cart item is deleted.');
    }

    public function checkout()
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->back()->with('error', 'You must have to login in order to checkout');
        }

        if (!session()->has('cart_room_id')) {
            return redirect()->back()->with('error', 'There is no item in the cart');
        }

        return view('front.checkout');
    }
    public function payment(Request $request)
    {

        if (!Auth::guard('customer')->check()) {
            return redirect()->back()->with('error', 'You must have to login in order to checkout');
        }
        if (!session()->has('cart_room_id')) {
            return redirect()->back()->with('error', 'There is no item in the cart');
        }

        $request->validate([
            'billing_name' => 'required',
            'billing_email' => 'required|email',
            'billing_phone' => 'required',
            'billing_country' => 'required',
            'billing_address' => 'required',
            'billing_state' => 'required',
            'billing_city' => 'required',
            'billing_zip' => 'required'
        ]);

        session()->put('billing_name', $request->billing_name);
        session()->put('billing_email', $request->billing_email);
        session()->put('billing_phone', $request->billing_phone);
        session()->put('billing_country', $request->billing_country);
        session()->put('billing_address', $request->billing_address);
        session()->put('billing_state', $request->billing_state);
        session()->put('billing_city', $request->billing_city);
        session()->put('billing_zip', $request->billing_zip);
        return view('front.payment');
    }
    public function paypal($final_price){

        
        $client = 'Ae9gKjaNXuzE73EYuAVsa4r9eDALwCvrNlleYS9vK6i8cTYTW7NwpxADqRVylrYaeJSxUxOvTafqSlGH' ;
        $secret = 'EI4BrYwE6l5wcYs4Zy8sBsbj4UAWXEzPJrhs7EIbJrvbz2KwZmItW-y1uJ61V9IcB4B9rCUqE6k5VQJr' ;
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $client, // ClientID
                $secret // ClientSecret
            )
        );

        $paymentId = request('paymentId');
        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));

        $transaction = new Transaction();
        $amount = new Amount();
        $details = new Details();

        $details->setShipping(0)
            ->setTax(0)
            ->setSubtotal($final_price);

        $amount->setCurrency('USD');
        $amount->setTotal($final_price);
        $amount->setDetails($details);
        $transaction->setAmount($amount);

        $execution->addTransaction($transaction);

        $result = $payment->execute($execution, $apiContext);

        if($result->state == 'approved')
        {
            $paid_amount = $result->transactions[0]->amount->total;

            $order_no=time() ;

            $statement = DB::select("SHOW TABLE STATUS LIKE 'orders'");
            $ai_id = $statement[0]->Auto_increment;

            // echo $paid_amount ;
            
            $obj = new Order() ;
            $obj->customer_id = Auth::guard('customer')->user()->id ;
            $obj->order_no = $order_no;
            $obj->transaction_id = $result->id ;
            $obj->payment_method = 'Paypal' ;
            $obj->paid_amount = $paid_amount ;
            $obj->booking_date = date('d/m/Y') ;
            $obj->status = 'Completed' ;
            $obj->save() ;

            $arr_cart_room_id = array();
            $i = 0;
            foreach (session()->get('cart_room_id') as $value) {
                $arr_cart_room_id[$i] = $value;
                $i++;
            }

            $arr_cart_checkin_date = array();
            $i = 0;
            foreach (session()->get('cart_checkin_date') as $value) {
                $arr_cart_checkin_date[$i] = $value;
                $i++;
            }

            $arr_cart_checkout_date = array();
            $i = 0;
            foreach (session()->get('cart_checkout_date') as $value) {
                $arr_cart_checkout_date[$i] = $value;
                $i++;
            }

            $arr_cart_adult = array();
            $i = 0;
            foreach (session()->get('cart_adult') as $value) {
                $arr_cart_adult[$i] = $value;
                $i++;
            }

            $arr_cart_children = array();
            $i = 0;
            foreach (session()->get('cart_children') as $value) {
                $arr_cart_children[$i] = $value;
                $i++;
            }

            for ($i = 0; $i < count($arr_cart_room_id); $i++){
            
            $r_info = Room::where('id', $arr_cart_room_id[$i])->first() ;
            $d1 = explode('/',$arr_cart_checkin_date[$i]);
            $d2 = explode('/',$arr_cart_checkout_date[$i]);
            $d1_new = $d1[0].'-'.$d1[1].'-'.$d1[2];
            $d2_new = $d2[0].'-'.$d2[1].'-'.$d2[2];
            $t1 = strtotime($d1_new);
            $t2 = strtotime($d2_new);
            $diff = ($t2-$t1)/60/60/24;
            $sub = $r_info->price*$diff;  

            $obj = new OrderDetail() ;
            $obj->order_id = $ai_id ;
            $obj->room_id = $arr_cart_room_id[$i];
            $obj->order_no = $order_no ;
            $obj->checkin_date = $arr_cart_checkin_date[$i] ;
            $obj->checkout_date =$arr_cart_checkout_date[$i] ;
            $obj->adult = $arr_cart_adult[$i] ;
            $obj->children = $arr_cart_children[$i] ;
            $obj->subtotal = $sub ;
            $obj->save() ;

            $subject =' New Order' ;
            $message ='You have made an order for booking a room. The booking info is shown here: <br>' ;
            $message .= 'Order No.: '.$order_no.'<br>' ;
            $message .= 'Transaction ID: '.$result->id.'<br>' ;
            $message .= 'Paid Method: Paypal <br>' ;
            $message .= 'Paid Amount: '.$paid_amount.'<br>' ;
            $message .= 'Booked on: '.date('d/m/Y').'<br>' ;
            
            for($i=0; $i<count($arr_cart_room_id); $i++){
                
                $r_info = Room::where('id', $arr_cart_room_id[$i])->first() ;
                $message .= '<br>'.'Room Name: '.$r_info->name.'<br>' ;
                $message .= 'Price/Night: '.$r_info->price.'<br>' ;
                $message .= 'Checkin Date: '.$arr_cart_checkin_date[$i].'<br>' ;
                $message .= 'Checkout Date: '.$arr_cart_checkout_date[$i].'<br>' ;
                $message .= 'Checkout Date: '.$arr_cart_checkout_date[$i].'<br>' ;
                $message .= 'Adult: '.$arr_cart_adult[$i].'<br>' ;
                $message .= 'Children: '.$arr_cart_children[$i].'<br>' ;
            }

            
            $customer_email =  Auth::guard('customer')->user()->email ;
            Mail::to($customer_email )->send(new Websitemail($subject, $message)) ;

            session()->forget('cart_room_id') ;
            session()->forget('billing_name' );
            session()->forget('billing_email' );
            session()->forget('billing_phone' );
            session()->forget('billing_country');
            session()->forget('billing_address');
            session()->forget('billing_state' );
            session()->forget('billing_city');
            session()->forget('billing_zip' );

            session()->forget('cart_room_id');
            session()->forget('cart_checkin_date');
            session()->forget('cart_checkout_date');
            session()->forget('cart_adult' );
            session()->forget('cart_children');
            }
            
            



            return redirect()->route('home')->with('success', 'Payment is successful') ;
        }
        else{
            
            return redirect()->route('home')->with('error', 'Payment failed') ;
        }

    }
}
