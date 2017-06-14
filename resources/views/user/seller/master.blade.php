@extends('layout.master')

@section('title', "我的出售")

@section('asset')
    <style>
        h5 {
            color: #ffffff;
        }

        .trans_msg {
            filter: alpha(opacity=100) revealTrans(duration=.2, transition=1) blendtrans(duration=.2);
            width: 400px;
            height: 200px;
        }
    </style>
@endsection

@section('content')

    <h3>我的出售</h3>
    <div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            @yield('tab-list')
        </ul>
    </div>
    <div class="tab-content card-block">
        @yield('tab-content')
    </div>
    </div>

    <script src="/js/good/ToolTip.js"></script>
    <script>
        function del_good(goodid) {
            if (confirm('确定删除吗？')) {
                var str_data1 = $('#delform').serialize();
                var str_data = str_data1 + '&_method=DELETE';
                $.ajax({
                    type: "POST",
                    url: "/good/" + goodid + "/delete",
                    data: str_data,
                    success: function (msg) {
                        $('#good' + goodid).slideUp();
                    }
                });
            }
        }
        $(document).ready(function () {
            $("a[href='#trans']").click(function () {
                window.location.href = "/user/sell/trans";
            });
            $("a[href='#tickets']").click(function () {
                window.location.href = "/user/sell/tickets";
            });
        });
    </script>
@endsection