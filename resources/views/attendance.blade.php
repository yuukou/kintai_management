@extends('layouts.default')
@section('content')
    <div id="realTimeClockArea" class="clock"></div>
    <form id="postId" method="POST" action="{{ route('checkForIpAddress') }}">
        {{ csrf_field() }}
        <div class="btns">
            <div class="btn_wrapper">
                <button class="btn arrive" id="arrive"
                        type="submit" {{ $checkAttendanceFlg ? "disabled='disabled'" : '' }}>
                    🌞
                </button>
                <p class="arrive_description">出社</p>
            </div>
            <div class="btn_wrapper">
                <button class="btn leave" id="leave"
                        type="submit" {{ $checkAttendanceFlg ? '' : "disabled='disabled'" }}>
                    🌚
                </button>
                <p class="leave_description">退社</p>
            </div>
        </div>
    </form>
@endsection