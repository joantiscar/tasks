<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#2F3BA2"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>[v-cloak]{display: none}</style>
    <title>@yield('title','Put your title here')</title>
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://tasks.joantiscar.scool.cat/img/landing_image.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta property="og:description" content="Pos moltes tasques">
    <meta property="og:url" content="https://tasks.joantiscar.scool.cat">
    <meta property="og:title" content="Tasques">
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
