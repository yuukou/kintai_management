@extends('layouts.app')
@section('content')
<div class="container">
    @if(Session::has('result_message'))
        @include('admin.elements.form.success_session_alert')
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">登録</div>

                <div class="card-body">
                    {{ Form::open(['url' => route('admin::post-register'), 'method' => 'post', 'class' => 'form-horizontal', 'novalidate']) }}
                    @csrf

                    <div class="form-group row">
                        {{ Form::label('name', '名前', ['class' => 'col-md-4 col-form-label text-md-right']) }}
                        {{--<label for="name" class="col-md-4 col-form-label text-md-right">名前</label>--}}

                        <div class="col-lg-6 col-sm-12">
                            {{--{{ Form::text('name', null, ['id' => 'name', 'class' => 'form-control' . $errors->has('name') ? ' is-invalid' : '', 'value' => old('name'), 'required autofocus']) }}--}}
                            {{ Form::text('name', null, ['id' => 'name', 'class' => 'form-control', 'value' => old('name'), 'required autofocus']) }}

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('email', 'メールアドレス', ['class' => 'col-md-4 col-form-label text-md-right']) }}
                        {{--<label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>--}}

                        <div class="col-md-6">
                            {{--{{ Form::email('email', null, ['id' => 'email', 'class' => 'form-control' . $errors->has('email') ? ' is-invalid' : '', 'value' => old('email'), 'required']) }}--}}
                            {{ Form::email('email', null, ['id' => 'email', 'class' => 'form-control', 'value' => old('email'), 'required']) }}

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('password', 'パスワード', ['class' => 'col-md-4 col-form-label text-md-right']) }}
                        {{--<label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>--}}

                        <div class="col-md-6">
                            {{--{{ Form::password('password', ['id' => 'password', 'class' => 'form-control' . $errors->has('email') ? ' is-invalid' : '', 'value' => old('password'), 'required']) }}--}}
                            {{ Form::password('password', ['id' => 'password', 'class' => 'form-control', 'required']) }}

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('password-confirm', 'パスワード（確認用）', ['class' => 'col-md-4 col-form-label text-md-right']) }}
                        {{--<label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>--}}

                        <div class="col-md-6">
                                {{--{{ Form::password('password_confirmation', ['id' => 'password-confirm', 'class' => 'form-control' . $errors->has('password') ? ' is-invalid' : '', 'value' => old('password'), 'required']) }}--}}
                            {{ Form::password('password_confirmation', ['id' => 'password-confirm', 'class' => 'form-control', 'required']) }}

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            {{ Form::submit('登録', ['class' => 'btn btn-primary']) }}
                            {{--<button type="submit" class="btn btn-primary">--}}
                                {{--登録--}}
                            {{--</button>--}}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
