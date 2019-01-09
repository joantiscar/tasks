<!DOCTYPE html>
<html>
<head>
    <style>[v-cloak]{display: none}</style>
    <title>Vuetify Parallax Starter</title>
    <meta charset="utf-8">
    <link rel="manifest" href="/manifest.json">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <meta name="theme-color" content="#2F3BA2"/>

</head>
<body>
<div id="app" v-cloak>
    @yield('content')
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
