<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#2F3BA2"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
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
<div id="app">
    <v-app id="inspire">
        <v-navigation-drawer
      v-model="drawer"
      fixed
      app
    >
      <v-list dense>
        <template v-for="item in items">
          <v-layout
            v-if="item.heading"
            :key="item.heading"
            row
            align-center
          >
            <v-flex xs6>
              <v-subheader v-if="item.heading">
                @{{ item.heading }}
              </v-subheader>
            </v-flex>
            <v-flex xs6 class="text-xs-center">
              <a href="#!" class="body-2 black--text">EDIT</a>
            </v-flex>
          </v-layout>
          <v-list-group
            v-else-if="item.children"
            v-model="item.model"
            :key="item.text"
            :prepend-icon="item.model ? item.icon : item['icon-alt']"
            append-icon=""
          >
            <v-list-tile slot="activator"z>
              <v-list-tile-content>
                <v-list-tile-title>
                  @{{ item.text }}
                </v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
              v-for="(child, i) in item.children"
              :key="i"
              @click=""
              :href="child.url"
            >
              <v-list-tile-action v-if="child.icon" @click="" :href="item.url">
                <v-icon>@{{ child.icon }}</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                <v-list-tile-title>
                  @{{ child.text }}
                </v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
          </v-list-group>
          <v-list-tile v-else :key="item.text" @click="" :href="item.url">
            <v-list-tile-action>
              <v-icon>@{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                @{{ item.text }}
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </template>
      </v-list>
    </v-navigation-drawer>
            {{--<v-list dense>--}}
                {{--<v-list-tile href="tasks">--}}
                    {{--<v-list-tile-action>--}}
                        {{--<v-icon>home</v-icon>--}}
                    {{--</v-list-tile-action>--}}
                    {{--<v-list-tile-content>--}}
                        {{--<v-list-tile-title>Tasques amb PHP</v-list-tile-title>--}}
                    {{--</v-list-tile-content>--}}
                {{--</v-list-tile>--}}
                {{--<v-list-tile href="tasks_vue">--}}
                    {{--<v-list-tile-action>--}}
                        {{--<v-icon>home</v-icon>--}}
                    {{--</v-list-tile-action>--}}
                    {{--<v-list-tile-content>--}}
                        {{--<v-list-tile-title>Tasques amb Vue</v-list-tile-title>--}}
                    {{--</v-list-tile-content>--}}
                {{--</v-list-tile>--}}
                {{--<v-list-tile href="about">--}}
                    {{--<v-list-tile-action>--}}
                        {{--<v-icon>home</v-icon>--}}
                    {{--</v-list-tile-action>--}}
                    {{--<v-list-tile-content>--}}
                        {{--<v-list-tile-title>About</v-list-tile-title>--}}
                    {{--</v-list-tile-content>--}}
                {{--</v-list-tile>--}}
                {{--<v-list-tile href="contact">--}}
                    {{--<v-list-tile-action>--}}
                        {{--<v-icon>home</v-icon>--}}
                    {{--</v-list-tile-action>--}}
                    {{--<v-list-tile-content>--}}
                        {{--<v-list-tile-title>Contacte</v-list-tile-title>--}}
                    {{--</v-list-tile-content>--}}
                {{--</v-list-tile>--}}
            {{--</v-list>--}}
        <v-toolbar color="primary" dark fixed app>
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title>Lo pantano es de La Sénia</v-toolbar-title>
            <v-spacer></v-spacer>
            {{ Auth::user()->name}} {{ Auth::user()->email }}
            <v-avatar>
                <img src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}" alt="avatar">
            </v-avatar>
            <v-form action="logout" method="POST">
                @csrf
                <v-btn type="submit">
                    Logout
                </v-btn>
            </v-form>
        </v-toolbar>
        <v-content>
            <v-container fluid fill-height>
                <v-layout
                        justify-center
                        align-center
                >
                    <v-flex text-xs-center>

                            <span>
<div id="app">
    @yield('content')
</div>
</span>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
        <v-footer color="primary" app inset>
            <span class="white--text">&copy; 2017</span>
        </v-footer>
    </v-app>
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
