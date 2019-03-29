importScripts("/service-worker/precache-manifest.80982a4dc95434c31741d920728c4822.js", "https://storage.googleapis.com/workbox-cdn/releases/3.6.3/workbox-sw.js");

/* eslint-disable no-undef */
workbox.setConfig({
  debug: true
});
workbox.core.skipWaiting()
workbox.core.clientsClaim()

workbox.precaching.cleanupOutdatedCaches()
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
  event.waitUntil(self.registration.showNotification(title, options))
})

workbox.precaching.precacheAndRoute(self.__precacheManifest)
// workbox.precaching.precacheAndRoute([]) També funciona i workbox substitueix pel que pertoca -> placeholder

// static
workbox.routing.registerRoute(
  new RegExp('.(?:ico)$'),
  workbox.strategies.networkFirst({
    cacheName: 'icons'
  })
)

workbox.routing.registerRoute(
  '/',
  new workbox.strategies.StaleWhileRevalidate({ cacheName: 'landing' })
)

workbox.routing.registerRoute(
  new RegExp('/tasques'),
  new workbox.strategies.NetworkFirst()
);


const bgSyncPlugin = new workbox.backgroundSync.Plugin('newsletter', {
  maxRetentionTime: 24 * 60, // Retry for max of 24 Hours
  callbacks: {
    queueDidReplay: showNotification
  }
})

workbox.routing.registerRoute(
  '/api/v1/newsletter',
  new workbox.strategies.NetworkOnly({
    plugins: [bgSyncPlugin]
  }),
  'POST'
)

workbox.routing.registerRoute(
  '/api/v1/newsletter',
  new workbox.strategies.NetworkOnly({
    plugins: [bgSyncPlugin]
  }),
  'POST'
)
// NO ENS CAL PQ LES TENIM INTEGRADES EN LOCAL VIA WEBPACK i NMP IMPORTS
// // fonts
// workbox.routing.registerRoute(
//   new RegExp('https://fonts.*'),
//   workbox.strategies.cacheFirst({
//     cacheName: 'fonts',
//     plugins: [
//       new workbox.cacheableResponse.Plugin({
//         statuses: [0, 200]
//       })
//     ]
//   })
// )
//
// // google stuff
// workbox.routing.registerRoute(
//   new RegExp('.*(?:googleapis|gstatic).com.*$'),
//   workbox.strategies.networkFirst({
//     cacheName: 'google'
//   })
// )
//
// // static
// workbox.routing.registerRoute(
//   new RegExp('.(?:js|css|ico)$'),
//   workbox.strategies.networkFirst({
//     cacheName: 'static'
//   }),
// )
//
// // images
workbox.routing.registerRoute(
  new RegExp('.(?:jpg|png|gif|svg|webp)$'),
  workbox.strategies.cacheFirst({
    cacheName: 'images',
    plugins: [
      new workbox.expiration.Plugin({
        maxEntries: 20,
        purgeOnQuotaError: true,
      })
    ]
  }))

