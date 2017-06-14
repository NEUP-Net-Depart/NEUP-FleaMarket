<div class="footer container">
	<div class="hidden-md-down">
	<ul class="float-left">
		<li>© {{date("Y")}} 东北大学先锋网</li>
		<li><a href="/">隐私政策</a></li>
		<li><a href="/">服务条款</a></li>
	</ul>
	<ul class="float-right">
		<li><a href="/">帮助文档</a></li>
		<li><a href="/">申诉通道</a></li>
		<li><a href="/">意见反馈</a></li>
		<li><a href="/">关于我们</a></li>
	</ul>
	</div>
	<div class="hidden-lg-up">
		<span><center>© {{date("Y")}} 东北大学先锋网</center></span>
	</div>
@if( env('APP_DEBUG') )
	<span>
		<center>
			当前处于调试模式<br>  程序版本：{{ config('app.version')       }}&nbsp;&nbsp; 文件版本：<a href="https://github.com/NEUP-Net-Depart/NEUP-FleaMarket/commit/{{ explode(' ', exec('git log --pretty=oneline -1'))[0]   }}">{{ exec('git log --abbrev-commit --pretty=oneline -1')  }}</a>
		</center>
	</span>
@endif

</div>