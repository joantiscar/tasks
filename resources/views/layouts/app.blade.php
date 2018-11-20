<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>@yield('title','Put your title here')</title>

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
        <v-toolbar color="indigo" dark fixed app>
            <v-toolbar-side-icon @click="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title>Lo pantano es de La Sénia</v-toolbar-title>
            <v-spacer></v-spacer>
            {{ Auth::user()->name}} {{ Auth::user()->email }}
            <v-avatar @click="drawerRight = !drawerRight">
                <img  src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}" alt="avatar">
            </v-avatar>
            <v-form action="logout" method="POST">
                @csrf
                <v-btn type="submit">
                    Logout
                </v-btn>
            </v-form>
        </v-toolbar>
        <v-navigation-drawer
                v-model="drawerRight"
                fixed
                app
                clipped-right
                right
        >
            TODO PERFIL

            Administrador:

            Llista de tots els usuaris


            <user-select></user-select>
            </v-navigation-drawer>
        <v-content fluid fill-height fluid fill-height>
            <v-layout
                    align-center justify-center row fill-height
            >
            <v-flex justify-center grid-list-md text-xs-center>
                @yield('content')
            </v-flex>
            </v-layout>
        </v-content>
        <v-footer color="indigo" app inset>
            <span class="white--text">&copy; 2017</span>
        </v-footer>
    </v-app>
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>