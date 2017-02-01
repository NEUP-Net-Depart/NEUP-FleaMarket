@include('includes.head')
    <title>先锋市场</title>
@include('layout.header')
<div class="row">
    <div class="small-12 medium-8 columns">
    <div class="orbit" role="region" aria-label="热销商品" data-orbit>
        <ul class="orbit-container">
        @if(count($hotgoods) > 1)
        <button class="orbit-previous"><span class="show-for-sr">←</span>&#9664;&#xFE0E;</button>
        <button class="orbit-next"><span class="show-for-sr">→</span>&#9654;&#xFE0E;</button>
        @endif
        @foreach($hotgoods as $good)
            <li class="orbit-slide">
                <a href="/good/{{ $good->id }}"><img class="orbit-image" src="/good/{{ sha1($good->id) }}/titlepic" alt="{{ $good->name }}"/>
                <figcaption class="orbit-caption">{{ $good->good_name }}</figcaption></a>
            </li>
        @endforeach
        </ul>
    </div>
    </div>
    <div class="small-12 medium-4 columns">
        <div class="medium-10 medium-offset-2 columns">
            <h3>公告</h3>
            <ul class="accordion" data-accordion data-allow-all-closed="true" data-multi-expand="true">
                @foreach($announces as $announce)
                <li class="accordion-item" data-accordion-item>
                    <a href="#" class="accordion-title">{{ $announce->title }}</a>
                    <div class="accordion-content" data-tab-content>
                        {{ $announce->summary }}<br/>
                        <a href="/announcement/{{ $announce->id }}" class="button tiny">More</a>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@include('layout.footer')
@include('includes.foot')
