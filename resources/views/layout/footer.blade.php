﻿
<footer class="row hide-for-small-only">
    <div class="medium-9 medium-centered columns">
        <div class="float-left">
            <span>© {{date("Y")}} 东北大学先锋网</span>
            <span><a href="/">隐私政策</a></span>
            <span><a href="/">服务条款</a></span>
        </div>
        <div class="float-right">
            <span><a href="/">帮助文档</a></span>
            <span><a href="/">申诉通道</a></span>
            <span><a href="/">意见反馈</a></span>
            <span><a href="/">关于我们</a></span>
        </div>
    </div>
</footer>
<footer class="row hide-for-medium">
    <div class="small-11 small-centered columns">
        <span><center>© {{date("Y")}} 东北大学先锋网</center></span>
    </div>
</footer>
@if( env('APP_DEBUG') )
    <footer class="row">
        <div class="small-11 small-centered columns">
		<span>
			<center>
				当前处于调试模式<br>  程序版本：{{ config('app.version')       }}&nbsp;&nbsp; 文件版本：<a
                        href="https://github.com/NEUP-Net-Depart/NEUP-FleaMarket/commit/{{ explode(' ', exec('git log --pretty=oneline -1'))[0]   }}">{{ exec('git log --abbrev-commit --pretty=oneline -1')  }}</a>
			</center>
		</span>
        </div>
    </footer>
@endif
