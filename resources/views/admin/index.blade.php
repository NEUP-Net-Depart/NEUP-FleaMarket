@include('includes.head')
    <title>先锋市场</title>
</head>
<body>
@include('layout.header')
<div class="page-content">
Unchecked goods:
@foreach($goods as $good)
    <div class="cat{{$good->cat_id}}"><a href="/good/{{$good->id}}">{{$good->good_name}}</a> <a href="/good/{{$good->id}}/check">Pass</a></div>
@endforeach
<br/>
All users:
@foreach($users as $user)
    <div>
        =============================<br/>
        <a href="/user/{{$user->id}}">{{$user->username}}</a>
        <form action="/user/{{$user->id}}/updatePriv" method="POST">
            <select name="priviledge">
                <option value="0"@if($user->priviledge==0) selected="selected" @endif>Normal user</option>
                <option value="1"@if($user->priviledge==1) selected="selected" @endif>Administrator</option>
                <option value="2"@if($user->priviledge==2) selected="selected" @endif>Super admin</option>
                {!! csrf_field() !!}
                <input type="submit"/>
            </select>
        </form>
        <form action="/user/{{$user->id}}/updateRole" method="POST">
            <select name="role_id">
                <option value="0"@if($user->role_id==0) selected="selected" @endif>Normal user</option>
                <option value="1"@if($user->role_id==1) selected="selected" @endif>Ke Fu</option>
                {!! csrf_field() !!}
                <input type="submit"/>
            </select>
        </form>
        <a href="/user/{{$user->id}}/ban">@if($user->baned==0) Ban</a>@else Unban</a>@endif<br/>
        =============================
    </div>
@endforeach
<br/>
All goods:
<ul>
@foreach($cats as $cat)
    <li>
        {{$cat->cat_name}}
        <form action="/cat/{{$cat->id}}/edit" method="POST">
            <input name="cat_name"/>
            {!! csrf_field() !!}
            <input type="submit"/>
        </form>
        <form action="/cat/{{$cat->id}}/delete" method="POST">
            {!! csrf_field() !!}
            {{ method_field('DELETE') }}
            <input type="submit" value="Delete"/>
        </form>
    </li>
@endforeach
</ul>
<form action="/cat/add" method="POST">
    Add a category: <input name="cat_name"/>
    {!! csrf_field() !!}
    <input type="submit"/>
</form>
</div>
@include('layout.footer')
@include('includes.foot')