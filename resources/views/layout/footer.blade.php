<div class="footer">
	<div class="container hidden-sm hidden-xs">
	<ul class="pull-left">
		<li>© {{date("Y")}} 东北大学先锋网</li>
		<li><a href="/">隐私政策</a></li>
		<li><a href="/">服务条款</a></li>
	</ul>
	<ul class="pull-right">
		<li><a href="/">帮助文档</a></li>
		<li><a href="/">申诉通道</a></li>
		<li><a href="/">意见反馈</a></li>
		<li><a href="/">关于我们</a></li>
	</ul>
	</div>
	<div class="visible-xs-block visible-sm-block">
		<span><center>© {{date("Y")}} 东北大学先锋网</center></span>
	</div>
</footer>
@if( env('APP_DEBUG') )
<div class="footer">
	<div class="container">
		<span>
			<center>
				当前处于调试模式<br>  程序版本：{{ config('app.version')       }}&nbsp;&nbsp; 文件版本：<a href="https://github.com/NEUP-Net-Depart/NEUP-FleaMarket/commit/{{ explode(' ', exec('git log --pretty=oneline -1'))[0]   }}">{{ exec('git log --abbrev-commit --pretty=oneline -1')  }}</a>
			</center>
		</span>
	</div>
</div>
@endif
