
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
import permissions from './plugins/permissions.js'
import confirm from './plugins/confirm'
import snackbar from './plugins/snackbar'
require('./bootstrap')

window.Vue = Vue
window.Vuetify = Vuetify
const PRIMARY_COLOR_KEY = 'PRIMARY_COLOR_KEY'
const SECONDARY_COLOR_KEY = 'SECONDARY_COLOR_KEY'

const primaryColor = window.localStorage.getItem(PRIMARY_COLOR_KEY) || '#123456'
const secondaryColor = window.localStorage.getItem(SECONDARY_COLOR_KEY) || '#654321'

// window.Vue.use(Vuetify)
window.Vue.use(Vuetify, {
  theme: {
    primary: {
      base: primaryColor
    },
    secondary: {
      base: secondaryColor
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

const app = new window.Vue(AppComponent)
