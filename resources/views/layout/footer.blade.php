﻿<p></p>

<div class="footer container">
    @if(env('APP_DEBUG')) <div class="row"><div class="mx-auto">当前处于调试模式</div></div> @endif
    @if(env('SHOW_VER')) <div class="row"><div class="mx-auto">程序版本：{{ config('app.version') }}&nbsp;&nbsp; 文件版本：<a href="https://github.com/NEUP-Net-Depart/NEUP-FleaMarket/commit/{{ explode(' ', exec('git log --pretty=oneline -1'))[0] }}">{{ exec('git log --abbrev-commit --pretty=oneline -1') }}</a></div></div> @endif
    <div class="d-none d-md-flex row">
        <ul class="col-auto">
            <li>© {{date("Y")}} 东北大学先锋网</li>
            <li><a href="/pp">隐私政策</a></li>
            <li><a href="/tos">服务条款</a></li>
        </ul>
        <ul class="col-auto ml-auto">
            <li><a href="/faq">帮助文档</a></li>
            <li><a href="/help#complain">申诉通道</a></li>
            <li><a href="/help#bug">意见反馈</a></li>
            <li><a href="https://github.com/NEUP-Net-Depart/NEUP-FleaMarket">关于我们</a></li>
        </ul>
    </div>
    {{-- <div class="row"><div class="mx-auto">© </div></div> --}}
    <div class="d-md-none row">
        <ul class="col-auto mr-auto">
            <li>© {{date("Y")}} <a href="https://github.com/NEUP-Net-Depart/NEUP-FleaMarket">东北大学先锋网</a></li>

        </ul>
        <ul class="col-auto ml-auto">
            <li><a href="/faq">帮助文档</a></li>
            {{--<li><a href="/help#complain">申诉通道</a></li>--}}
            <li><a href="/help#bug">意见反馈</a></li>
            {{--<li><a href="https://github.com/NEUP-Net-Depart/NEUP-FleaMarket">关于我们</a></li>--}}
        </ul>
    </div>
</div>