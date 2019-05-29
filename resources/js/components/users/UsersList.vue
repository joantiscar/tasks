<template>
    <v-data-table
            :items="users"
            :headers="headers"
            :loading="loading">
        <v-progress-linear v-slot:progress color="blue" indeterminate></v-progress-linear>

        <template slot="items" slot-scope="{item: user}">

            <tr>
                <td>{{ user.id}}</td>
                <td>{{ user.name}}</td>
                <td>{{user.mobile}}</td>
                <td>{{user.mobile_verified_at}}</td>
                <td>{{user.email}}</td>
                <td>{{user.email_verified_at}}</td>
                <td>
                    <v-menu>
                        <v-btn flat icon slot="activator">
                            <v-icon>
                                more_vert
                            </v-icon>
                        </v-btn>
                        <v-list>

                            <v-list-tile @click="verifyPhone(user)">
                                Confirmar telefon
                            </v-list-tile>
                            <v-list-tile @click="verifyMail(user)">
                                Confirmar Mail
                            </v-list-tile>

                        </v-list>
                    </v-menu>
                </td>
            </tr>

        </template>
    </v-data-table>
</template>

<script>
  export default {
    name: "UsersList",
    props: {
      users: {
        type: Array,
        required: true
      }
    },
    data() {
      return {
        headers: [
          {'text': 'id', 'value': 'id'},
          {'text': 'Nom', 'value': 'nom'},
          {'text': 'Telefon', 'value': 'phone'},
          {'text': 'Mobil Confirmat el: ', 'value': 'mobile_verified_at'},
          {'text': 'Email', 'value': 'email'},
          {'text': 'Email confirmat el: ', 'value': 'email_verified_at'},
          {'text': 'Accions', sortable: false}
        ],
        loading: false
      }
    },
    methods: {
      verifyPhone(user) {
        this.loading = true
        window.axios.post('api/v1/mobile/' + user.id + '/requestCode').then((response) => {
          this.$snackbar.showMessage("S'ha enviat correctament el SMS")
          this.loading = false

        }).catch((error) => {
          this.$snackbar.showError(error.message)
          this.loading = false

        })
      },
      verifyMail(user) {
        this.loading = true
        window.axios.post('api/v1/mobile/' + user.id + '/verifyMail').then((response) => {
          this.$snackbar.showMessage("S'ha enviat correctament el mail de confirmació")
          this.loading = false

        }).catch((error) => {
          console.log(error)
          this.$snackbar.showError(error.message)
          this.loading = false

        })
      }
    }
  }
</script>

<style scoped>

</style>
