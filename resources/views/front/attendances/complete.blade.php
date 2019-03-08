@extends('layouts.default')
@section('content')
    <div class="complete_message">
        @if($attendance == 'arrive')
            <span class="attendance_time">{{ $time }}</span><span>{{ $name }}</span>さんの<span>出社処理</span>が完了しました🥳🥳🥳
        @elseif($attendance == 'leave')
            <span class="attendance_time">{{ $time }}</span><span>{{ $name }}</span>さんの<span>退社処理</span>が完了しました😴😴😴
        @else
            エラーです😱😱😱
        @endif
    </div>
@endsection