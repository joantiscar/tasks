<template>
  <span>
  <v-btn :disabled="disabled" @click="getLocation">{{buttonText}}</v-btn>
    <v-list v-if="link.length > 0">
      <v-list-tile>
        <v-list-tile-content>
          Latitud: {{location.coords.latitude}}
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile>
        <v-list-tile-content>
          Longitud: {{location.coords.longitude}}
        </v-list-tile-content>
      </v-list-tile>
      <v-list-tile>
        <v-list-tile-content>
          <a :href="link">Ves al google maps</a>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>
    </span>
</template>

<script>
export default {
  name: 'Geolocation',
  data () {
    return {
      disabled: false,
      buttonText: '',
      link: '',
      target: {},
      location: null
    }
  },
  methods: {
    appendLocation (location, verb) {
      verb = verb || 'updated'
      console.log(location)
      this.link = 'https://maps.google.com/maps?&z=15&q=' + location.coords.latitude + '+' + location.coords.longitude + '&ll=' + location.coords.latitude + '+' + location.coords.longitude
      this.location = location
    },
    getLocation () {
      navigator.geolocation.getCurrentPosition((location) => {
        this.appendLocation(location, 'fetched')
      })
    }
  },
  created () {
    if ('geolocation' in navigator) {
      this.buttonText = 'Demana la ubicació actual'
    } else {
      this.buttonText = 'El navegdor no soporta geolocalització'
    }
  }
}
</script>
