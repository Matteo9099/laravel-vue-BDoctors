<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <div id="root">
        @if (Auth::check())
            <script>window.authUser={!! json_encode(Auth::user()); !!};</script>
        @else
            <script>window.authUser=null;</script>
        @endif
    </div>
    {{-- js --}}
    <script src="{{ asset('js/front.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
