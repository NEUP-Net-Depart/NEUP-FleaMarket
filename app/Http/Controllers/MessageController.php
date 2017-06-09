<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessageRequest;
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
use App\Message;
use App\User;
use App\MessageContact;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function getMessage(Request $request)
    {
        $data = [];
        $user_id = $request->session()->get('user_id');
        $data['informations'] = Message::with('receiver')->Orderby('id', 'desc')->where('receiver_id', $user_id)->paginate(15);
        return View::make('message.message')->with($data);
    }

    public function getUnreadMsgNum(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $count = Message::where('receiver_id', $user_id)->where('is_read', false)->count();
        return $count;
    }

    public function readMessage(Request $request, $id)
    {
        $data = Message::find($id);
        if ($request->session()->get('user_id') != $data->receiver_id)
            return json_encode(['result' => false, 'msg' => 'Auth Failure.']);
        $data->is_read = true;
        $data->save();
        return json_encode(['result' => true, 'msg' => 'success']);
    }

    public function deleteMessage(Request $request, $id)
    {
        $data = Message::find($id);
        if ($request->session()->get('user_id') != $data->receiver_id)
            return json_encode(['result' => false, 'msg' => 'Auth Failure.']);
        $data->delete();
        return json_encode(['result' => true, 'msg' => 'success']);
    }

    public function sendMessage(SendMessageRequest $request)
    {
        $input = $request->all();
        if (!User::where('id', $input['receiver'])->count())
            return json_encode(['result' => false, 'msg' => 'no such receiver']);
        //Create Message
        $message = new Message;
        $user_id = $request->session()->get('user_id');
        $message->title = $input['title'];
        $message->content = $input['content'];
        $message->sender_id = $user_id;
        $message->receiver_id = $input['receiver'];
        $message->save();
        //Create or Update MessageContact
        //A->B
        $contact = MessageContact::firstOrNew([
            'user_id' => $user_id,
            'contact_id' => $input['receiver']
        ]);
        $contact->last_contact_time = time();
        $contact->save();
        //B->A
        $contact = MessageContact::firstOrNew([
            'user_id' => $input['receiver'],
            'contact_id' => $user_id
        ]);
        $contact->last_contact_time = time();
        $contact->save();
        return json_encode(['result' => true, 'msg' => 'success']);
    }

    public function sendMessagepage(Request $request)
    {
        return View::make('message.sendMessage');
    }

    public function getMessageContact(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $contacts = MessageContact::where('user_id', $user_id)
            ->orderBy('last_contact_time', 'desc')
            ->with(['contact' => function ($query) {
                $query->select('id', 'nickname');
            }])
            ->paginate(10);
        foreach ($contacts as $c) {
            $c->unread_message = Message::where('receiver_id', $user_id)
                ->where('sender_id', $c->contact_id)
                ->where('is_read', false)
                ->count();
        }
        return json_encode($contacts);
    }

}