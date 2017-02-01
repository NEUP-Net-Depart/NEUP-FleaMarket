@include('includes.head')
    <title>先锋市场</title>
@include('layout.header')
    <div class="row">
    <div class="small-0 medium-2 columns">
        <ul class="menu vertical">
            <li @if($cat_id == 0) class="active" @endif><a href="/good">*</a></li>
            @foreach($cats as $cat)
            <li @if($cat_id == $cat->id) class="active" @endif><a href="/good?cat_id={{ $cat->id }}">{{ $cat->cat_name }}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="small-12 medium-10 columns">
        <div class="row small-up-1 medium-up-2 large-up-4" data-equalizer data-equalize-by-row>
            @foreach($goods as $good)
            <div class="columns">
                <div class="card">
                <div class="card-section">
                <a href="/good/{{ $good->id }}">
                    <img src="/good/{{ sha1($good->id) }}/titlepic/320/180"/>
                    <div>{{ $good->good_name }}</div>
                </a>
                <div style="color: #cc4b37; white-space: nowrap; overflow: hidden;"><b>￥{{ $good->pricemin }} - ￥{{ $good->pricemax }}</b></div>
                @if($good->counts==0) <div style="color: #ffae00; white-space: nowrap; overflow:hidden;">无库存QAQ @else <div style="white-space:nowrap; overflow:hidden;">库存：{{ $good->counts }}@endif</div>
                <div style="color: #767676; white-space: nowrap; overflow:hidden;">销量：{{ $good->sold_month }} / {{ $good->sold_total }}</div>
                </div>
                </div>
            </div>
            @endforeach
        </div>
        <ul class="pagination text-center" role="navigation" aria-label="Pagination">
            <li class="pagination-previous @if($page <= 1) disabled @endif">@if($page > 1) <a href="/good?page={{ $page - 1 }}" aria-label="Previous Page">上一页</a> @else 上一页 @endif</li>
            @if($goods->lastPage()<=6)
                @for($i=1;$i<=$goods->lastPage();$i++)
                    <li @if($i == $page) class="current" @endif> @if($i != $page) <a href="/good?page={{ $i }}"> @endif{{ $i }} @if($i != $page) </a> @endif</li>
                @endfor
            @else
                @for($i=1;$i<=3;$i++)
                    <li @if($i == $page) class="current" @endif> @if($i != $page) <a href="/good?page={{ $i }}"> @endif{{ $i }} @if($i != $page) </a> @endif</li>
                @endfor
                @if($page>5)
                <li class="ellipsis"></li>
                @endif
                @for($i=max($page-1,4);$i<=min($goods->lastPage()-3,$page+1);$i++)
                    <li @if($i == $page) class="current" @endif> @if($i != $page) <a href="/good?page={{ $i }}"> @endif{{ $i }} @if($i != $page) </a> @endif</li>
                @endfor
                @if($page<$goods->lastPage()-4)
                <li class="ellipsis"></li>
                @endif
                @for($i=$goods->lastPage()-2;$i<=$goods->lastPage();$i++)
                    <li @if($i == $page) class="current" @endif> @if($i != $page) <a href="/good?page={{ $i }}"> @endif{{ $i }} @if($i != $page) </a> @endif</li>
                @endfor
            @endif
            <li class="pagination-next @if($page >= $goods->lastPage()) disabled @endif">@if($page < $goods->lastPage()) <a href="/good?page={{ $page + 1 }}" aria-label="Next Page">下一页</a> @else 下一页 @endif</li>
        </ul>
    </div>
    </div>
@include('layout.footer')
@include('includes.foot')
