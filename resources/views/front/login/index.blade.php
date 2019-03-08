@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">ログイン</div>

                    <div class="card-body">
                        {{ Form::open(['url' => route('front::login::post', ['token' => $token]), 'method' => 'post', 'class' => 'form-horizontal', 'novalidate']) }}
                            @csrf

                            <div class="form-group row">
                                {{ Form::label('email', 'メールアドレス', ['class' => 'col-md-4 col-form-label text-md-right']) }}

                                <div class="col-md-6">
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

                                <div class="col-md-6">
                                    {{ Form::password('password', ['id' => 'password', 'class' => 'form-control', 'required']) }}

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        {{ Form::checkbox('remember', 1, null, ['class' => 'form-check-input', 'id' => 'remember', old('remember') ? 'checked' : '']) }}

                                        {{ Form::label('remember', 'ログイン状態を保存する', ['class' => 'form-check-label']) }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        ログイン
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
