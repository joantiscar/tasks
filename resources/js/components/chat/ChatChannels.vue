<template>
    <span>
        <new-chat-drawer @close="drawer = !drawer" :value="drawer"/>

        <v-toolbar color="primary">
            <v-avatar :user="user" size="52px" @click.stop="profileDrawer =! profileDrawer">
                                <img :src=userAvatar alt="avatar">
            </v-avatar>
            <v-toolbar-title>Channels</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-tooltip bottom>
                <v-btn icon slot="activator" @click="drawer=!drawer">
                    <v-icon>chat</v-icon>
                </v-btn>
                <span>Nova conversació</span>
            </v-tooltip>
            <v-tooltip bottom>
                <v-btn icon slot="activator">
                    <v-icon>more_vert</v-icon>
                </v-btn>
                <span>Menú</span>
            </v-tooltip>
        </v-toolbar>
        <v-container fluid text-xs-center class="ma-0 pa-0">
          <v-layout row wrap>
                                        <profile-drawer v-model="profileDrawer"></profile-drawer>

            <v-flex xs12 style="height: 64px;">
              <v-card dark color="cyan" style="height: 64px;">
                <v-card-text class="px-0">TODO activar notificacions d'escriptori</v-card-text>
              </v-card>
            </v-flex>
            <v-flex xs12>
              <v-card dark style="height: 64px;">
                  search here
              </v-card>
            </v-flex>
            <v-flex xs12 class="scroll-y" style="max-height: calc(100vh - 64px - 64px - 64px - 64px)">
                <v-list subheader>
                    <v-subheader>Recent channels</v-subheader>
                    <v-list-tile
                            v-for="channel in dataChannels"
                            :key="channel.id"
                            avatar
                            @click="$emit('input',channel)"
                    >
                      <v-list-tile-avatar>
                        <img :src="channel.avatar">
                      </v-list-tile-avatar>

                      <v-list-tile-content>
                        <v-list-tile-title v-html="channel.name"></v-list-tile-title>
                      </v-list-tile-content>

                      <v-list-tile-action>
                        <v-icon color="primary">chat_bubble</v-icon>
                      </v-list-tile-action>
                    </v-list-tile>
                  </v-list>
            </v-flex>
          </v-layout>
        </v-container>
    </span>
</template>

<script>
  import UserAvatar from '../ui/UserAvatarComponent'
  import NewChatDrawer from './NewChatDrawer'
  import ProfileDrawer from "./ProfileDrawer"

  export default {
  name: 'ChatChannels',
  components: {
    NewChatDrawer,
    UserAvatar,
    ProfileDrawer,
  },
  data () {
    return {
      drawer: false,
      dataChannels: this.channels,
      profileDrawer: false,
      userAvatar: window.laravel_user.gravatar
    }
  },
  model: {
    prop: 'channel',
    event: 'input'
  },
  props: {
    channels: {
      type: Array,
      required: true
    },
    channel: {}
  },
  created () {
    this.user = window.user
  }
}
</script>
