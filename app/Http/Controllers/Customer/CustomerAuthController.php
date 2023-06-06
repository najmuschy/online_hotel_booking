<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\Websitemail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;



class CustomerAuthController extends Controller
{
    public function login(){
        return view('front.login') ;
    }
   
   
    public function login_submit(Request $request){
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
    
            $credential = [
                'email' => $request->email,
                'password' => $request->password,
                'status' => 1
            ];
    
            if(Auth::guard('customer')->attempt($credential)) {
                return redirect()->route('customer_home');
            } else {            
                return redirect()->route('customer_login')->with('error', 'Information is not correct!');
              }
    }
    
    public function signup()
    {
        return view('front.signup');
    }
    
    
      public function signup_submit(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'password' => 'required',
            'retype_password' => 'required|same:password',
        ]);
        $password = Hash::make($request->password) ;
        $token = hash('sha256',  time()) ;
        
        $verification_link = url('signup/verify/'.$request->email.'/'.$token) ;
        
        $obj = new Customer() ;
        $obj->name = $request->name ;        
        $obj->email = $request->email ;        
        $obj->password = $password ;        
        $obj->token = $token ;         
        $obj->status = 0 ;         
        $obj->save() ;   
        
        $subject = 'Sign Up Verification' ;
        $message = 'Please click on the link below to complete registration <br>' ;
        $message .= '<a href="'.$verification_link.'">'.$verification_link.'</a>' ;

        Mail::to($request->email)->send(new Websitemail($subject, $message)) ;
        

        return redirect()->back()->with('success', 'To complete registration please check your email and click on the provided link') ;
        
    }
    public function signup_verify($email, $token){
        $customer_data = Customer::where('email',$email)->where('token',$token)->first() ;
        
        if($customer_data){
            $customer_data->token = '';
            $customer_data->status = 1;
            $customer_data->update() ;
            
            return redirect()->route('customer_login')->with('success', 'Registration Completed! Now try logging in.') ;
        }
        else{
            return redirect()->route('customer_signup');
        }
    }
    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customer_login');
    }
    public function forget_password(){
        return view('front.forget_password');
    }
    
    public function forget_password_submit(Request $request){

        $request->validate([
            'email' => 'required|email'
        ]);

        $customer_data = Customer::where('email',$request->email)->first();
        if(!$customer_data) {
            return redirect()->back()->with('error','Email address not found!');
        }

        $token = hash('sha256',time());

        $customer_data->token = $token;
        $customer_data->update();

        $reset_link = url('/reset-password/'.$token.'/'.$request->email);
        $subject = 'Reset Password';
        $message = 'Please click on the following link: <br>';
        $message .= '<a href="'.$reset_link.'">Click here</a>';

        Mail::to($request->email)->send(new Websitemail($subject,$message));

        return redirect()->route('customer_login')->with('success','Please check your email and follow the steps there');

    }
    public function reset_password($token,$email)
    {
        $customer_data = Customer::where('token',$token)->where('email',$email)->first();
        if(!$customer_data) {
            return redirect()->route('customer_login');
        }
        else{
            return view('front.reset_password', compact('token','email'));
        }
        

    }

    public function reset_password_submit(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'retype_password' => 'required|same:password'
        ]);

        $customer_data = Customer::where('token',$request->token)->where('email',$request->email)->first();

        $customer_data->password = Hash::make($request->password);
        $customer_data->token = '';
        $customer_data->update();

        return redirect()->route('customer_login')->with('success', 'Password is reset successfully');
    }

        
}

