@extends('layouts.default')
@section('content')
    <div id="realTimeClockArea" class="clock"></div>
    <div class="btns">
        <div class="btn_wrapper">
            {{ Form::open(['url' => route('postStoreArrive', ['user' => $user->id]), 'method' => 'post', 'class' => 'form-horizontal']) }}
            {{ csrf_field() }}
            {{ Form::hidden('attendance', 'arrive') }}
            {{ Form::submit('🌞', ['class' => 'btn arrive'.(! $arrivedFlg ? ' on_btn': ''), 'id' => 'arrive', $arrivedFlg ? "disabled='disabled'" : '']) }}
            {{ Form::close() }}
            <p class="arrive_description">出社</p>
        </div>
        <div class="btn_wrapper">
            {{ Form::open(['url' => route('postStoreLeave', ['user' => $user->id]), 'method' => 'post', 'class' => 'form-horizontal']) }}
            {{ csrf_field() }}
            {{ Form::hidden('attendance', 'leave') }}
            {{ Form::submit('🌚', ['class' => "btn leave".($arrivedFlg && ! $leftFlg ? ' on_btn': '' ), 'id' => 'leave', ! $arrivedFlg || $leftFlg ? "disabled='disabled'" : '']) }}
            {{ Form::close() }}
            <p class="leave_description">退社</p>
        </div>
    </div>
@endsection