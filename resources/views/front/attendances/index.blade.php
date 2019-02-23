@extends('front.layouts.default')
@section('content')
    <div id="realTimeClockArea" class="clock"></div>
    <div class="btns">
        @if(! $arrivedFlg)
        <div class="btn_wrapper">
            {{ Form::open(['url' => route('postStoreArrive', ['user' => $user->id]), 'method' => 'post', 'class' => 'form-horizontal']) }}
            {{ csrf_field() }}
            {{ Form::hidden('attendance', 'arrive') }}
            {{ Form::submit('🌞', ['class' => 'btn on_btn js_attendance_btn', 'id' => 'arrive']) }}
            {{ Form::close() }}
            <p class="arrive_description">出社</p>
        </div>
        @elseif($arrivedFlg && ! $leftFlg)
        <div class="btn_wrapper">
            {{ Form::open(['url' => route('postStoreLeave', ['user' => $user->id]), 'method' => 'post', 'class' => 'form-horizontal']) }}
            {{ csrf_field() }}
            {{ Form::hidden('attendance', 'leave') }}
            {{ Form::submit('🌚', ['class' => "btn on_btn js_attendance_btn", 'id' => 'leave']) }}
            {{ Form::close() }}
            <p class="leave_description">退社</p>
        </div>
        @else
            <p class="good_bye_description">本日も一日お疲れ様でした👼👼👼</p>
        @endif
    </div>
@endsection