@extends('layouts.default')
@section('content')
    <div class="shain_only">
        @if($exception->getMessage())
            {{ $exception->getMessage() }}
        @endif
    </div>
@endsection