<template>
    <v-menu offset-y>
        <v-badge slot="activator" left overlap color="error" class="ml-3 mr-2">
            <span slot="badge" v-text=""></span>
            <v-btn icon color="white" :loading="loading" :disabled="loading">
                <v-icon color="primary">users</v-icon>
            </v-btn>
        </v-badge>
    </v-menu>

</template>


<script>
  export default {
    name: "UsersOnlineWidget",
    data () {
      return {
        loading: false
      }
    }
  }
</script>
