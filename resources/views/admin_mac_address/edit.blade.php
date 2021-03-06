@extends('layouts.app')

@section('content')
@component('components.header_menu')
@endcomponent
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>MAC Address編集</h2></div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="/admin_mac_address/update" method="post">
                        {{ csrf_field() }}
                        <div>
                            <h3>MAC Address:&nbsp;&nbsp;&nbsp;&nbsp; {{$item->mac_address}}</h3>
                        </div>
                        <div>
                            ID: {{$item->id}}
                        </div>
                        <div>
                            滞在中: {{$item->current_stay}}
                        </div>
                        <div>
                            非表示: {{$item->hide}}
                        </div>
                        <!-- <div>
                            ルーターID: {{$item->router_id}}
                        </div> -->
                        <div>
                            来訪日時: {{$item->arraival_at->format('n月j日 G:i:s')}}
                        </div>
                        <div>
                        @if($item->departure_at != null)
                            退出日時: {{$item->departure_at->format('n月j日 G:i:s')}}
                        @else
                            退出日時: 滞在中
                        @endif
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
                            <label for="InputTextarea">デバイス名</label>
                            <input type="text" class="form-control form-control-lg" name="device_name" value="{{old('device_name', $item->device_name)}}">
                        </div>

                        <div class="form-group">
                            <label for="InputTextarea">vendor</label>
                            <input type="text" class="form-control form-control-lg" name="vendor" value="{{old('vendor', $item->vendor)}}">
                        </div>

                        <div class="form-group">
                            <label for="InputTextarea">登録ユーザー</label>
                            <select name="user_id" class="form-control form-control-lg">
                                @foreach($users as $user)
                                    @if($item->user->id == $user->id)
                                    <?php $selected = 'selected'; ?>
                                    @else
                                    <?php $selected = ''; ?>
                                    @endif
                                    <option value="{{$user->id}}" {{ $selected }}>{{$user->id}}&nbsp;:&nbsp;{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="InputTextarea">表示設定</label>
                            <!-- カッコ悪いけどひとまず速度重視 -->
                            @if($item->hide == 0)
                            <input type="radio" name="hide" value="0" checked="checked">表示する
                            <input type="radio" name="hide" value="1">表示しない
                            @else
                            <input type="radio" name="hide" value="0">表示する
                            <input type="radio" name="hide" value="1" checked="checked">表示しない
                            @endif
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
