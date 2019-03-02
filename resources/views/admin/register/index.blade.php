@extends('admin.layouts.app')
@section('content')
<div class="container">
    @if(Session::has('result_message'))
        @include('admin.elements.form.success_alert')
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">登録</div>

                <div class="card-body">
                    {{ Form::open(['url' => route('admin::post-register'), 'method' => 'post', 'class' => 'form-horizontal', 'novalidate']) }}
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">名前</label>

                        <div class="col-md-6">
                            {{ Form::text('name', null, ['id' => 'name', 'class' => 'form-control' . $errors->has('name') ? ' is-invalid' : '', 'value' => old('name'), 'required autofocus']) }}

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>

                        <div class="col-md-6">
                            {{ Form::email('email', null, ['id' => 'email', 'class' => 'form-control' . $errors->has('email') ? ' is-invalid' : '', 'value' => old('email'), 'required']) }}

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                登録
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
