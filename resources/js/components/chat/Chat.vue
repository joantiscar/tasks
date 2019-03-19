<template>
    <v-container fluid class="ma-0 pa-0">
        <v-layout row wrap>
            <v-flex sm12 md3>
                <chat-channels></chat-channels>
            </v-flex>
            <v-flex sm12 md9>
                <chat-channel></chat-channel>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import ChatChannels from './ChatChannels'
import ChatChannel from './ChatChannel'
export default {
  name: 'CHAT',
  components: {
    'chat-channels': ChatChannels,
    'chat-channel': ChatChannel
  }
}
</script>
