<template>
        <v-autocomplete
                :items="users"
                v-model="selectedUser"
                :clearable="true"
                :label="label"
                item-value="id"
                item-text="nom"
        >
            <template slot="selection" slot-scope="{item: user}">
                <v-chip>
                    <v-avatar :title="user.name">
                        <img :src="user.gravatar" :alt="user.name">
                    </v-avatar>
                    {{user.name}}
                </v-chip>
            </template>
            <!--                                                                                                                                                                                                                                                                                                                                     Fet per lo de La Sénia-->

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
      type: Number,
      default: function () {
        return null
      }
    }
    //                                                                                                                                                                                                                                                                                                                                     Fet per lo de La Sénia
  },
  watch: {
    selectedUser (newValue) {
      if (newValue) {
        this.$emit('selected', newValue)
      } else {
        this.$emit('cleared')
      }
    },
    users () {
      this.dataUsers = this.users
    }
  }
}
</script>
