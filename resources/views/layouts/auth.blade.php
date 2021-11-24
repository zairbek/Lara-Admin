<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Future Админ' }}</title>
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a><b>Future</b>Admin</a>
    </div>

    @yield('content')

</div>


<script src="{{ asset('dist/js/app.js') }}"></script>
</body>
</html>
