@extends('front.layouts.default')

@section('content')
    <div class="mypage-wrapper">
        <div class="mypage-content">
            <div class="table-label">登録情報一覧</div>
            <table>
                <tr>
                    <th>名前</th>
                    <td>社員の名前が入るよ</td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td>社員のメアドが入るよ</td>
                </tr>
                <tr>
                    <th>位置情報１</th>
                    <td><a class="js_set_up_btn">位置情報１を登録する</a></td>
                </tr>
                <tr>
                    <th>位置情報２</th>
                    <td><a class="js_set_up_btn">位置情報２を登録する</a></td>
                </tr>
            </table>
        </div>
    </div>
@endsection