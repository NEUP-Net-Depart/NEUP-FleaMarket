@include('includes.head')
    <title>先锋市场</title>
@include('layout.header')
<style>
    #slides {
        display:none;
    }
</style>
<div class="row">
    <div class="small-12 medium-8 columns">
    <div id="slides">
        @foreach($hotgoods as $good)
            <a href="/good/{{ $good->id }}"><img src="/good/{{ sha1($good->id) }}/titlepic"/></a>
        @endforeach
    </div>
    </div>
    <div class="small-12 medium-4 columns">
        <div class="medium-8 medium-offset-4 columns" style="background-color:#66ccff">
        公告的位置
        </div>
    </div>
</div>
<script>
    $(function(){
        $("#slides").slidesjs({
            navigation: {
                active: false,
            },
            play: {
                active: false,
                effect: "slide",
                interval: 5000,
                auto: true,
                swap: true,
                pauseOnHover: false,
                restartDelay: 2500
            }
        });
    });
</script>
@include('layout.footer')
@include('includes.foot')
