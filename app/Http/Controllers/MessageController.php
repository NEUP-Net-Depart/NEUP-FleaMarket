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
    public function showMessageView(Request $request)
	{
        return View::make('message.message');
    }

    public function getHistoryMessage(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $contact_id = $request->contact_id;
        $messages = Message::where('receiver_id', $user_id)->where('sender_id', $contact_id)
            ->orWhere('receiver_id', $contact_id)->where('sender_id', $user_id)
            ->orderBy('id', 'desc')
            ->paginate(20);
        Message::where('receiver_id', $user_id)->where('sender_id', $contact_id)
            ->update(['is_read' => true]);
        MessageContact::where('user_id', $user_id)
            ->where('contact_id', $contact_id)
            ->update(['unread_count' => 0]);
	$user_id = $request->session()->get('user_id');
	$post_data = 'user_id='.$user_id.'';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, '127.0.0.1:6565/notify');
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$output = curl_exec($ch);
	curl_close($ch);
        return json_encode($messages);
    }

    public function getNewMessage(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $contact_id = $request->contact_id;
        $messages = Message::where('is_read', false)
            ->where('receiver_id', $user_id)->where('sender_id', $contact_id)
            ->get();
        Message::where('is_read', false)
            ->where('receiver_id', $user_id)->where('sender_id', $contact_id)
            ->update(['is_read' => true]);
        MessageContact::where('user_id', $user_id)
            ->where('contact_id', $contact_id)
            ->update(['unread_count' => 0]);
        return json_encode($messages);
    }

    public function getUnreadMsgNum(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $count = Message::where('receiver_id', $user_id)->where('is_read', false)->count();
        return $count;
    }

    public function deleteMessage(Request $request, $id)
    {
        $data = Message::find($id);
        if ($request->session()->get('user_id') != $data->receiver_id)
            return json_encode(['result' => false, 'msg' => 'Auth Failure.']);
        $data->delete();
        return json_encode(['result' => true, 'msg' => 'success']);
    }

    static public function sendMessageHandle($sender, $receiver, $content)
    {
        if (!User::where('id', $receiver)->count())
            return json_encode(['result' => false, 'msg' => 'no such receiver']);
        //Create Message
        $message = new Message;
        $user_id = $sender;
        $message->content = $content;
        $message->sender_id = $user_id;
        $message->receiver_id = $receiver;
        $message->save();
        //Create or Update MessageContact
        //A->B
        $contact = MessageContact::firstOrNew([
            'user_id' => $user_id,
            'contact_id' => $receiver
        ]);
        $contact->last_contact_time = time();
        $contact->save();
        //B->A
        $contact = MessageContact::firstOrNew([
            'user_id' => $receiver,
            'contact_id' => $user_id
        ]);
        $contact->last_contact_time = time();
        $contact->unread_count += 1;
        $contact->save();
        return json_encode(['result' => true, 'msg' => $message]);
    }

    public function sendMessage(SendMessageRequest $request)
    {
        $input = $request->all();
        if(!isset($input['content']))
            $input['content'] = '';
        return $this->sendMessageHandle($request->session()->get('user_id'), $input['receiver'], $input['content']);
    }

    public function sendMessagepage(Request $request)
    {
        return View::make('message.sendMessage');
    }

    public function getHistoryMessageContact(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $contacts = MessageContact::where('user_id', $user_id)
            ->orderBy('last_contact_time', 'desc')
            ->with(['contact' => function ($query) {
                $query->select('id', 'nickname', 'baned', 'privilege');
            }])
            ->paginate(10);
        return json_encode($contacts);
    }

    public function getNewMessageContact(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $contacts = MessageContact::where('user_id', $user_id)
            ->where('unread_count', '>', 0)
            ->orderBy('last_contact_time', 'desc')
            ->with(['contact' => function ($query) {
                $query->select('id', 'nickname', 'baned', 'privilege');
            }])
            ->get();
        return json_encode($contacts);
    }

    public function startConversation(Request $request, $receiver)
    {
        $user_id = $request->session()->get('user_id');
        //Create or Update MessageContact
        //A->B
        $contact = MessageContact::firstOrNew([
            'user_id' => $user_id,
            'contact_id' => $receiver
        ]);
        $contact->last_contact_time = time();
        $contact->save();
        return Redirect::to('/message');
    }

    public function closeConversation(Request $request, $receiver)
    {
        $user_id = $request->session()->get('user_id');
        MessageContact::where('user_id', $user_id)
            ->where('contact_id', $receiver)
            ->delete();
        return json_encode(['result' => true, 'msg' => 'success']);
    }

}
