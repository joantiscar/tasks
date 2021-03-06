
window._ = require('lodash')
window.Popper = require('popper.js').default

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
  window.$ = window.jQuery = require('jquery')

  require('bootstrap')
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios')

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
  window.csrf_token = token.content
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

let vapidPublicKey = document.head.querySelector('meta[name="vapidPublicKey"]')


if (vapidPublicKey) {
  window.vapidPublicKey = vapidPublicKey.content
} else {
  console.error('Vapid public key not found')
}



/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

let user = document.head.querySelector('meta[name="user"]')

if (user) {
  // TODO
  window.laravel_user = JSON.parse(user.content) // JSON.stringify(user)
} else {
  console.error('User not found at html meta')
}
var impersonating = document.head.querySelector('meta[name="impersonating"]');
if (impersonating) {
  // TODO
  window.laravel_user_impersonating = true
}

let gitHeader = document.head.querySelector('meta[name="git"]')
window.git = null
if (gitHeader) if (gitHeader.content) window.git = JSON.parse(gitHeader.content)
import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true
});
