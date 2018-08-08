@extends('layouts.app')

@section('content')
@component('components.header_menu')
@endcomponent
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Who is There? ユーザー一覧</h2></div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table table-striped table-hover">
                        <tr class="info">
                            <th>id</th>
                            <th>名前</th>
                            <th>ステータス / デバイス</th>
                            <th>到着時間</th>
                            <th>帰宅時間</th>
                            <th>更新日時</th>
                        </tr>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td class="current_stay">
                            @if($item->mac_addresses != null)
                                @foreach($item->mac_addresses as $mac_add)
                                    @if($mac_add->current_stay == 1)
                                        <div>滞在中&nbsp;:&nbsp;{{$mac_add->device_name}}</div>
                                    @else
                                        <div>&nbsp;</div>
                                    @endif
                                @endforeach
                            @endif
                            </td>
                            <td class="arraival_at">
                            @if($item->mac_addresses != null)
                                @foreach($item->mac_addresses as $mac_add)
                                    @if($mac_add->current_stay == 1 && $mac_add->arraival_at > $mac_add->departure_at)
                                        <div>{{$mac_add->arraival_at}}</div>
                                    @else
                                        <div>&nbsp;</div>
                                    @endif
                                @endforeach
                            @endif
                            </td>
                            <td class="departure_at">
                                @if($item->mac_addresses != null)
                                    @foreach($item->mac_addresses as $mac_add)
                                        @if($mac_add->arraival_at < $mac_add->departure_at)
                                            <div>{{$mac_add->departure_at}}</div>
                                        @else
                                            <div>&nbsp;</div>
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td class="last_access">
                                {{$item->last_access}}
                            </td>
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
