importScripts("/service-worker/precache-manifest.836a178831aaab25d2cd6547e83eb8bc.js", "https://storage.googleapis.com/workbox-cdn/releases/3.6.3/workbox-sw.js");

/* eslint-disable no-undef */
workbox.setConfig({
  debug: true
});
workbox.skipWaiting()
workbox.clientsClaim()

// workbox.routing.registerRoute(
//   new RegExp('https://hacker-news.firebaseio.com'),
//   workbox.strategies.staleWhileRevalidate()
// );

// TODO cal utilitzar PushManager al registrar el service worker
self.addEventListener('push', (event) => {
  const title = 'TODO CANVIAR TITOL'
  const options = {
    body: event.data.text()
  }
})

workbox.precaching.precacheAndRoute(self.__precacheManifest)

workbox.routing.registerRoute(
  new RegExp('https://tasks.*/img/*.*(?:jpg|jpeg|png|gif|svg|webp)$'),
  new workbox.strategies.CacheFirst({
    cacheName: 'images',
    plugins: [
      new workbox.expiration.Plugin({
        maxEntries: 20,
        purgeOnQuotaError: true
      })
    ]
  })
)

workbox.routing.registerRoute(
  '/',
  new workbox.strategies.NetworkFirst({ cacheName: 'landing' })
)

workbox.routing.registerRoute(
  '/tasques',
  new workbox.strategies.NetworkFirst({ cacheName: 'tasques' })
)

workbox.routing.registerRoute(
  '/api/v1/tasks',
  new workbox.strategies.NetworkFirst({ cacheName: 'api/v1/tasks' })
)

workbox.routing.registerRoute(
  '/api/v1/tasks',
  new workbox.strategies.NetworkOnly({ plugins: [bgSyncPlugin] }),
  'POST'
)

workbox.routing.registerRoute(
  '/api/v1/regular_users',
  new workbox.strategies.NetworkFirst({ cacheName: 'api/v1/regular_users' })
)

workbox.routing.registerRoute(
  '/api/v1/user/unread_notifications ',
  new workbox.strategies.NetworkFirst({ cacheName: 'api/v1/user/unread_notifications' })
)

const WebPush = {
  init () {
    self.addEventListener('push', this.notificationPush.bind(this))
    self.addEventListener('notificationclick', this.notificationClick.bind(this))
    self.addEventListener('notificationclose', this.notificationClose.bind(this))
  },

  /**
   * Handle notification push event.
   *
   * https://developer.mozilla.org/en-US/docs/Web/Events/push
   *
   * @param {NotificationEvent} event
   */
  notificationPush (event) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
      return
    }

    // https://developer.mozilla.org/en-US/docs/Web/API/PushMessageData
    if (event.data) {
      event.waitUntil(
        this.sendNotification(event.data.json())
      )
    }
  },
  /**
   * Handle notification click event.
   *
   * https://developer.mozilla.org/en-US/docs/Web/Events/notificationclick
   *
   * @param {NotificationEvent} event
   */
  notificationClick (event) {
    // console.log(event.notification)
    if (event.action === 'some_action') {
      // Do something...
      // TODO
    } else {
      self.clients.openWindow('/')
    }
  },

  /**
   * Handle notification close event (Chrome 50+, Firefox 55+).
   *
   * https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorkerGlobalScope/onnotificationclose
   *
   * @param {NotificationEvent} event
   */
  notificationClose (event) {
    self.registration.pushManager.getSubscription().then(subscription => {
      if (subscription) {
        this.dismissNotification(event, subscription)
      }
    })
  },

  /**
   * Send notification to the user.
   *
   * https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorkerRegistration/showNotification
   *
   * @param {PushMessageData|Object} data
   */
  sendNotification (data) {
    return self.registration.showNotification(data.title, data)
  },

  /**
   * Send request to server to dismiss a notification.
   *
   * @param  {NotificationEvent} event
   * @param  {String} subscription.endpoint
   * @return {Response}
   */
  dismissNotification ({ notification }, { endpoint }) {
    console.log('dismissNotification triggered!')
    if (!notification.data || !notification.data.id) {
      return
    }

    const data = new FormData()
    data.append('endpoint', endpoint)

    // Send a request to the server to mark the notification as read.
    fetch(`/api/v1/unread_notifications/${notification.data.id}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      },
      method: 'POST',
      body: data
    })
  }
}
WebPush.init()

