@extends('front.layouts.default')
@section('content')
    <div class="register-complete">
        <div class="register-complete-description">
            登録が完了しました
        </div>
        <a href="{{ route('front::mypage::index') }}" class="btn-gradient-3d-simple">マイページへ</a>
    </div>
@endsection