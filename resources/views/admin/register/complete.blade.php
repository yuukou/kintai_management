@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card register-complete">
                    <div class="card-body">
                        登録完了。
                    </div>
                </div>
                {{ Form::open(['url' => route('admin::register'), 'method' => 'get']) }}
                {{ Form::submit('登録ページへ移動する', ['class' => "btn btn-primary"]) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection