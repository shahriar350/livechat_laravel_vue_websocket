<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Models\ChatBox;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    function total_users(){
        return response()->json(['data' => User::latest()->get()->except(\Auth::user()->id)]);
    }
    function user_all_chat($id){
        return response()->json(['data' => ChatBox::where('sender',auth()->user()->id)->where('receiver',$id)->get()]);
    }
    function message_broadcast(Request $request,int $id){
        $request->validate([
            'message' => 'required|string'
        ],[
            'message.required' => '',
            'message.string' => 'Message should be string'
        ]);
        broadcast(new MessageEvent($id,$request->message))->toOthers();
        ChatBox::create([
            'sender' => auth()->user()->id,
            'receiver' => $id,
            'message' => $request->message
        ]);
        return response()->json('done');
    }
}
