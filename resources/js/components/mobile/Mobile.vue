<template>
  <v-card>
    <v-card-title><span class="title">Mobile</span></v-card-title>
    <v-card-text>
    <network></network>
    <vibration></vibration>
    </v-card-text>
  </v-card>
</template>

<script>
import Network from './Network'
import Vibration from './Vibration'
export default {
  name: 'Mobile',
  components: { Vibration, Network }
}
</script>
