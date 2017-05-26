@extends('layout.master')

@section('title', "我的订单")

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

    <h3>我的订单</h3>
    <div class="card-section">
        <div class="row">
            <table class="table">
                <tr>
                    <td>订单编号</td>
                    <td>商品名称</td>
                    <td>数量</td>
                    <td>订单状态</td>
                    <td>取消订单</td>
                </tr>
                @foreach($trans as $tran)
                    <tr id="tran{{ $tran->id }}">
                        <td>{{ $tran->id }}</td>
                        <td><a href="/good/{{$tran->good_id}}"
                               onMouseOver="toolTip('<img src=/good/{{ sha1($tran->good_id) }}/titlepic>')"
                               onMouseOut="toolTip()">{{ $tran->good->good_name }}</a></td>
                        <td>{{ $tran->number }}</td>
                        <td>{{ $tran->status }}</td>
                        <td>

                            <form method="POST" id="delform">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}

                            </form>
                            <input type="submit" class="button" value="取消" style="margin: 0;" id="delbutton"
                                   onclick="del_trans({{ $tran->id }})">
                        </td>

                    </tr>

                @endforeach
                {{ $trans->links() }}
            </table>
        </div>
    </div>

@endsection