<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="manifest" href="/manifest.json">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>[v-cloak]{display: none}</style>
    <title>@yield('title','Put your title here')</title>

</head>
<body>
<div id="app" v-cloak>
    <v-app id="inspire">
        @yield('content')
    </v-app>
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
