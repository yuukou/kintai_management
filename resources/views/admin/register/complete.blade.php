@extends('layouts.app')
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
                {{ Form::open(['url' => route('admin::resend-entry-mail-complete'), 'method' => 'get']) }}
                {{ Form::submit($name . 'さんへ再度メールを送信する', ['class' => "btn btn-primary"]) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection