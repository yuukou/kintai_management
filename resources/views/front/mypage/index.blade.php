@extends('layouts.default')

@section('content')
    <div class="mypage-wrapper">
        <div class="mypage-content">
            <div class="table-label">登録情報一覧</div>
            <table>
                <tr>
                    <th>名前</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>位置情報１</th>
                    @if(isset($addressList[0]))
                        <td class="address1">{{ $addressList[0] }}</td>
                    @else
                        <td class="address1"><a class="js_set_up_btn btn-square-so-pop">位置情報１を登録する</a></td>
                    @endif
                </tr>
                <tr>
                    <th>位置情報２</th>
                    @if(isset($addressList[1]))
                        <td class="address2">{{ $addressList[1] }}</td>
                    @else
                        <td class="address2"><a class="js_set_up_btn btn-square-so-pop">位置情報２を登録する</a></td>
                    @endif
                </tr>
                <tr>
                    <th>勤怠処理</th>
                    {{--<td>{{ Form::button() }}</td>--}}
                    <td><a class="btn btn-primary" href="{{ route('front::attendance::index') }}">処理を行う</a></td>
                </tr>
            </table>
        </div>
    </div>
@endsection