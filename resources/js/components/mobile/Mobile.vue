<template>
  <v-card>
    <v-card-title><span class="title">Mobile</span></v-card-title>
    <v-card-text>
    <network></network>
    <vibration></vibration>
      <geolocation></geolocation>
    </v-card-text>
  </v-card>
</template>

<script>
import Network from './Network'
import Vibration from './Vibration'
import Geolocation from './Geolocation'
export default {
  name: 'Mobile',
  components: { Geolocation, Vibration, Network }
}
</script>
