<template>
  <div>
    <template v-if="connection">
    <v-list>
    <v-list-tile>
      <v-list-tile-content>
        Tipus de xarxa: {{ connection.effectiveType}}
      </v-list-tile-content>
    </v-list-tile>
      <v-divider></v-divider>
        <v-list-tile>
      <v-list-tile-content>
        Rtt: {{ connection.rtt}}
      </v-list-tile-content>
        </v-list-tile>
      <v-divider></v-divider>
        <v-list-tile>
      <v-list-tile-content>
        Velocitat actual: {{ connection.downlink}}
      </v-list-tile-content>
        </v-list-tile>
    </v-list>
    </template>
    <template v-else>
      <span>La funcio network no esta disponible al teu navegador</span>
    </template>
  </div>
</template>

<script>
export default {
  name: 'Network',
  computed: {
    connection () {
      if (navigator.connection) {
        return navigator.connection
      } else {
        return null
      }
    }
  }
}
</script>
