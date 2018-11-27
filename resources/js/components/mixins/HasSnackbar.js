export default {
  data () {
    return {

      snackbarMessage: 'Default message',
      snackbarTimeout: 3000,
      snackbarColor: 'success',
      snackbar: false
    }
  },
  methods: {

    showError (error) {
      this.snackbarMessage = error
      this.snackbar = true
      this.snackbarColor = 'error'
    },
    showMessage (message) {
      this.snackbarMessage = message
      this.snackbar = true
      this.snackbarColor = 'success'
    }
  }

}
