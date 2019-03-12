@extends('layouts.default')
@section('content')
    {{--出退勤処理をajaxで行う場合、ここはajax後のdoneでhtmlを埋め込む。--}}

    {{--ここをpostで行う場合、Sessionで完了メッセージを埋め込む。--}}
    @if(Session::has('attendance_complete'))
        @include('admin.elements.form.success_alert')
    @endif
    <div id="realTimeClockArea" class="clock"></div>
    <div class="btn_wrapper">
        {{--@if(! $)--}}
            {{ Form::button('🌞', ['class' => 'btn on_btn js_attendance_btn', 'id' => 'arrive']) }}
            <p class="arrive_description">出社</p>
        {{--@elseif($arrivedFlg && ! $leftFlg)--}}
            {{ Form::button('🌚', ['class' => "btn on_btn js_attendance_btn", 'id' => 'leave']) }}
            <p class="leave_description">退社</p>
        {{--@else--}}
            {{--<p class="good_bye_description">本日も一日お疲れ様でした👼👼👼</p>--}}
        {{--@endif--}}
    </div>
@endsection