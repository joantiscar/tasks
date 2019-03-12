
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

//
import 'typeface-montserrat/index.css'
import 'typeface-roboto/index.css'
import './bootstrap'
import ExampleComponent from './components/ExampleComponent.vue'
import Tasks from './components/Tasks.vue'
import Tasques from './components/tasks/Tasques.vue'
import ShowTask from './components/tasks/ShowTask.vue'
import Tags from './components/tags/Tags.vue'
import LoginForm from './components/LoginForm.vue'
import RegisterForm from './components/RegisterForm.vue'
import UserList from './components/UserList.vue'
import UserSelect from './components/UserSelect.vue'
import Impersonate from './components/Impersonate.vue'
import Tema from './components/Tema.vue'
import TaskCompletedToggle from './components/tasks/TaskCompletedToggle.vue'
import GitInfoComponent from './components/git/GitInfoComponent.vue'
import Profile from './components/Profile.vue'
import SidebarMenu from './components/SidebarMenu.vue'
import Changelog from './components/changelog/ChangelogComponent.vue'
import permissions from './plugins/permissions.js'
import confirm from './plugins/confirm'
import snackbar from './plugins/snackbar'
import VueTimeago from 'vue-timeago'
import TreeView from 'vue-json-tree-view'
import ServiceWorker from './components/ServiceWorker'
import NotificationsWidget from './components/notifications/NotificationsWidget'
import Notifications from './components/notifications/Notifications'
import FooterComponent from './components/FooterComponent.vue'
import NewsLetterSubscriptionCard from './components/newsletter/NewsLetterSubscriptionCard.vue'
import ShareFab from './components/ShareFab'
import Clock from './components/Clock'
import Mobile from './components/mobile/Mobile'
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
const primaryColor = window.localStorage.getItem(PRIMARY_COLOR_KEY) || '#627D98'
const secondaryColor = window.localStorage.getItem(SECONDARY_COLOR_KEY) || '#2BB0ED'



window.Vue.use(VueTimeago, {
  locale: 'ca', // Default locale
  locales: {
    'ca': require('date-fns/locale/ca')
  }
})

window.Vue.use(TreeView)
// window.Vue.use(Vuetify)
window.Vue.use(window.Vuetify, {
  options: {
    customProperties: true
  },
  theme: {
    primary: {
      base: primaryColor,
      lighten1: '#829AB1',
      lighten2: '#9FB3C8',
      lighten3: '#BCCCDC',
      lighten4: '#D9E2EC',
      lighten5: '#F0F4F8',
      darken1: '#486581',
      darken2: '#334E68',
      darken3: '#243B53',
      darken4: '#102A43'
    },
    secondary: {
      base: secondaryColor,
      lighten1: '#40C3F7',
      lighten2: '#5ED0FA',
      lighten3: '#81DEFD',
      lighten4: '#B3ECFF',
      lighten5: '#E3F8FF',
      darken1: '#1992D4',
      darken2: '#127FBF',
      darken3: '#0B69A3',
      darken4: '#035388'
    },
    accent: {
      base: '#DA127D',
      lighten1: '#E8368F',
      lighten2: '#F364A2',
      lighten3: '#FF8CBA',
      lighten4: '#FFB8D2',
      lighten5: '#FFE3EC',
      darken1: '#BC0A6F',
      darken2: '#A30664',
      darken3: '#870557',
      darken4: '#620042'
    },
    error: {
      base: '#E12D39',
      lighten1: '#EF4E4E',
      lighten2: '#F86A6A',
      lighten3: '#FF9B9B',
      lighten4: '#FFBDBD',
      lighten5: '#FFE3E3',
      darken1: '#CF1124',
      darken2: '#AB091E',
      darken3: '#8A041A',
      darken4: '#610316'
    },
    success: {
      base: '#27AB83',
      lighten1: '#3EBD93',
      lighten2: '#65D6AD',
      lighten3: '#8EEDC7',
      lighten4: '#C6F7E2',
      lighten5: '#EFFCF6',
      darken1: '#199473',
      darken2: '#147D64',
      darken3: '#0C6B58',
      darken4: '#014D40'
    },
    grey: {
      base: '#627D98',
      lighten1: '#829AB1',
      lighten2: '#9FB3C8',
      lighten3: '#BCCCDC',
      lighten4: '#D9E2EC',
      lighten5: '#F0F4F8',
      darken1: '#486581',
      darken2: '#334E68',
      darken3: '#243B53',
      darken4: '#102A43'
    }
  }
})
window.axios.interceptors.response.use((response) => {
  return response
}, function (error) {
  if (error) {
    if (error.response) {
      if (error.response.status === 401) {
        console.log('HEY! unauthorized, logging out ...')
        // TODO -> Pass current page as query string '/login?back=CURRENT_URL'
        // this.showSnackBar(error.response.data, 'error', error.response.status)
        window.Vue.prototype.$snackbar.showError("No heu entrat al sistema. Renviant-vos a l'entrada del sistema")
        setTimeout(function () { window.location = '/login' }, 3000)
      }
      // return Promise.reject(error.response)
    }
  }
  return Promise.reject(error)
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
window.Vue.component('show-task', ShowTask)
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
window.Vue.component('sidebar-menu', SidebarMenu)
window.Vue.component('service-worker', ServiceWorker)
window.Vue.component('NotificationsWidget', NotificationsWidget)
window.Vue.component('Notifications', Notifications)
window.Vue.component('FooterComponent', FooterComponent)
window.Vue.component('Mobile', Mobile)
window.Vue.component('NewsLetterSubscriptionCard', NewsLetterSubscriptionCard)
window.Vue.component('share-fab', ShareFab)
window.Vue.component('clock', Clock)

const app = new window.Vue(AppComponent)
