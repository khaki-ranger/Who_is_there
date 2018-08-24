@extends('layouts.app')

@section('content')
@component('components.header_menu')
@endcomponent
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Who's There? @ Geek Office Ebisu</h2></div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table table-hover">
                        <tr class="info thead-light">
                            <th>ステータス</th>
                            <th>名前</th>
                            <th>到着日時</th>
                            <th>帰宅日時</th>
                            @auth
                            <th class="text-center">操作</th>
                            @endauth
                        </tr>
                    @foreach ($items as $item)
                    @php
                        $no = $item->id % 16;
                        $png = $no . '.png';
                    @endphp
                        <tr class="table-warning">
                            <td class="align-middle"><b><span style="display: inline-block;">new</span><span style="display: inline-block;">comer!</span></b></td>
                            <td class="align-middle"><span style="display: inline-block;"><img src="{{asset("img/icon/$png")}}" height="50" alt="animal_icon"></span><span style="display: inline-block;">{{$item->vendor}}</span></td>
                            <td class="align-middle">
                                {{date('n/j G:i', strtotime($item->arraival_at))}}
                            </td>
                            <td class="align-middle">...</td>
                            @auth
                            <td class="blockquote text-center align-middle">
                                <a href="/admin_mac_address/edit?id={{$item->id}}" class="btn btn-info" role="button">MAC Adr.編集</a>
                            </td>
                            @endauth
                        </tr>
                    @endforeach
                    @foreach ($items1 as $item)
                        <tr>
                            <td class="align-middle"><b>I'm here!</b></td>
                            <td class="align-middle">{{$item->name}}</td>
                            <td class="align-middle">
                                {{date('n/j G:i', strtotime($item->max_arraival_at))}}
                            </td>
                            <td class="align-middle">...</td>
                            @auth
                            <td class="blockquote text-center align-middle">
                                <a href="/admin_user/edit?id={{$item->user_id}}" class="btn btn-info" role="button">ユーザー編集</a>
                            </td>
                            @endauth
                        </tr>
                    @endforeach
                    @foreach ($items2 as $item)
                        <tr class="table-secondary">
                            <td class="align-middle"></td>
                            <td class="align-middle">{{$item->name}}</td>
                            <td class="align-middle">...</td>
                            <td class="align-middle">
                                {{date('n/j G:i', strtotime($item->max_departure_at))}}
                            </td>
                            @auth
                            <td class="blockquote text-center align-middle">
                                <a href="/admin_user/edit?id={{$item->user_id}}" class="btn btn-info" role="button">ユーザー編集</a>
                            </td>
                            @endauth
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
