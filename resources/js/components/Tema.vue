<template>
  <v-card>
    <v-card-title>Tema</v-card-title>
    <v-layout row>
        <v-list subheader>
          <v-list-tile avatar>
            <v-list-tile-avatar>
              <swatches v-model="colorPrincipal"></swatches>
            </v-list-tile-avatar>
            <v-list-tile-content>
              <v-list-tile-title>
                Color principal
              </v-list-tile-title>
            </v-list-tile-content>
            <v-list-tile-action>
              <v-btn @click="principalDefault">Default</v-btn>
            </v-list-tile-action>
          </v-list-tile>
            <v-list-tile avatar>
            <v-list-tile-avatar>
              <swatches v-model="colorSecundari"></swatches>
            </v-list-tile-avatar>
            <v-list-tile-content>
              <v-list-tile-title>
                Color secundari
              </v-list-tile-title>
            </v-list-tile-content>
            <v-list-tile-action>
              <v-btn @click="secundariDefault">Default</v-btn>
            </v-list-tile-action>
            </v-list-tile>
        </v-list>
    </v-layout>
  </v-card>
</template>

<script>
import Swatches from 'vue-swatches'
// Import the styles too, globally
import 'vue-swatches/dist/vue-swatches.min.css'

export default {
  name: 'Tema',
  components: { Swatches },

  data () {
    return {
      colorPrincipal: window.localStorage.getItem('PRIMARY_COLOR_KEY'),
      colorSecundari: window.localStorage.getItem('SECONDARY_COLOR_KEY')
    }
  },
  watch: {
    colorPrincipal () {
      window.localStorage.setItem('PRIMARY_COLOR_KEY', this.colorPrincipal)
      this.$vuetify.theme.primary = this.colorPrincipal
    },
    colorSecundari () {
      window.localStorage.setItem('SECONDARY_COLOR_KEY', this.colorSecundari)
      this.$vuetify.theme.secondary = this.colorSecundari

    }
  },
  methods: {
    principalDefault () {
      window.localStorage.removeItem('PRIMARY_COLOR_KEY')
    },
    secundariDefault () {
      window.localStorage.removeItem('SECONDARY_COLOR_KEY')
    }
  }
}
</script>

<style scoped>

</style>
