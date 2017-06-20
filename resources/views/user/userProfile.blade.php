@extends('layout.master')

@section('title', "用户")

@section('asset')
    <style>
        @media (max-width: 770px) {
            #profile_bt {
                height: 40px;
            }
        }
    </style>
    <script src="/js/good/good_list.js"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row" style="margin-bottom:10px">
                <div class="col-md-7 col-sm-12">
                    <figure class="figure">
                    <img src="/avatar/{{ $user->id }}/150/150"  style="width:150px; height:150px; border-radius:50%; overflow:hidden;margin-bottom:10px" />
                    <figcaption class="figure-caption text-center">
                        @if(isset($user->nickname))
                            用户昵称： {{ $user->nickname }}
                            @if($user->baned)
                                【已封禁】
                            @endif
                        @else
                            还没有昵称&gt;&lt;
                            @if($user->baned)
                                【已封禁】
                            @endif
                        @endif
                    </figcaption>
                    </figure>
                    <div class="column" style="margin-bottom:10px;padding-left:5px">
                        @if(isset($user->stuid))
                            @if(strlen($user->stuid) == 8)
                                @if(intval(substr($user->stuid, 0, 4)) == 2000 + env('FRESH_YEAR'))
                                    <img src="https://img.shields.io/badge/%E4%B8%9C%E5%8C%97%E5%A4%A7%E5%AD%A6-%E5%AD%A6%E7%94%9F%E8%AE%A4%E8%AF%81-54c0e6.svg">
                                @elseif(intval(substr($user->stuid, 0, 4)) == 2000 + env('FRESH_YEAR') - 1)
                                    <img src="https://img.shields.io/badge/%E4%B8%9C%E5%8C%97%E5%A4%A7%E5%AD%A6-%E5%AD%A6%E7%94%9F%E8%AE%A4%E8%AF%81-a31b3f.svg">
                                @elseif(intval(substr($user->stuid, 0, 4)) == 2000 + env('FRESH_YEAR') - 2)
                                    <img src="https://img.shields.io/badge/%E4%B8%9C%E5%8C%97%E5%A4%A7%E5%AD%A6-%E5%AD%A6%E7%94%9F%E8%AE%A4%E8%AF%81-3ca88e.svg">
                                @elseif(intval(substr($user->stuid, 0, 4)) == 2000 + env('FRESH_YEAR') - 3)
                                    <img src="https://img.shields.io/badge/%E4%B8%9C%E5%8C%97%E5%A4%A7%E5%AD%A6-%E5%AD%A6%E7%94%9F%E8%AE%A4%E8%AF%81-d58d15.svg">
                                @elseif(intval(substr($user->stuid, 0, 4)) < 2000 + env('FRESH_YEAR') - 3)
                                    <img src="https://img.shields.io/badge/%E4%B8%9C%E5%8C%97%E5%A4%A7%E5%AD%A6-%E6%A0%A1%E5%8F%8B%E8%AE%A4%E8%AF%81-bfbfbf.svg">
                                @endif
                            @elseif(strlen($user->stuid) == 7)
                                <img src="https://img.shields.io/badge/%E4%B8%9C%E5%8C%97%E5%A4%A7%E5%AD%A6-%E7%A0%94%E7%A9%B6%E7%94%9F%E8%AE%A4%E8%AF%81-ec3468.svg">
                            @elseif(strlen($user->stuid) == 5)
                                <img src="https://img.shields.io/badge/%E4%B8%9C%E5%8C%97%E5%A4%A7%E5%AD%A6-%E6%95%99%E8%81%8C%E5%B7%A5%E8%AE%A4%E8%AF%81-000000.svg">
                            @endif
                        @endif
                        @if($user->privilege == 1)
                            <img src="https://img.shields.io/badge/%E5%85%88%E9%94%8B%E5%B8%82%E5%9C%BA-%E7%AE%A1%E7%90%86%E5%91%98-9300dd.svg">
                        @elseif($user->privilege == 2)
                            <img src="https://img.shields.io/badge/%E5%85%88%E9%94%8B%E5%B8%82%E5%9C%BA-%E7%AE%A1%E7%90%86%E5%91%98-ee0000.svg">
                        @endif
                    </div>
                </div>
                <div class="col-md-5 col-sm-12" id="profile_bt">
                    @if(Session::get('user_id') == $user->id)
                    @elseif(Session::get('is_admin') >= 1)
                        <form action="/user/{{ $user->id }}/banpage" method="GET" style="position:absolute;bottom:0px">
                            <input type="button" value="和他联系" class="btn btn-info"
                                   onclick="window.location.href='/message/startConversation/{{ $user->id }}'"/>
                            <input type="submit" class="btn btn-danger" value="封禁该用户">
                        </form>
                    @else
                        <form action="/report/{{ $user->id }}" method="GET" style="position:absolute;bottom:0px">
                            <input type="button" value="和他联系" class="btn btn-info"
                                   onclick="window.location.href='/message/startConversation/{{ $user->id }}'"/>
                            <input type="submit" class="btn btn-danger" value="举报该用户">
                        </form>
                    @endif
                </div>
            </div>
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item"><a class="nav-link active" href="#goods" aria-controls="goods" role="tab" data-toggle="tab">他的商品</a></li>
                <li class="nav-item"><a class="nav-link" href="#tickets" aria-controls="tickets" role="tab" data-toggle="tab">历史评价</a></li>
            </ul>
        </div>
        <div class="tab-content card-block">
            <div role="tabpanel" class="tab-pane active" id="goods" style="min-height: 270px">
                <div class="row">
                    @foreach($goods as $good)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="good" style="margin-bottom:20px;">
                                <a href="/good/{{ $good->id }}">
                                    <div class="card">
                                        <div class="card-img-top">
                                            <img src="/good/{{ sha1($good->id) }}/titlepic" title="{{ $good->good_name }}" style="width:100%"/>
                                        </div>
                                        <div class="card-block">
                                            <div style="word-break:break-all">{{ $good->good_name }}</div>
                                            <div class="text-warning"><b>￥{{ $good->price }}</b></div>
                                            @if($good->count==0)
                                                <div class="text-danger">无库存QAQ</div>
                                            @else
                                                <div>库存：{{ $good->count }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                        @if(count($goods)==0)
                            <div style="margin-left:auto;margin-right:auto;">他还没有发布商品呢</div>

                        @endif
                </div>
                {{ $goods->links() }}
            </div>
            <div role="tabpanel" class="tab-pane" id="tickets"  style="min-height: 270px">
                <div class="card-section">
                    <div id="tickets-container" class="card-section">
                        @foreach($tickets as $ticket)
                            <div class="card card-block" style="margin-bottom: 5px">
                                <label>{{ $ticket->created_at }}
                                    @if($ticket->type == 1)
                                        一只小萌妹评价了TA说：
                                    @else
                                        一只小萌妹举报了TA说：
                                    @endif
                                </label>
                                <p>{{ $ticket->message }}</p>
                            </div>
                        @endforeach
                        @if(count($tickets)==0)
                            <div class="row">
                                <div style="margin-left:auto;margin-right:auto;">还没有人评价他呢</div>
                            </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection