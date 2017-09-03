<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class XMSHelper extends Controller
{
    static function sendXMSMessage($openid, $templateId, $datas, $link)
    {
        $data = [];

        $data['toUser'] = $openid;
        $data['templateId'] = $templateId;
        $data['url'] = $link;
        $data['datas'] = $datas;

        $xdata = [];

        $timestamp = time();
        $xms_endpoint = "https://api.xms.rmbz.net/open/msg/send";
        $biz = "market.neupioneer";
        $key = env('WECHAT_MESSAGE_KEY');

        $xdata["timestamp"] = $timestamp;
        $data = json_encode($data);
        $xdata["data"] = $data;
        $xdata["bizCode"] = $biz;
        $xdata["sign"] = md5($key.$biz.$data.$timestamp);

        $curl_data = json_encode($xdata);
        $curl_h = curl_init();
        curl_setopt($curl_h, CURLOPT_URL, $xms_endpoint);
        curl_setopt($curl_h, CURLOPT_POSTFIELDS, $curl_data);
        curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curl_h, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($curl_data))
        );

        $res = curl_exec($curl_h);

        Log::info($curl_data);

        return $res;
    }

    static function sendBuyerBoughtMessage($openid, $trans)
    {
        $data = [];
        array_push($data, [ "name" => "first", "value" => "【先锋市场】新消息提醒" ]);
        array_push($data, [ "name" => "tradeDateTime", "value" => $trans->created_at->toDateTimeString() ]);
        array_push($data, [ "name" => "orderType", "value" => "购买" ]);
        array_push($data, [ "name" => "customerInfo", "value" => $trans->buyer->nickname ]);
        array_push($data, [ "name" => "orderItemName", "value" => $trans->good->good_name ]);
        array_push($data, [ "name" => "orderItemData", "value" => $trans->number . " 件" ]);
        array_push($data, [ "name" => "remark", "value" => "有一位买家购买了您的商品，请及时查看。" ]);
        self::sendXMSMessage($openid, "hBb8bFZSzIl_3koEVLqpkcOT5KmahU-M70gFvKtd-uI", $data, "/user/sell/trans");
    }

    static function sendBuyerCancelMessage($openid, $trans)
    {
        $data = [];
        array_push($data, [ "name" => "first", "value" => "【先锋市场】新消息提醒" ]);
        array_push($data, [ "name" => "orderName", "value" => $trans->id ]);
        array_push($data, [ "name" => "orderAddress", "value" => $trans->buyer->nickname ]);
        array_push($data, [ "name" => "orderProductName", "value" => $trans->good->good_name ]);
        array_push($data, [ "name" => "orderProductPrice", "value" => $trans->good->price ]);
        array_push($data, [ "name" => "remark", "value" => "一位买家取消了订单，请及时查看。" ]);
        self::sendXMSMessage($openid, "YageMra2Z2xj6BlXN-EAzI-Gc5KEBdHwlmp8FImWv_0", $data, "/user/sell/trans");
    }

    static function sendSellerConfirmMessage($openid, $trans)
    {
        $data = [];
        array_push($data, [ "name" => "first", "value" => "【先锋市场】新消息提醒" ]);
        array_push($data, [ "name" => "keyword1", "value" => $trans->updated_at->toDateTimeString() ]);
        array_push($data, [ "name" => "keyword2", "value" => $trans->good->good_name ]);
        array_push($data, [ "name" => "keyword3", "value" => $trans->id ]);
        array_push($data, [ "name" => "remark", "value" => "卖家确认了你的订单，请及时查看。" ]);
        self::sendXMSMessage($openid, "7J8vwrK_ITI-mqRI6c0CQ-6KgiXEdqCl0YL3y4nUH_g", $data, "/user/trans");
    }

    static function sendSellerRejectMessage($openid, $trans)
    {
        $data = [];
        array_push($data, [ "name" => "first", "value" => "【先锋市场】新消息提醒" ]);
        array_push($data, [ "name" => "orderName", "value" => $trans->id ]);
        array_push($data, [ "name" => "orderAddress", "value" => $trans->buyer->nickname ]);
        array_push($data, [ "name" => "orderProductName", "value" => $trans->good->good_name ]);
        array_push($data, [ "name" => "orderProductPrice", "value" => $trans->good->price ]);
        array_push($data, [ "name" => "remark", "value" => "卖家驳回了你的订单，请及时查看。" ]);
        self::sendXMSMessage($openid, "YageMra2Z2xj6BlXN-EAzI-Gc5KEBdHwlmp8FImWv_0", $data, "/user/trans");
    }

    static function sendTransCompleteMessage($openid, $trans)
    {
        $data = [];
        array_push($data, [ "name" => "first", "value" => "【先锋市场】新消息提醒" ]);
        array_push($data, [ "name" => "keyword1", "value" => $trans->id ]);
        array_push($data, [ "name" => "keyword2", "value" => $trans->good->good_name ]);
        array_push($data, [ "name" => "keyword3", "value" => $trans->created_at->toDateTimeString() ]);
        array_push($data, [ "name" => "keyword4", "value" => $trans->updated_at->toDateTimeString() ]);
        array_push($data, [ "name" => "keyword5", "value" => $trans->updated_at->toDateTimeString() ]);
        array_push($data, [ "name" => "orderProductPrice", "value" => $trans->good->price ]);
        array_push($data, [ "name" => "remark", "value" => "您的订单已被卖家标记为完成。" ]);
        self::sendXMSMessage($openid, "LwSl-ncYjD9LywWVEZzcf3398Va4Tr1vospPwglt6VU", $data, "/user/trans");
    }

    static function sendReplyMessage($openid, $msg)
    {
        $data = [];
        array_push($data, [ "name" => "first", "value" => "【先锋市场】新消息提醒" ]);
        array_push($data, [ "name" => "keyword1", "value" => $msg->sender->nickname ]);
        array_push($data, [ "name" => "keyword2", "value" => $msg->content ]);
        array_push($data, [ "name" => "keyword3", "value" => $msg->created_at->toDateTimeString() ]);
        array_push($data, [ "name" => "remark", "value" => "您收到一条新消息，请及时查看。" ]);
        self::sendXMSMessage($openid, "knlItrLhqCnJNIzQRntDIXggv4tpJJ0U_ODbm3kPIcc", $data, "/message");

    }

    static function sendSysMessage($openid, $msg)
    {
        $data = [];
        array_push($data, [ "name" => "first", "value" => "【先锋市场】新系统消息" ]);
        array_push($data, [ "name" => "keyword1", "value" => $msg->sender_id == 0 ? "系统消息" : $msg->sender->nickname ]);
        array_push($data, [ "name" => "keyword2", "value" => $msg->content ]);
        array_push($data, [ "name" => "keyword3", "value" => $msg->created_at->toDateTimeString() ]);
        array_push($data, [ "name" => "remark", "value" => "您收到一条系统消息，请及时查看。" ]);
        self::sendXMSMessage($openid, "knlItrLhqCnJNIzQRntDIXggv4tpJJ0U_ODbm3kPIcc", $data, "/message");

    }
}
