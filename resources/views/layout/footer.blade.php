﻿@if( env('SHOW_VER') || env('APP_DEBUG') )
    <div class="footer mx-auto">
		<span>
			<center>
				@if(env('APP_DEBUG'))<p>当前处于调试模式</p>@endif
                @if(env('SHOW_VER'))<p>程序版本：{{ config('app.version')       }}&nbsp;&nbsp; 文件版本：<a
                            href="https://github.com/NEUP-Net-Depart/NEUP-FleaMarket/commit/{{ explode(' ', exec('git log --pretty=oneline -1'))[0]   }}">{{ exec('git log --abbrev-commit --pretty=oneline -1')  }}</a></p>
                @endif
            </center>
		</span>
    </div>
@endif
<div class="footer container">
    <div class="d-none d-md-block">
        <ul class="float-left">
            <li>© {{date("Y")}} 东北大学先锋网</li>
            <li><a href="/pp">隐私政策</a></li>
            <li><a href="/tos">服务条款</a></li>
        </ul>
        <ul class="float-right">
            <li><a href="/faq">帮助文档</a></li>
            <li><a href="/help#complain">申诉通道</a></li>
            <li><a href="/help#bug">意见反馈</a></li>
            <li><a href="/">关于我们</a></li>
        </ul>
    </div>
    <div class="d--block d-md-none">
        <span><center>© {{date("Y")}} 东北大学先锋网</center></span>
        <ul class="float-left">
            <li><a href="/faq">帮助文档</a></li>
            <li><a href="/help#complain">申诉通道</a></li>
        </ul>
        <ul class="float-right">
            <li><a href="/help#bug">意见反馈</a></li>
            <li><a href="/">关于我们</a></li>
        </ul>
    </div>
</div>