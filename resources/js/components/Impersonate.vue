<template>
  <user-select :users="dataUsers" :label="label" @selected="impersonate"></user-select>
</template>

<script>
export default {
  name: 'Impersonate',
  data () {
    return {
      selectedUser: null,
      dataUsers: this.users
    }
  },
  props: {
    users: {
      type: Array,
      default: function () {
        return []
      }
    },
    url: {
      type: String,
      default: '/api/v1/users'
    },
    label: {
      type: String,
      default: 'Usuaris'
    }
  },
  created () {
    if (this.dataUsers.length === 0) {
      window.axios.get(this.url).then(response => {
        this.dataUsers = response.data
      }).catch(error => {
        this.$snackbar.showError(error.message)
      })
    }
  },
  methods: {
    impersonate (user) {
      console.log('astio')
      console.log(user)
      if (user) {
        window.location.href = ('/impersonate/take/' + user.id)
      }
    }
  }
}
</script>

<style scoped>

</style>
