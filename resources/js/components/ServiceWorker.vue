<template>
    <span></span>
</template>
<script>
export default {
  name: 'ServiceWorker',
  // VULL EXECUTAR EL REGISTRE DEL SERVICE WORKER
  methods: {
    registerServiceWorker () {
      if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/service-worker.js')
          .then(function (registration) {
            console.log(('Registration successful, sope is: ' + registration.scope))
          })
          .catch(function (error) {
            console.log('Service worker registration failed, error: ' + error)
          })
      } else {
        console.log('missatge d\'error')
      }
    }
  },
  created () {
        this.registerServiceWorker()
  }

}
</script>
