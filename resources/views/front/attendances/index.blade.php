@extends('layouts.default')
@section('content')
    {{--出退勤処理をajaxで行う場合、ここはajax後のdoneでhtmlを埋め込む。--}}
    {{--<div class="attendance_complete" style="display: none"></div>--}}
    {{--ここをpostで行う場合、Sessionで完了メッセージを埋め込む。--}}
    @if(Session::has('result_message'))
        @include('front.element.form.success_session_alert')
    @endif

    <div id="realTimeClockArea" class="clock"></div>
    <div class="btn_wrapper">
        @if(! Session::get('arrivedFlg') && ! Session::get('leftFlg'))
            {{--{{ Form::button('🌞', ['class' => 'btn on_btn js_attendance_btn', 'id' => 'arrive']) }}--}}
        {{ Form::open(['url' => route('front::attendance::post-store-arrive'), 'method' => 'post', 'class' => 'form-horizontal']) }}
        {{ csrf_field() }}
        {{ Form::hidden('attendance', 'arrive') }}
        {{ Form::submit('🌞', ['class' => 'btn on_btn js_attendance_btn', 'id' => 'arrive']) }}
        {{ Form::close() }}
        <p class="arrive_description">出社</p>
        @elseif(Session::get('arrivedFlg') && ! Session::get('leftFlg'))
            {{--{{ Form::button('🌚', ['class' => "btn on_btn js_attendance_btn", 'id' => 'leave']) }}--}}
        {{ Form::open(['url' => route('front::attendance::post-store-leave'), 'method' => 'post', 'class' => 'form-horizontal']) }}
        {{ csrf_field() }}
        {{ Form::hidden('attendance', 'leave') }}
        {{ Form::submit('🌚', ['class' => "btn on_btn js_attendance_btn", 'id' => 'leave']) }}
        {{ Form::close() }}
        <p class="leave_description">退社</p>
        @else
            <p class="good_bye_description">本日も一日お疲れ様でした👼👼👼</p>
        @endif
    </div>
@endsection