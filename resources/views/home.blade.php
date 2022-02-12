<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel React</title>

    <link href="{{ URL::asset('/assets/react/css/front.min.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ URL::asset('assets/react/js/front.min.js') }}"></script>
</head>

<body>
    <a title="Login now" href="{{ url('/login') }}" class="btn btn-info btn-lg">
        Login Now
    </a>
    <div id="root"></div>
</body>

</html>
