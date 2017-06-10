<?php

namespace App\Http\Controllers;

use App\GoodInfo;
use App\Message;
use App\Transaction;
use App\TransactionLog;
use App\User;
use App\MessageContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TransactionController extends Controller
{
    // 0 取消的订单
    // 1 买家已购买
    // 2 卖家已确认交易
    // 3 交易失败
    // 4 交易成功待评价
    // 5 交易成功已评价

    public function add(Request $request, $good_id)
    {
        $user_id = $request->session()->get('user_id');
        $count = $request->count;
        $result = $this->buy($good_id, $user_id, $count, $request->ip());
        $result = json_decode($result, true);
        if($result['result'])
            return Redirect::to('/user/trans');
        else
            return Redirect::back()->withInput()->withErrors($result['msg']);
    }

    public function go(Request $request, $trans_id)
    {
        $user_id = $request->session()->get('user_id');
        $trans = Transaction::find($trans_id);
        switch ($trans->status) {
            case 1:
                $result = $this->sell($trans, $user_id, $request->ip());
                break;
            case 2:
                $result = $this->finish($trans, $user_id, $request->result, $request->ip());
                break;
            default:
                $result = json_encode(['result' => false, 'msg' => 'invalid']);
        }
        $result = json_decode($result, true);
        if($result['result'])
            return Redirect::to('/user/sell/trans');
        else
            return Redirect::back()->withInput()->withErrors($result['msg']);

    }

    public function cancel(Request $request, $trans_id)
    {
        $user_id = $request->session()->get('user_id');
        $trans = Transaction::find($trans_id);
        $result = $this->cancelBuy($trans, $user_id, $request->ip(), $request->reason);
        $result = json_decode($result, true);
        if($result['result']) {
            if($result['character'] == "seller")
                return Redirect::to('/user/sell/trans');
            else
                return Redirect::to('/user/trans');
        }
        else
            return Redirect::back()->withInput()->withErrors($result['msg']);
    }

    public function edit(Request $request, $trans_id)
    {
        $user_id = $request->session()->get('user_id');
        $trans = Transaction::find($trans_id);
        $result = $this->update($trans, $user_id, $request->number, $request->ip());
        $result = json_decode($result);
        if($result['result']) {
            return Redirect::to('/user/sell/trans');
        }
        else
            return Redirect::back()->withInput()->withErrors($result['msg']);
    }

    private function buy($good_id, $buyer_id, $count, $request_ip)
    {
        if (GoodInfo::where('id', $good_id)->where('baned', false)->count() == 0)
            return json_encode(['result' => false, 'msg' => 'No such item']);
        $good = GoodInfo::find($good_id);
        $buyer = User::find($buyer_id);
        if ($count > $good->count)
            return json_encode(['result' => false, 'msg' => 'Out of stock']);

        $trans = new Transaction();
        $trans->good_id = $good_id;
        $trans->buyer_id = $buyer_id;
        $trans->number = $count;
        $trans->status = 1;
        $trans->save();

        $translog = new TransactionLog();
        $translog->ip = $request_ip;
        $translog->user_id = $buyer_id;
        $translog->trans_id = $trans->id;
        $translog->event = "buy";
        $translog->save();

        $message = new Message();
        $message->sender_id = 0;
        $message->receiver_id = $good->user_id;
        $message->content = '您好！' . $buyer->not_null_nickname . '购买了你的' . $good->good_name . '，请及时前往确认。';
        $message->save();

        //Create or Update MessageContact
        $contact = MessageContact::firstOrNew([
            'user_id' => $message->receiver_id,
            'contact_id' => 0
        ]);
        $contact->unread_count += 1;
        $contact->last_contact_time = time();
        $contact->save();
        return json_encode(['result' => true, 'msg' => 'success']);
    }

    private function cancelBuy($trans, $user_id, $request_ip, $reason)
    {
        switch ($user_id) {
            case $trans->buyer_id:
                $trans->status = 0;
                $trans->reason = $reason;
                $trans->save();

                $translog = new TransactionLog();
                $translog->ip = $request_ip;
                $translog->user_id = $user_id;
                $translog->trans_id = $trans->id;
                $translog->event = "buyerCancelTrans";
                $translog->save();

                $message = new Message();
                $message->sender_id = 0;
                $good = $trans->good;
                $message->receiver_id = $good->user_id;
                $message->content = '您好！您的' . $good->good_name . '的一个订单被买家取消，你可以前往查看。';
                $message->save();
                //Create or Update MessageContact
                $contact = MessageContact::firstOrNew([
                    'user_id' => $message->receiver_id,
                    'contact_id' => 0
                ]);
                $contact->unread_count += 1;
                $contact->last_contact_time = time();
                $contact->save();
                return json_encode(['result' => true, 'character' => 'buyer', 'msg' => 'success']);
                break;
            case $trans->seller_id:
                $trans->status = 0;
                $trans->reason = $reason;
                $trans->save();

                $translog = new TransactionLog();
                $translog->ip = $request_ip;
                $translog->user_id = $user_id;
                $translog->trans_id = $trans->id;
                $translog->event = "sellerCancelTrans";
                $translog->save();

                $message = new Message();
                $message->sender_id = 0;
                $good = $trans->good;
                $message->receiver_id = $trans->buyer_id;
                $message->content = '您好！您购买的' . $good->good_name . '的一个订单被卖家驳回，你可以前往查看。';
                $message->save();
                //Create or Update MessageContact
                $contact = MessageContact::firstOrNew([
                    'user_id' => $message->receiver_id,
                    'contact_id' => 0
                ]);
                $contact->unread_count += 1;
                $contact->last_contact_time = time();
                $contact->save();
                return json_encode(['result' => true, 'character' => 'seller', 'msg' => 'success']);
                break;
            default:
                return json_encode(['result' => false, 'msg' => 'unauthorized']);
        }
    }

    private function sell($trans, $user_id, $request_ip)
    {
        if ($trans->seller_id != $user_id)
            return json_encode(['result' => false, 'msg' => 'unauthorized']);
        if($trans->status != 1)
            return json_encode(['result' => false, 'msg' => 'invalid']);
        $good = $trans->good;
        if ($trans->count > $good->count)
            return json_encode(['result' => false, 'msg' => 'Out of stock']);
        $trans->status = 2;
        $trans->save();

        $translog = new TransactionLog();
        $translog->ip = $request_ip;
        $translog->user_id = $user_id;
        $translog->trans_id = $trans->id;
        $translog->event = "sell";
        $translog->save();

        $message = new Message();
        $message->sender_id = 0;
        $message->receiver_id = $trans->buyer_id;
        $message->content = '您好！你订购的' . $good->good_name . '已被卖家确认，你们现在可以去看对方的联系方式并且交♂易啦。';
        $message->save();
        //Create or Update MessageContact
        $contact = MessageContact::firstOrNew([
            'user_id' => $message->receiver_id,
            'contact_id' => 0
        ]);
        $contact->unread_count += 1;
        $contact->last_contact_time = time();
        $contact->save();
        return json_encode(['result' => true, 'msg' => 'success']);
    }

    private function update($trans, $user_id, $number, $request_ip)
    {
        if ($trans->seller_id != $user_id)
            return json_encode(['result' => false, 'msg' => 'unauthorized']);
        if($trans->status != 2)
            return json_encode(['result' => false, 'msg' => 'invalid']);
        $trans->number = $number;
        $trans->save();

        $translog = new TransactionLog();
        $translog->ip = $request_ip;
        $translog->user_id = $user_id;
        $translog->trans_id = $trans->id;
        $translog->event = "sellerUpdateNum";
        $translog->save();

        return json_encode(['result' => true, 'msg' => 'success']);
    }

    private function finish($trans, $user_id, $result, $request_ip)
    {
        if ($trans->seller_id != $user_id)
            return json_encode(['result' => false, 'msg' => 'unauthorized']);
        if($trans->status != 2)
            return json_encode(['result' => false, 'msg' => 'invalid']);
        if($result) {
            $trans->good->count = $trans->good->count - $trans->number;
            $trans->good->save();
        }
        if($result)
            $trans->status = 4;
        else
            $trans->status = 3;
        $trans->save();

        $translog = new TransactionLog();
        $translog->ip = $request_ip;
        $translog->user_id = $user_id;
        $translog->trans_id = $trans->id;
        if($result)
            $translog->event = "finishTrue";
        else
            $translog->event = "finishFalse";
        $translog->save();

        $message = new Message();
        $message->sender_id = 0;
        $message->receiver_id = $trans->buyer_id;
        $good = $trans->good;
        if($result)
            $message->content = '您好！你订购的' . $good->good_name . '的订单已被卖家标记为交易成功，你现在可以去评价此单交易啦。';
        else
            $message->content = '您好！你订购的' . $good->good_name . '的订单已被卖家标记为交易失败。';
        $message->save();
        //Create or Update MessageContact
        $contact = MessageContact::firstOrNew([
            'user_id' => $message->receiver_id,
            'contact_id' => 0
        ]);
        $contact->unread_count += 1;
        $contact->last_contact_time = time();
        $contact->save();
        return json_encode(['result' => true, 'msg' => 'success']);
    }

    public function showTrans(Request $request, $trans_id)
    {
        $user_id = $request->session()->get('user_id');
        $trans = Transaction::find($trans_id);
        $seller = User::with('user_infos')->find($trans->seller_id);
        $buyer = User::with('user_infos')->find($trans->buyer_id);
        if(!$trans || ($user_id != $trans->buyer_id && $user_id != $trans->seller_id))
            return View::make('common.errorPage')->withErrors('交易ID错误！');
        $data['tran'] = $trans;
        $data['seller'] = $seller;
        $data['buyer'] = $buyer;
        return view('transaction')->with($data);
    }
}
