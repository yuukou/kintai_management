@extends('layouts.default')
@section('content')
    <div class="not_found_exception">
        @if($exception->getMessage())
            {{ $exception->getMessage() }}
        @endif
    </div>
@endsection