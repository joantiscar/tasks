<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#2F3BA2"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="{{ logged_user() }}">
    <meta name="impersonating" content="{{ app('impersonate')->getImpersonatorId() }}">
    <style>[v-cloak]{display: none}</style>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://tasks.joantiscar.scool.cat/img/landing_image.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta property="og:description" content="Pos moltes tasques">
    <meta property="og:url" content="https://tasks.joantiscar.scool.cat">
    <meta property="og:title" content="Tasques">
    @stack('beforeScripts')
    <script defer src="{{ url (mix('/js/manifest.js')) }}" type="text/javascript"></script>
    <script defer src="{{ url (mix('/js/vendor.js')) }}" type="text/javascript"></script>
    <script defer src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>
    @stack('afterScripts')

</head>
<body>
<noscript>
    <strong>We're sorry but frontend doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
</noscript>
<v-app id="app" light v-cloak>
    <service-worker></service-worker>

    @yield('content')
</v-app>
</body>
</html>
