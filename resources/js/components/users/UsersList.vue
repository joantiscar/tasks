<template>
    <v-data-table
            :items="users"
            :headers="headers">
        <template slot="items" slot-scope="{item: user}">
            <tr>
                <td>{{ user.id}}</td>
                <td>{{ user.name}}</td>
                <td>{{user.mobile}}</td>
                <td>{{user.mobile_verified_at}}</td>
                <td>{{user.email}}</td>
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
                                Confirmar telefon
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
          {'text': 'Accions', sortable: false}
        ]
      }
    },
    methods: {
      verifyPhone(user) {
        window.axios.post('api/v1/mobile/' + user.id + '/requestCode').then((response) => {
          this.$snackbar.showMessage("S'ha creat correctament la tasca")
        }).catch((error) => {
        })
      },
      verifyMail(user) {
        window.axios.post('api/v1/mobile/' + user.id + '/verifyMail').then((response) => {
          this.$snackbar.showMessage("S'ha creat correctament la tasca")
        }).catch((error) => {
        })
      }
    }
  }
</script>

<style scoped>

</style>
