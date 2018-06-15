@if ($paginator->hasPages())
  <div>
    <ul class="pagination" id="_list">
      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <li class="page-item disabled mbl"><span class="page-link pre">&laquo;</span></li>
      @else
        <li class="page-item mbl"><a class="page-link pre" href="{{ $paginator->previousPageUrl() }}"
                                     rel="prev">&laquo;</a></li>
      @endif

      {{-- Pagination Elements --}}
      @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
          <li class="page-item disabled dots"><span class="page-link dots">{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
          @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
              <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
              <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endif
          @endforeach
        @endif
      @endforeach

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <li class="page-item mbl"><a class="page-link nt" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
        </li>
      @else
        <li class="page-item disabled mbl"><span class="page-link nt">&raquo;</span></li>
      @endif
    </ul>
  </div>
@endif
<script>
  $(document).ready(function () {
    var l, w;
    var el = document.getElementById('_list');
    var w = $(".pagination").width()
    l = $(".pagination li").length;
    var num = 0;
    if (w < 510) {
      for (var i = 0; i < l - num; i++) {
        if (!$(".pagination li")[i].classList.contains("mbl")) {
          $(".pagination li")[i].remove();
          i--;
          num++;
        }
      }
      $(".pre").html("&laquo;上一页");
      $(".nt").html("下一页&raquo;");
      var c;
      c = $(".pre").parent().width();
      $(".pagination").css("padding-left", (w - 2 * c) / 2);
    }
  })
</script>