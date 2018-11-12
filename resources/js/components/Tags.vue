<template>
    <span>
  <v-dialog v-model="destroyDialog">
      <v-card>
        <v-card-title class="headline">Estas segur?</v-card-title>
        <v-card-text>Esta accio es irreversible.</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" flat @click.native="dialog = false">Disagree</v-btn>
          <v-btn color="green darken-1" flat @click.native="destroy(tags)">Agree</v-btn>
        </v-card-actions>
      </v-card>

  </v-dialog>
  <v-dialog v-model="createDialog" fullscreen>
      <v-card>TODO CREATE DIALOG
      <v-btn flat @click.native="createDialog=false">Tancar</v-btn></v-card>
  </v-dialog>
  <v-snackbar :timeout="3000" color="success" v-model="snackbar">
      Això és un snackbar
      <v-btn dark flat @click.native="snackbar=false">Tancar</v-btn>
  </v-snackbar>
  <v-toolbar color="blue darken-1">
    <v-menu left>

      <v-btn slot="activator" icon dark>
            <v-icon>settings</v-icon>
        </v-btn>
        <v-list>
            <v-list-tile @click="opcio1">
                <v-list-tile-title>Opció 1</v-list-tile-title>
            </v-list-tile>
            <v-list-tile @click="opcio2">
                <v-list-tile-title>Opció 2</v-list-tile-title>
            </v-list-tile>
             <v-list-tile href="google.com">
                <v-list-tile-title>Google</v-list-tile-title>
            </v-list-tile>
        </v-list>
        </v-menu>
      <v-toolbar-title class="white--text">Tags</v-toolbar-title>
      <v-spacer></v-spacer>

        <v-btn icon dark class="white--text">
            <v-icon>settings</v-icon>
        </v-btn>
        <v-btn icon dark class="white--text" @click="refresh" :loading="loading" :disabled="loading">
            <v-icon>refresh</v-icon>
        </v-btn>

        </v-toolbar>
        <v-card>
        <v-card-title>
            <v-layout>
                <v-flex xs3 class="pr-2">
                <v-select lavel="Filtres" :items="filters" v-model="filter"></v-select>
                </v-flex>
                <v-flex xs3 class="pr-2">
                    <v-select lavel="User" :items="users" v-model="user" clearable></v-select>
                </v-flex>
                <v-flex xs5>
                    <v-text-field
                            v-model="search"
                            append-icon="search"
                            label="Búsqueda"
                            single-line
                            hide-details
                    ></v-text-field>
                </v-flex>
            </v-layout>
            </v-card-title>
            <v-data-table
                    :headers="headers"
                    :items="dataTags"
                    :search="search"
                    no-results-text="No s'ha trobat cap registre coincident"
                    :loading="loading"
                    no-data-text=""
                    rows-per-page-text="Tags per pàgina"
                    :rows-per-page-items="[5,10,25,50,100,200,{'text':'Tots','value':-1}]"
                    :pagination.sync="pagination">
                <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                <template slot="items" slot-scope="{item: tags}">
                    <tr>
                        <td>{{ tags.id}}</td>
                        <td>{{ tags.name}}</td>
                        <td>{{ tags.completed}}</td>
                        <td>{{ tags.created_at}}</td>
                        <td>{{ tags.updated_at}}</td>
                        <td>
                        <v-btn color="success" flat title="Modificar la tasca"
                               @click="update(tags)">
                            <v-icon>delete</v-icon>
                        </v-btn>
                        <v-btn color="error" flat title="Eliminar la tasca"
                               @click="showDestroy(tags)">
                            <v-icon>delete</v-icon>
                        </v-btn>
                        <v-btn color="error" flat title="Mostrar snackbar"
                               @click="snackbar=true">
                            <v-icon>home</v-icon>
                        </v-btn>
                        </td>
                    </tr>

                </template>
            </v-data-table>
        </v-card>
        <v-btn
            fab
            bottom
            right
            color="pink"
            fixed
            class="white--text"
            @click="showCreate"
        >
            <v-icon>add</v-icon>

        </v-btn>
    </span>
</template>

<script>
export default{
  name: 'Tags',
  data () {
    return {
      dataTags: this.tags,
      createDialog: false,
      destroyDialog: false,
      snackbar: true,
      user: 'Astio',
      users: [
        'Astio',
        'Emilio',
        'Jordi Varas'
      ],
      filter: 'Totes',
      filters: [
        'Totes',
        'Completades',
        'Pendents'
      ],
      search: '',
      loading: false,
      headers: [
        {
          text: 'id', value: 'id'
        },
        {
          text: 'Nom', value: 'name'
        },
        {
          text: 'Completat', value: 'completed'
        },
        {
          text: 'Creat', value: 'created_at'
        },
        {
          text: 'Modificat', value: 'updated_at'
        },
        {
          text: 'Actions', sortable: false
        }
      ],
      pagination: {
        rowsPerPage: 25
      }
    }
  },
  props: {
    tags: {
      type: Array,
      required: false
    }
  },
  methods: {
    refresh () {
      this.loading = true
      // todo -> axios
      window.axios.get('/api/v1/tags').then(response => {
        console.log(response)
        this.dataTags = response.data
        this.loading = false
      }).catch(error => {
        console.log(error)
      })
      // setTimeout(() => { this.loading = false }, 5000)
    },
    opcio1 () {
      console.log('Opcio1')
    },
    opcio2 () {
      console.log('Opcio2')
    },
    create (tags) {
      console.log('create' + tags.id)
    },
    showCreate (tags) {
      this.createDialog = true
    },
    update (tags) {
      console.log('Destroy Tag' + tags.id)
    },
    show (tags) {
      console.log('Destroy Tag' + tags.id)
    },
    destroy (tags) {
      console.log('Destroy Tag' + tags.id)
    },
    showDestroy (tags) {
      this.destroyDialog = true
    },
    showCreateDialog () {
      console.log('TODO SHOW DIALOG TO CREATE TAG')
    }
  }
}

</script>
