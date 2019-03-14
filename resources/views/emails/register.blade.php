@component('mail::message')
{{ $content['name'] }}様

会員の仮登録が完了しました。
この時点では会員登録は完了していません。
下記URLをクリックして本登録を完了してください。
{{ route('front::login::index', ['token' => $content['token']]) }}

上記URLはこのメール発行後、{{ config('project.user.mail_auth_expire_time')}}時間有効です。
{{ config('project.user.mail_auth_expire_time')}}時間経過した場合は、上記URLは無効となります。
@endcomponent