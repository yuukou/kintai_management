@extends('layouts.app')
@section('content')
    <div class="container">
        @if(Session::has('result_message'))
            @include('admin.elements.form.success_session_alert')
        @endif
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">本登録の有効期限切れ</div>
                        <div class="timeout_token_description">
                            <p class="txt">仮登録完了メール発行から{{config('project.user.mail_auth_expire_time')}}時間が経過したため、<br>
                                本登録ができませんでした。</p>
                            <p class="txt">本登録を完了するには<br>
                                以下のボタンからメールの再送信を行なってください。</p>
                            <div class="timeout_token_btn">
                                {{ Form::open(['url' => route('front::register::resend-entry-mail-complete', ['token' => $token]), 'method' => 'get']) }}
                                {{ Form::submit('メールを再送信する', ['class' => "btn btn-primary"]) }}
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection