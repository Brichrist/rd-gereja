<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href=" {{ mix('css/bootstrap.css') }}" rel="stylesheet">
    <link href=" {{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @stack('css')
</head>
<body>

    @include('layouts.header')

    <div class="mt-5">
        @yield('main')
    </div>



    <script src="{{ mix('js/bootstrap.js') }}"></script>
    @stack('js')
</body>
</html>