<template>
  <v-list dense>
    <template v-for="item in items">
      <v-layout
        v-if="item.heading"
        v-bind:class="{ 'primary lighten-4': isActive(item.url) }"
        :key="item.heading"
        row
        align-center
      >
        <v-flex xs6>
          <v-subheader v-if="item.heading" class="grey--text text--darken-4">
            {{ item.heading }}
          </v-subheader>
        </v-flex>
        <v-flex xs6 class="text-xs-center">
          <a href="#!" class="body-2 black--text">EDIT</a>
        </v-flex>
      </v-layout>
      <v-list-group
        v-else-if="item.children"
        v-model="item.model"
        :key="item.text"
        append-icon=""
      >
        <v-list-tile slot="activator"
        >
          <v-list-tile-action v-if="item.icon" @click="" :href="item.url">
            <v-icon color="primary lighten-1">{{ item.icon }}</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title class="grey--text text--darken-4">
              {{ item.text }}
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-list-tile
          v-for="(child, i) in item.children"
          :key="i"
          @click=""
          v-bind:class="{ 'active': isActive(child.url) }"
          :href="child.url"
        >
          <v-list-tile-action v-if="child.icon" @click="" :href="item.url">
            <v-icon color="primary lighten-1">{{ child.icon }}</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title class="grey--text text--darken-4">
              {{ child.text }}
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list-group>
      <v-list-tile v-else :key="item.text" @click="" :href="item.url"
                   v-bind:class="{ 'active': isActive(item.url) }"
      >
        <v-list-tile-action>
          <v-icon color="primary lighten-1">{{ item.icon }}</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title class="grey--text text--darken-4">
            {{ item.text }}
          </v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </template>
  </v-list>
</template>

<script>
export default {
  name: 'SidebarMenu',
  props: {
    items: {
      type: Array,
      required: true
    }
  },
  methods: {
    isActive (url) {
      return this.active === url
    }
  },
  computed: {
    active () {
      return window.location.pathname
    }
  }
}
</script>

<style scoped>
  .active {
    border-right: 5px solid var(--v-primary-base);
  }
</style>
