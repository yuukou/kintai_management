@extends('front.layouts.default')
@section('content')
    <div class="already_attendance">
        @if($exception->getMessage())
            {{ $exception->getMessage() }}
        @endif
    </div>
@endsection