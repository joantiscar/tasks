<template>
    <v-list two line>
        <v-autocomplete
                :items="dataUsers"
                v-model="selectedUser"
                clearable
                item-value="id"
        >
            <template slot="selection" slot-scope="{item: user}">
                <v-chip>
                    <v-avatar :title="user.name">
                        <img :src="user.avatar" :alt="user.name">
                    </v-avatar>
                    {{user.name}},
                </v-chip>
            </template>
            <template slot="item" slot-scope="{item: user}">
                <v-list-tile-avatar>
                <v-avatar :title="user.name">
                <img :src="user.avatar" alt="avatar">
                </v-avatar>
                </v-list-tile-avatar>
                <v-list-tile-content>
                <v-list-tile-title>{{user.name}}</v-list-tile-title>
                <v-list-tile-sub-title>{{user.email}}</v-list-tile-sub-title>
                </v-list-tile-content>
            </template>
        </v-autocomplete>

    </v-list>
</template>

<script>
export default {
  name: 'UserSelect',
  data () {
    return {
      selectedUser: null,
      dataUsers: this.users
    }
  },
  props: {
    users: {
      type: Array
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
  watch: {
    selectedUser (newValue) {
      if (newValue) {
        this.$emit('selected', newValue)
      }
    }
  },
  created () {
    if (this.users) this.dataUsers = this.users
    else {
      window.axios.get(this.url).then(response => {
        this.dataUsers = response.data
      }).catch(error => {
        console.log(error)
        // this.$snackbar.showerror(error)
      })
    }
  }
}
</script>

<style scoped>

</style>
