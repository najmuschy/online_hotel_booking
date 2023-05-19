<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Validator;


use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Mail\Websitemail ;
use Illuminate\Support\Facades\Mail;




class ContactController extends Controller
{
    public function contact(){
        $contact_data = Page::where('id',1)->first();
        return view('front.contact', compact('contact_data')) ;
    }
    public function send_email(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);
        if(!$validator->passes() ){
            return response()->json(['code'=>0,'error_message'=>$validator->errors()->toArray()]);
        }
        else{
            // Send email
            $subject ='Contact form email' ;
            $message ='Visitor email information <br>' ;
            $message .= 'Name: '.$request->name.'<br>' ;
            $message .= 'Email: '.$request->emai.'<br>' ;
            $message .= 'Message: '.$request->message.'<br>' ;

            $admin_data = Admin::where('id',1)->first();
            $admin_email = $admin_data->email ;
            Mail::to($admin_email)->send(new Websitemail($subject, $message)) ;

            return response()->json(['code'=>1,'success_message'=>'Email is sent successfully']);
        }
}
}
