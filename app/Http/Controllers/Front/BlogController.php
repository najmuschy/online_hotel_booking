<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;


class BlogController extends Controller
{
    public function index(){
        $post_all = Post::orderBy('id','desc')->paginate(6);
        return view('front.blog', compact('post_all')) ;
    }
    public function single_post($id){
        $single_post_data = Post::where('id',$id)->first() ;
        $update_data = $single_post_data->total_views+1;
        $single_post_data->total_views = $single_post_data->total_views+1;
        $single_post_data->update();
        return view('front.post', compact('single_post_data')) ;
    }
}
