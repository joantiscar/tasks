
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
Vue.use(require('vuetify'));

// Windows OCO en bowser Objecte Global

// Browser js

// <script src="/fitxer1.js"></script>

// npm


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('tasks', require('./components/Tasks.vue'));
Vue.component('editable-text', require('./components/EditableText.vue'));

const app = new Vue({
    el: '#app',
    data: () => ({
        drawer: null
    }),
    props: {
        source: String
    }
});
