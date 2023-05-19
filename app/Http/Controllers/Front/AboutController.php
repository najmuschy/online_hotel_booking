<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function about(){
        $about_data = Page::where('id',1)->first();
        return view('front.about',compact('about_data')) ;
    }
}