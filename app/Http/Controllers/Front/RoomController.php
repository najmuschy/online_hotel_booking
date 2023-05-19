<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // public function room($id){
    //     $room_data = Room::where('id',$id)->first();
    //     return view('front.room',compact('room_data')) ;
    // }
    public function single_room($id){
        $room_detail_data = Room::with('rRoomPhoto')->where('id',$id)->first() ;
        
        return view('front.room_detail', compact('room_detail_data')) ;
    }
}
