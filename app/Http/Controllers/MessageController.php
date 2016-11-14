<?php

namespace App\Http\Controllers;

use App\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\Collection;
use App\GoodCat;
use App\GoodInfo;
use App\Transaction;
use App\TransactionLog;
use App\Messages;
use App\User;
use App\Http\Controllers\Controller;
use Storage;

class MessageController extends Controller
{
    public function getMessage(Request $request)
    {
        $data = [];
        $user_id = $request->session()->get('user_id');
        $data['informations'] = Messages::where('receiver_id',$user_id)->get();
        $data['users'] = User::orderBy('id', 'asc')->get()->keyBy('id');
        return view::make('message.getMessage')->with($data);
    }

    public function sendMessagepage(Request $request)
    {
        return view::make('message.sendMessage');
    }

    public function sendAllow(Request $request)
    {
        $input = $request->all();
        $message = new Messages;
        $user_id = $request->session()->get('user_id');
        $message->title = $input['title'];
        $message->content = $input['content'];
        $receiver = $input['receiver'];
        $message->sender_id = $user_id;
        $user = User::where('nickname',$receiver)->first();
        $message->receiver_id = $user->id;
        $message->save();
        return Redirect::to('/message');
    } 
}