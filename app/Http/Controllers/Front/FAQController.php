<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use Illuminate\Http\Request;


class FAQController extends Controller
{
    public function index(){
        $faq_all = FAQ::get();
        return view('front.faq', compact('faq_all')) ;
    }
}
