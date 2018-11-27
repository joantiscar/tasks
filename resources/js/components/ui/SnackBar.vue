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

      message: 'Default message',
      timeout: 3000,
      color: 'success',
      show: false
    }
  },
  methods: {

    showError (error) {
      this.message = error
      this.show = true
      this.color = 'error'
    },
    showMessage (message) {
      this.message = message
      this.show = true
      this.color = 'success'
    }
  },
  mounted () {
    EventBus.$on('showSnackbar', () => {
      this.show = true
    })
    EventBus.$on('showSnackbarError', (error) => {
      this.showError(error)
    })
    EventBus.$on('showSnackbarMessage', (message) => {
      this.showMessage(message)
    })
  }

}

</script>

<style scoped>

</style>
