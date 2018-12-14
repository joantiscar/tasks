<template>
    <v-list two line>
        <v-autocomplete
                :items="users"
                v-model="selectedUser"
                clearable
                :label="label"
        >
            <template slot="selection" slot-scope="{item: user}">
                <v-chip>
                    <v-avatar :title="user.name">
                        <img :src="user.gravatar" :alt="user.name">
                    </v-avatar>
                    {{user.name}}
                </v-chip>
            </template>
            <template slot="item" slot-scope="{item: user}">
                <v-list-tile-avatar>
                <v-avatar :title="user.name">
                <img :src="user.gravatar" alt="avatar">
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
      selectedUser: this.user
    }
  },
  model: {
    prop: 'user',
    event: 'selected'
  },
  props: {
    itemValue: {
      type: String,
      default: 'id'
    },
    users: {
      type: Array,
      required: true
    },
    label: {
      type: String,
      default: 'Usuaris'
    },
    user: {
      type: Object,
      default: function () {
        return {}
      }
    }
  },
  watch: {
    selectedUser (newValue) {
      if (newValue) {
        this.$emit('selected', newValue)
      }
    },
    users () {
      this.dataUsers = this.users
    }
  }
}
</script>

<style scoped>

</style>
