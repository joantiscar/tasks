<template>
    <span></span>
</template>
<script>
export default {
  name: 'ServiceWorker',
  // VULL EXECUTAR EL REGISTRE DEL SERVICE WORKER
  methods: {
    registerServiceWorker () {
      if (!('serviceWorker' in navigator)) {
        console.log('Service workers aren\'t supported in this browser.')
        return
      }
      if (document.readyState === 'complete') {
        window.addEventListener('load', () => {
          this.register()
        })
      } else {
        this.register()
      }
    },
    register () {
      navigator.serviceWorker.register('/sw.js')
        .then(function (registration) {
          console.log('Registration successful, scope is:', registration.scope)

          navigator.serviceWorker.ready
            .then(function (serviceWorkerRegistration) {
              return serviceWorkerRegistration.pushManager.subscribe({
                userVisibleOnly: true
              })
            })
        })
    }
  },
  created () {
    this.registerServiceWorker()
  }

}
</script>
