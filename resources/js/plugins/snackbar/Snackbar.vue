<template>
    <v-snackbar :timeout="timeout" :color="color" v-model="show">
        {{ message }}
        <v-btn dark flat @click="show=false">Tancar</v-btn>
    </v-snackbar>
</template>

<script>
import EventBus from '../../eventBus'
export default {
  data () {
    return {
      message: 'Prova',
      timeout: 3000,
      color: 'success',
      show: false
    }
  },
  methods: {
    showMessage (message) {
      this.message = message
      this.color = 'success'
      this.show = true
    },
    showError (error) {
      console.log(error)
      if (error) {
        this.color = 'error'
        if (error.response) {
          this.message = error(error.response.data)
        } else if (error.request) {
          console.log('Status:')
          if (navigator.onLine) {
            console.log('online')
          } else {
            console.log('offline')
          }
          if (navigator.onLine) {
            this.message = error('Error de xarxa')
          } else {
            this.message = ('Error de xarxa. Estat de la xarxa: sense connexió')
          }
        } else {
          // Something happened in setting up the request that triggered an Error
          console.log('Error', error.message)
          this.message = error
        }
        this.show = true
      }
    }
  },
  mounted () {
    EventBus.$on('showSnackbarError', (error) => {
      this.showError(error)
    })
    EventBus.$on('showSnackbarMessage', (message) => {
      this.showMessage(message)
    })
  }
}
</script>
