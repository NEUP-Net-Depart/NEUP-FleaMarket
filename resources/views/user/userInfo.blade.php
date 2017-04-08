<div class="card">

    @if(count($userinfos) != 0)
        <div class="card-section card-table">
            <table class="card-table" rules="rows">
                <tr>
                    <th>真实姓名</th>
                    <th>手机</th>
                    <th>QQ</th>
                    <th>微信</th>
                    <th>地址</th>
                </tr>

                @foreach($userinfos as $userinfo)
                    <tr>
                        <td>{{ $userinfo->realname }}</td>
                        <td>{{ isset($userinfo->tel_num) ? $userinfo->tel_num : "" }}</td>
                        <td>{{ isset($userinfo->QQ) ? $userinfo->QQ : "" }}</td>
                        <td>{{ isset($userinfo->wechat) ? $userinfo->wechat : "" }}</td>
                        <td>{{ isset($userinfo->address) ? $userinfo->address : "" }}</td>
                    </tr>
                @endforeach
            </table>

        </div>
    @endif
    <a href="javascript: createUserInfo()" class="card-item">
        <div class="card-section">
            <center>添加联系方式</center>
        </div>
    </a>
</div>