@extends('layouts.app')

@section('content')
@component('components.header_menu')
@endcomponent
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>ユーザー編集</h2></div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="/admin_user/update" method="post">
                        {{ csrf_field() }}
                        <div>
                            <h3>ID: {{$item->id}}</h3>
                        </div>
                        <div>
                            最終来訪: {{$item->last_access->format('n月j日 G:i:s')}}
                        </div>
                        <div>
                            登録日時: {{$item->created_at->format('n月j日 G:i:s')}}
                        </div>
                        <div>
                            更新日時: {{$item->updated_at->format('n月j日 G:i:s')}}
                        </div>
                        <hr>
                        <input type="hidden" name="id" value="{{$item->id}}">
                        @component('components.error')
                        @endcomponent
                        <div class="form-group">
                            <label for="InputTextarea">名前</label>
                            <input type="text" class="form-control form-control-lg" name="name" value="{{old('name', $item->name)}}">
                        </div>
                        <div class="form-group">
                            <label for="InputTextarea">Email</label>
                            <input type="text" class="form-control form-control-lg" name="email" value="{{old('email', $item->email)}}">
                        </div>
                        <div class="form-group">
                            <label for="InputTextarea">管理権限&nbsp;&nbsp;</label>
                            <!-- カッコ悪いけどひとまず速度重視 -->
                        @if($item->admin_user == 0)
                            <input type="radio" name="admin_user" value="1">ON&nbsp;&nbsp;
                            <input type="radio" name="admin_user" value="0" checked="checked">OFF
                        @else
                            <input type="radio" name="admin_user" value="1" checked="checked">ON&nbsp;&nbsp;
                            <input type="radio" name="admin_user" value="0">OFF
                        @endif
                        </div>
                        <div class="form-group">
                            <label for="InputTextarea">表示設定&nbsp;&nbsp;</label>
                            <!-- カッコ悪いけどひとまず速度重視 -->
                        @if($item->hide == 0)
                            <input type="radio" name="hide" value="0" checked="checked">表示&nbsp;&nbsp;
                            <input type="radio" name="hide" value="1" >非表示
                        @else
                            <input type="radio" name="hide" value="0">表示&nbsp;&nbsp;
                            <input type="radio" name="hide" value="1" checked="checked">非表示
                        @endif
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="InputTextarea">デバイス（所有するデバイスをチェックして登録）</label>
                            <table class="table table-hover">
                                <tr class="info thead-light">
                                    <th>owner</th>
                                    <th>ID</th>
                                    <th>滞在中</th>
                                    <th>MAC Address</th>
                                    <th>Vendor</th>
                                    <th>デバイス名</th>
                                    <th>ルーターID</th>
                                    <th>来訪日時</th>
                                    <th>posted_at</th>
                                    <th>登録日時</th>
                                </tr>
                        @foreach($mac_addresses as $mac_add)
                            @if($mac_add->hide == true)
                                <tr class="table-secondary">
                            @elseif($mac_add->current_stay == true && $mac_add->user_id == 1)
                                <tr class="table-warning">
                            @elseif($mac_add->current_stay == true)
                                <tr class="table-info">
                            @elseif($mac_add->user_id == $item->id)
                                <tr class="table-info">
                            @else
                                <tr>
                            @endif
                            @if($mac_add->user_id == $item->id)
                                    <td>
                                        <input type="checkbox" name="mac_addres_id[]" value="{{$mac_add->id}}" checked="checked">
                                    </td>
                            @else
                                    <td>
                                        <input type="checkbox" name="mac_addres_id[]" value="{{$mac_add->id}}">
                                    </td>
                            @endif
                                    <td>{{$mac_add->id}}</td>
                                    <td>{{$mac_add->current_stay}}</td>
                                    <td>{{$mac_add->mac_address}}</td>
                                    <td>{{$mac_add->vendor}}</td>
                                    <td>{{$mac_add->user_id}}:{{$mac_add->device_name}}</td>
                                    <td>{{$mac_add->router_id}}</td>
                                    <td>{{Carbon\Carbon::parse($mac_add->arraival_at)->format('n月j日 G:i')}}</td>
                                    <td>{{Carbon\Carbon::parse($mac_add->posted_at)->format('n月j日 G:i')}}</td>
                                    <td>{{Carbon\Carbon::parse($mac_add->created_at)->format('n月j日 G:i')}}</td>
                                </tr>
                        @endforeach
                            </table>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                編集
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
