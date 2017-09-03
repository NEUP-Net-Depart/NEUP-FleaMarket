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
use App\Ticket;
use App\UserInfo;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\XMSHelper;

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
        $user = User::find($user_id);
        if(!$user || $user->baned)
            return Redirect::back()->withInput()->withErrors('您的账号被封禁，请联系系统管理员');
        if(UserInfo::where('user_id', $user_id)->count() == 0 && !$user->wechat_open_id)
            return Redirect::back()->withInput()->withErrors('你必须添加联系方式才能购买');
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
        $good = $trans->good;
        $count=$request->number-$trans->number;
        $good->count = $good->count - $count;
        $good->save();
        $result = $this->update($trans, $user_id, $request->number, $request->ip());
        $result = json_decode($result,true);
        if($result['result']) {
            return Redirect::to('/user/sell/trans');
        }
        else
            return Redirect::back()->withInput()->withErrors($result['msg']);
    }

    private function buy($good_id, $buyer_id, $count, $request_ip)
    {
        if (GoodInfo::where('id', $good_id)->where('baned', false)->count() == 0)
            return json_encode(['result' => false, 'msg' => '没有此商品']);
        $good = GoodInfo::find($good_id);
        $buyer = User::find($buyer_id);
        if ($count > $good->count)
            return json_encode(['result' => false, 'msg' => '商品缺货']);

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
        $message->content = '您好！<a href="/user/' . $buyer_id . '">' . $buyer->not_null_nickname . '</a>购买了你的<a href="/good/' . $good_id . '">' . $good->good_name . '</a>，请及时前往<a href="/user/sell/trans">交易订单页</a>确认。';
        $message->save();

        if($trans->seller->wechat_open_id)
            XMSHelper::sendBuyerBoughtMessage($trans->seller->wechat_open_id, $trans);

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
                $message->content = '您好！您的<a href="/good/' . $good->id . '">' . $good->good_name . '</a>的一个订单被买家取消，你可以前往<a href="/user/sell/trans">交易订单页</a>查看。';
                $message->save();
                //Create or Update MessageContact
                $contact = MessageContact::firstOrNew([
                    'user_id' => $message->receiver_id,
                    'contact_id' => 0
                ]);
                $contact->unread_count += 1;
                $contact->last_contact_time = time();
                $contact->save();

                if($trans->seller->wechat_open_id)
                    XMSHelper::sendBuyerCancelMessage($trans->seller->wechat_open_id, $trans);

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
                $message->content = '您好！您购买的<a href="/good/' . $good->id . '">' . $good->good_name . '</a>的一个订单被卖家驳回，你可以前往<a href="/user/trans">交易订单页</a>查看。';
                $message->save();
                //Create or Update MessageContact
                $contact = MessageContact::firstOrNew([
                    'user_id' => $message->receiver_id,
                    'contact_id' => 0
                ]);
                $contact->unread_count += 1;
                $contact->last_contact_time = time();
                $contact->save();

                if($trans->buyer->wechat_open_id)
                    XMSHelper::sendSellerRejectMessage($trans->buyer->wechat_open_id, $trans);

                return json_encode(['result' => true, 'character' => 'seller', 'msg' => 'success']);
                break;
            default:
                return json_encode(['result' => false, 'msg' => '未授权的访问']);
        }
    }

    private function sell($trans, $user_id, $request_ip)
    {
        if ($trans->seller_id != $user_id)
            return json_encode(['result' => false, 'msg' => '未授权的访问']);
        if($trans->status != 1)
            return json_encode(['result' => false, 'msg' => '无效的请求']);
        $good = $trans->good;
        if ($trans->number > $good->count)
            return json_encode(['result' => false, 'msg' => '商品缺货']);
        $good->count = $good->count - $trans->number;
        $good->save();
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
        $message->content = '您好！你订购的<a href="/good/' . $good->id . '">' . $good->good_name . '</a>已被卖家确认，你们现在可以去<a href="/trans/' . $trans->id . '">查看对方的联系方式</a>并且交♂易啦。';
        $message->save();
        //Create or Update MessageContact
        $contact = MessageContact::firstOrNew([
            'user_id' => $message->receiver_id,
            'contact_id' => 0
        ]);
        $contact->unread_count += 1;
        $contact->last_contact_time = time();
        $contact->save();

        if($trans->buyer->wechat_open_id)
            XMSHelper::sendSellerConfirmMessage($trans->buyer->wechat_open_id, $trans);

        return json_encode(['result' => true, 'msg' => 'success']);
    }

    private function update($trans, $user_id, $number, $request_ip)
    {
        if ($trans->seller_id != $user_id)
            return json_encode(['result' => false, 'msg' => '未授权的访问']);
        if($trans->status != 2)
            return json_encode(['result' => false, 'msg' => '无效的请求']);
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
            return json_encode(['result' => false, 'msg' => '未授权的访问']);
        if($trans->status != 2)
            return json_encode(['result' => false, 'msg' => '无效的请求']);
        if(!$result) {
            $trans->good->count = $trans->good->count + $trans->number;
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
            $message->content = '您好！你订购的<a href="/good/' . $good->id . '">' . $good->good_name . '</a>的订单已被卖家标记为交易成功，你现在可以去<a href="/user/trans">评价此单交易</a>啦。';
        else
            $message->content = '您好！你订购的<a href="/good/' . $good->id . '">' . $good->good_name . '</a>的订单已被卖家标记为交易失败。';
        $message->save();
        //Create or Update MessageContact
        $contact = MessageContact::firstOrNew([
            'user_id' => $message->receiver_id,
            'contact_id' => 0
        ]);
        $contact->unread_count += 1;
        $contact->last_contact_time = time();
        $contact->save();

        if($trans->buyer->wechat_open_id)
            XMSHelper::sendTransCompleteMessage($trans->buyer->wechat_open_id, $trans);

        return json_encode(['result' => true, 'msg' => 'success']);
    }

    public function showTrans(Request $request, $trans_id)
    {
        $user_id = $request->session()->get('user_id');
        $trans = Transaction::find($trans_id);
        if(!$trans || $trans->status < 2)
            return View::make('common.errorPage')->withErrors('交易ID错误！');
        $seller = User::with('user_infos')->find($trans->seller_id);
        $buyer = User::with('user_infos')->find($trans->buyer_id);
        if($user_id != $trans->buyer_id
            && (GoodInfo::where('id', $trans->good_id)->count() == 0 || $user_id != $trans->seller_id))
            return View::make('common.errorPage')->withErrors('交易ID错误！');
        $data['tran'] = $trans;
        $data['seller'] = $seller;
        $data['buyer'] = $buyer;
        return view('transaction')->with($data);
    }

	public function comment(Request $request, $trans_id)
	{
		$data = [];
		$data['trans_id'] = $trans_id;
		return view('comment')->with($data);
	}

	public function sendComment(Request $request, $trans_id)
	{
		$input = $request->all();
		$ticket = new Ticket;
		$ticket->sender_id = $request->session()->get('user_id');
		$ticket->trans_id = $trans_id;
		$trans = Transaction::find($trans_id);
		$ticket->receiver_id = $trans->seller->id;
		$ticket->type = 1;
		$ticket->message = $input['comment'];
		$ticket->save();
		$trans->status = 5; 
		$trans->save();
		return Redirect::to('/user/trans');
	}
}
