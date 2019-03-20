@extends('layouts.default')
@section('content')
    <div id="loader-bg">
        <div id="loading">
            <img src="{{ asset('/img/loading/aws.gif') }}"  alt='' style="height: 200px; width: 200px">
        </div>
    </div>

    {{--<div class="bouncingLoader" style="display: none">--}}
        {{--<div></div>--}}
        {{--<div></div>--}}
        {{--<div></div>--}}
    {{--</div>--}}
    {{--出退勤処理をajaxで行う場合、ここはajax後のdoneでhtmlを埋め込む。--}}
    {{--<div class="attendance_complete" style="display: none"></div>--}}
    {{--ここをpostで行う場合、Sessionで完了メッセージを埋め込む。--}}
    <div class="attendance_result_message_wrapper" style="display: none">
        @include('front.element.form.success_session_alert')
    </div>
    <div id="realTimeClockArea" class="clock"></div>
    <div class="btn_wrapper">
        @if(! Session::get('arrivedFlg') && ! Session::get('leftFlg'))
            {{ Form::button('🌞', ['class' => 'btn on_btn js_attendance_btn', 'id' => 'arrive']) }}
        {{--{{ Form::open(['url' => route('front::attendance::post-store-arrive'), 'method' => 'post', 'class' => 'form-horizontal']) }}--}}
        {{--{{ csrf_field() }}--}}
        {{--{{ Form::hidden('attendance', 'arrive') }}--}}
        {{--{{ Form::submit('🌞', ['class' => 'btn on_btn js_attendance_btn', 'id' => 'arrive']) }}--}}
        {{--{{ Form::close() }}--}}
        <p class="arrive_description">出社</p>
        @elseif(Session::get('arrivedFlg') && ! Session::get('leftFlg'))
            {{ Form::button('🌚', ['class' => "btn on_btn js_attendance_btn", 'id' => 'leave']) }}
        {{--{{ Form::open(['url' => route('front::attendance::post-store-leave'), 'method' => 'post', 'class' => 'form-horizontal']) }}--}}
        {{--{{ csrf_field() }}--}}
        {{--{{ Form::hidden('attendance', 'leave') }}--}}
        {{--{{ Form::submit('🌚', ['class' => "btn on_btn js_attendance_btn", 'id' => 'leave']) }}--}}
        {{--{{ Form::close() }}--}}
        <p class="leave_description">退社</p>
        @elseif(Session::get('arrivedFlg') && Session::get('leftFlg'))
            <p class="good_bye_description">本日も一日お疲れ様でした👼👼👼</p>
        @else
            {{--arrivedFlgが存在せずに、leftFlgが存在する場合は、存在しない。ここの処理は考える。--}}
            <div>存在しない処理です。</div>
        @endif
    </div>
@endsection