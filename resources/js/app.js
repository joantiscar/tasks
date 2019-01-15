
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import AppComponent from './components/App.vue'
import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import './bootstrap'
import ExampleComponent from './components/ExampleComponent.vue'
import Tasks from './components/Tasks.vue'
import Tasques from './components/Tasques.vue'
import Tags from './components/Tags.vue'
import LoginForm from './components/LoginForm.vue'
import RegisterForm from './components/RegisterForm.vue'
import UserList from './components/UserList.vue'
import UserSelect from './components/UserSelect.vue'
import Impersonate from './components/Impersonate.vue'
import Tema from './components/Tema.vue'
import TaskCompletedToggle from './components/TaskCompletedToggle.vue'
import GitInfoComponent from './components/git/GitInfoComponent.vue'
import Profile from './components/Profile.vue'
import Changelog from './components/changelog/ChangelogComponent.vue'
import permissions from './plugins/permissions.js'
import confirm from './plugins/confirm'
import snackbar from './plugins/snackbar'
import VueTimeago from 'vue-timeago'
import TreeView from 'vue-json-tree-view'
require('./bootstrap')

window.Vue = Vue
window.Vuetify = Vuetify
const PRIMARY_COLOR_KEY = 'PRIMARY_COLOR_KEY'
const SECONDARY_COLOR_KEY = 'SECONDARY_COLOR_KEY'
const DARK_THEME_KEY = 'DARK_THEME_KEY'
const DRAWER_STATE_KEY = 'DRAWER_STATE_KEY'
const DRAWER_RIGHT_STATE_KEY = 'DRAWER_RIGHT_STATE_KEY'

const drawerToggle = window.localStorage.getItem(DRAWER_STATE_KEY) || false
const drawerRightToggle = window.localStorage.getItem(DRAWER_RIGHT_STATE_KEY) || false
const darkToggle = window.localStorage.getItem(DARK_THEME_KEY) || false
const primaryColor = window.localStorage.getItem(PRIMARY_COLOR_KEY) || '#BA2525'
const secondaryColor = window.localStorage.getItem(SECONDARY_COLOR_KEY) || '#F0B429'

// window.Vue.use(Vuetify)
window.Vue.use(window.Vuetify, {
  theme: {
    primary: {
      base: primaryColor,
      lighten1: '#D64545',
      lighten2: '#E66A6A',
      lighten3: '#F29B9B',
      lighten4: '#FACDCD',
      lighten5: '#FFEEEE',
      darken1: '#A61B1B',
      darken2: '#911111',
      darken3: '#780A0A',
      darken4: '#610404'
    },
    secondary: {
      base: secondaryColor,
      lighten1: '#F7C948',
      lighten2: '#FADB5F',
      lighten3: '#FCE588',
      lighten4: '#FFF3C4',
      lighten5: '#FFFBEA',
      darken1: '#DE911D',
      darken2: '#CB6E17',
      darken3: '#B44D12',
      darken4: '#8D2B0B'
    },
    accent: {
      base: '#2CB1BC',
      lighten1: '#38BEC9',
      lighten2: '#54D1DB',
      lighten3: '#87EAF2',
      lighten4: '#BEF8FD',
      lighten5: '#E0FCFF',
      darken1: '#14919B',
      darken2: '#0E7C86',
      darken3: '#0A6C74',
      darken4: '#044E54'
    },
    error: {
      base: '#C65D21',
      lighten1: '#E67635',
      lighten2: '#EF8E58',
      lighten3: '#FAB38B',
      lighten4: '#FFD3BA',
      lighten5: '#FFEFE6',
      darken1: '#AB4E19',
      darken2: '#8C3D10',
      darken3: '#77340D',
      darken4: '#572508'
    },
    success: {
      base: '#7BB026',
      lighten1: '#94C843',
      lighten2: '#ABDB5E',
      lighten3: '#C7EA8F',
      lighten4: '#E2F7C2',
      lighten5: '#F2FDE0',
      darken1: '#63921A',
      darken2: '#507712',
      darken3: '#42600C',
      darken4: '#2B4005'
    },
    grey: {
      base: '#857F72',
      lighten1: '#A39E93',
      lighten2: '#B8B2A7',
      lighten3: '#D3CEC4',
      lighten4: '#E8E6E1',
      lighten5: '#FAF9F7',
      darken1: '#625D52',
      darken2: '#504A40',
      darken3: '#423D33',
      darken4: '#27241D'
    }
  }
})
window.Vue.use(confirm)
window.Vue.use(permissions)
window.Vue.use(snackbar)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
window.Vue.component('example-component', ExampleComponent)
window.Vue.component('tasks', Tasks)
window.Vue.component('tags', Tags)
window.Vue.component('tasques', Tasques)
window.Vue.component('login-form', LoginForm)
window.Vue.component('register-form', RegisterForm)
window.Vue.component('user-list', UserList)
window.Vue.component('impersonate', Impersonate)
window.Vue.component('user-select', UserSelect)
window.Vue.component('git-info', GitInfoComponent)
window.Vue.component('task-completed-toggle', TaskCompletedToggle)
window.Vue.component('tema', Tema)
window.Vue.component('profile', Profile)
window.Vue.component('changelog', Changelog)

const app = new window.Vue(AppComponent)
