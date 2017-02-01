@include('includes.head')
<title>先锋市场</title>
</head>
<body>
@include('layout.header')
    <div class="row">
        <div class="small-12 medium-4 columns thumbnail">
            <img src="/good/{{ sha1($good->id) }}/titlepic"/>
        </div>
        <div class="small-12 medium-7 medium-offset-1 columns">
            <h1>{{ $good->good_name }}</h1>
            <h4 style="color: #cc4b37"><b>￥{{ $good->pricemin }} - ￥{{ $good->pricemax }}</b></h4>
        <div class="row">
        <div class="small-5 columns">
        <form action="/good/{{ $good->id }}/buy" method="post">
            <div class="input-group">
                <input type="number" name="counts" class="input-group-field"/>
                {!! csrf_field() !!}
                <div class="input-group-button">
                    <input type="submit" class="button" value="购买"/>
                </div>
            </div>
        </form>
        </div>
        </div>
        </div>
    </div>
    <div class="row">
        {{ $good->description }}
    </div>
@include('layout.footer')
@include('includes.foot')
