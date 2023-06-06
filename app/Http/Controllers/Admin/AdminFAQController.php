<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use Illuminate\Http\Request;

class AdminFAQController extends Controller
{
    public function index(){
        $faqs = FAQ::get() ;
        return view('admin.faq_view', compact('faqs')) ;
    }
    public function add(){
        return view('admin.faq_add') ;
    }
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required'
        ]);

        
        $obj = new FAQ();
        $obj->question = $request->question;
        $obj->answer = $request->answer;
        
        $obj->save();

        return redirect()->back()->with('success', 'FAQ is added successfully.');

    }
    public function edit($id)
    {
        $faq_data = FAQ::where('id',$id)->first();
        return view('admin.faq_edit', compact('faq_data'));
    }

    public function update(Request $request,$id) 
    {        
        $obj = FAQ::where('id',$id)->first();
        

        $obj->question = $request->question;
        $obj->answer = $request->answer;
        
        $obj->update();

        return redirect()->back()->with('success', 'FAQ is updated successfully.');
    }
    public function delete($id){

        $single_data = FAQ::where('id',$id)->first();
        $single_data->delete();
        return redirect()->back()->with('success', 'FAQ is deleted successfully.');
    }
}
