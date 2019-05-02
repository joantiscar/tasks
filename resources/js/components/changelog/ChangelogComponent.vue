<template>
    <changelog-list :refresh-url="refreshUrl" :return-url="returnUrl" :title="title" :channel="channel" :users="users" :logs="dataLogs"></changelog-list>
</template>

<script>
import ChangelogListComponent from './ChangelogListComponent'
export default {
  name: 'ChangeLogComponent',
  components: {
    'changelog-list': ChangelogListComponent
  },
  props: {
    logs: {
      type: Array,
      required: true
    },
    users: {
      type: Array,
      required: true
    },
    channel: {
      type: String,
      default: 'App.Log'
    },
    title: {
      type: String,
      default: 'Registre de canvis'
    },
    returnUrl: {
      type: String,
      default: null
    },
    refreshUrl: {
      type: String,
      default: '/api/v1/changelog'
    }
  },
    data () {
      return {
        dataLogs: this.logs
      }
    },
    methods: {
      refresh (message = false) {
        this.loading = true
        window.axios.get('/api/v1/changelog').then((response) => {
          this.dataLogs = response.data
          this.loading = false
          if (message) this.$snackbar.showMessage('Logs actualitzats correctament')
        }).catch(error => {
          this.loading = false
          this.$snackbar.showError(error)
        })
      },
      listen() {
        console.log('astio')
        window.Echo.channel('changelog')
          .listen('LogCreated', (notification) => {
            console.log(notification)
            this.refresh()
          })
      }
    },
    mounted () {
        this.loading = true
        window.axios.get('/api/v1/changelog').then((response) => {
          this.dataLogs = response.data
          this.loading = false
        }).catch(error => {
          this.$snackbar.showError(error)
          this.loading = false
        })
      console.log('aaaastioooo')

      this.listen()
    }
}
</script>
