<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#2F3BA2"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="{{ logged_user() }}">
    <meta name="impersonating" content="{{ app('impersonate')->getImpersonatorId() }}">
    <style>[v-cloak]{display: none}</style>
    <meta name="git" content="{{ git() }}">
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
    <script defer src="{{ (mix('/js/manifest.js')) }}" type="text/javascript"></script>
    <script defer src="{{ (mix('/js/vendor.js')) }}" type="text/javascript"></script>
    <script defer src="{{ (mix('/js/app.js')) }}" type="text/javascript"></script>
    @stack('afterScripts')

    <title>@yield('title','Put your title here')</title>

</head>
<body>
<noscript>
    <strong>We're sorry but frontend doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
</noscript>
    <v-app id="app" v-cloak :dark="dark">
        <snackbar></snackbar>
        <service-worker></service-worker>
        <v-navigation-drawer
                fixed
                v-model="drawerRight"
                right
                clipped
                app
        >

            <v-card>
                <v-card-title class="primary darken-3 white--text"><h4>Perfil</h4></v-card-title>
                <v-layout row wrap>
                    <v-flex xs12>
                        <ul>
                            <li>Nom : {{ Auth::user()->name }}</li>
                            <li>Email : {{ Auth::user()->email }}</li>
                            <li>Admin : {{ Auth::user()->admin ? 'SI' : 'NO' }}</li>
                            <li>Roles : {{ implode(',',Auth::user()->map()['roles']) }}</li>
                            <li>Permissions : {{ implode(', ',Auth::user()->map()['permissions']) }}</li>
                        </ul>
                    </v-flex>
                </v-layout>
            </v-card>
            @canImpersonate
            Administrador:

            Llista de tots els usuaris


            <impersonate url="/api/v1/regular_users"></impersonate>
            @endCanImpersonate


            @impersonating
            El usuari {{ Auth::user()->impersonatedBy()->name }} està suplantant a {{ Auth::user()->impersonatedBy()->name }}
            <a href="/impersonate/leave">Abandonar la suplantació</a>
            @endImpersonating

            <tema></tema>
            <v-switch v-model="dark" label="Mode nocturn"></v-switch>

            <v-form action="logout" method="POST">
                @csrf
                <v-btn type="submit" color="accent">
                    Logout
                </v-btn>


            </v-form>

        </v-navigation-drawer>
        <v-navigation-drawer
      v-model="drawer"
      clipped
      fixed
      app
    >
    <sidebar-menu :items="itemsMenu"></sidebar-menu>
    </v-navigation-drawer>
        <v-toolbar color="primary darken-1" dark fixed app clipped-right clipped-left>
            <v-toolbar-side-icon @click="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title class="hidden-md-and-down">Lo pantano es de La Sénia</v-toolbar-title>
            <v-spacer></v-spacer>
            <notifications-widget></notifications-widget>
            <v-spacer></v-spacer>
            <span v-role="'SuperAdmin'">
                <git-info class="hidden-md-and-down"></git-info>
            </span>
            <v-btn icon @click="" href="/profile">
            <v-avatar>
                <img src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}" alt="avatar">
            </v-avatar>
            </v-btn>

            <v-toolbar-side-icon @click="drawerRight = !drawerRight"></v-toolbar-side-icon>

        </v-toolbar>
        <v-container fill-height fluid>
        <v-content>
                @yield('content')
        </v-content>

        </v-container>
        <footer-component></footer-component>

    </v-app>
</body>
</html>
