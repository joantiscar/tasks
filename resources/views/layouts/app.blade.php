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
    <style>[v-cloak]{display: none}</style>
    <meta name="git" content="{{ git() }}">

    <title>@yield('title','Put your title here')</title>

</head>
<body>
<div id="app" v-cloak>
    <snackbar></snackbar>
    <v-app id="inspire" :dark="dark">
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


            <impersonate url="/api/v1/regular_users" ></impersonate>
            @endCanImpersonate


            @impersonating
            El usuari {{ Auth::user()->impersonatedBy()->name }} està suplantant a {{ Auth::user()->impersonatedBy()->name }}
            <a href="/impersonate/leave">Abandonar la suplantació</a>
            @endImpersonating

            <tema></tema>

        </v-navigation-drawer>
        <v-navigation-drawer
      v-model="drawer"
      clipped
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
              v-bind:class="{ active: isActive(child.url) }"
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
        <v-toolbar color="primary darken-1" dark fixed app clipped-right clipped-left>
            <v-toolbar-side-icon @click="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title>Lo pantano es de La Sénia</v-toolbar-title>
            <v-spacer></v-spacer>

            <span v-role="'SuperAdmin'"><git-info></git-info></span>
            <v-btn icon @click="" href="/profile">
            <v-avatar>
                <img src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}" alt="avatar">
            </v-avatar>
            </v-btn>
            <v-form action="logout" method="POST">
                @csrf
                <v-btn type="submit" color="accent">
                    Logout
                </v-btn>
                <v-btn icon @click.native="dark = !dark"><v-icon>lens</v-icon></v-btn>

                <v-toolbar-side-icon color="grey darken-1" @click="drawerRight = !drawerRight"></v-toolbar-side-icon>

            </v-form>

        </v-toolbar>

        <v-content fluid fill-height fluid fill-height>
            <v-layout
                    align-center justify-center row fill-height
            >
            <v-flex justify-center grid-list-md text-xs-center>
                @yield('content')
            </v-flex>
            </v-layout>
        </v-content>
        <v-footer color="primary" app inset>
            <span class="white--text">&copy; 2017</span>
        </v-footer>
    </v-app>
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
