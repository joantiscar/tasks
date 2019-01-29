<template>
  <v-menu offset-y>
    <v-list two-line>
      <v-list-tile avatar>
        <v-list-tile-avatar>
          <v-icon>notifications</v-icon>
        </v-list-tile-avatar>
        <v-list-tile-content>
          <v-list-tile-title>TODO</v-list-tile-title>
          <v-list-tile-sub-title>todo</v-list-tile-sub-title>
        </v-list-tile-content>

      </v-list-tile>
      <v-list-tile avatar>
        <v-list-tile-avatar>
          <v-icon>notifications</v-icon>
        </v-list-tile-avatar>
        <v-list-tile-content>
          <v-list-tile-title>TODO</v-list-tile-title>
          <v-list-tile-sub-title>todo</v-list-tile-sub-title>
        </v-list-tile-content>

      </v-list-tile>
      <v-list-tile avatar>
        <v-list-tile-avatar>
          <v-icon>notifications</v-icon>
        </v-list-tile-avatar>
        <v-list-tile-content>
          <v-list-tile-title>TODO</v-list-tile-title>
          <v-list-tile-sub-title>todo</v-list-tile-sub-title>
        </v-list-tile-content>

      </v-list-tile>
    </v-list>
    <v-btn flat icon slot="activator">
      <v-badge right color="accent">
        <span slot="badge">6</span>
        <v-icon>notifications</v-icon>
      </v-badge>
    </v-btn>
  </v-menu>
</template>

<script>
export default {
  name: 'NotificationsWidget',
  data () {
    return {}
  }
}
</script>
