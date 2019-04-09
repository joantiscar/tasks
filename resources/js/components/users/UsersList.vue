<template>
    <v-data-table
    :items="users"
    :headers="headers">
        <template slot="items" slot-scope="{item: user}">
            <tr>
                <td>{{ user.id}}</td>
                <td>{{ user.name}}</td>
                <td>{{user.mobile}}</td>
                <td>{{user.email}}</td>

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
    data () {
      return {
        headers: [
          {'text': 'id', 'value': 'id'},
          {'text': 'Nom', 'value': 'nom'},
          {'text': 'Telefon', 'value': 'phone'},
          {'text': 'Email', 'value': 'email'}
        ]
      }
    }
  }
</script>

<style scoped>

</style>
