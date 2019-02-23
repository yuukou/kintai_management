<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>kintai管理システム</title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Kosugi+Maru&amp;subset=japanese" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('/css/attendance.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmW2NNjAG61yBadklIPn0jNaIeZPeE-l4"></script>
    <script src="{{ mix('/js/attendance.js') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/top_redirect.js') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/clock.js') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/set_up.js') }}" type="text/javascript"></script>
    <!--[if lt IE 9]>
    <script src="//cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    {{--<link rel="shortcut icon" href="">--}}
</head>
<body>
<div class="container attendance">
    @yield('content')
</div>
</body>
</html>