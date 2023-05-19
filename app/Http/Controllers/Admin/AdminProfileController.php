<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Middleware\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin as ModelsAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function index(){
        return view('admin.profile');
    }
    public function profile_submit(Request $request){
        
        
        $adminData = ModelsAdmin::where('email',Auth::guard('admin')->user()->email)->first() ;
       
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);
        if($request->password!=''){
            $request->validate([
                'password' => 'required',
                'retype_password' => 'required|same:password'
            ]);
            $adminData->password = Hash::make($request->password) ;
        }
        if($request->hasFile('photo')){
            $request->validate([
                'photo' => 'image|mimes:jpg,jpeg,gif,png'
            ]);
            unlink(public_path('uploads/'.$adminData->photo));
            $ext = $request->file('photo')->extension();
            $final_name = 'admin' . '.' .$ext ;
            $request->file('photo')->move(public_path('uploads/'),$final_name) ;
            $adminData->photo = $final_name ;
        }
        $adminData->name = $request->name ;
        $adminData->email =  $request->email ;
        $adminData->update() ;

        return redirect()->back()->with('success','Changes have been made successfully') ;
    }
}
