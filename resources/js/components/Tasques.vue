<template>
    <span>
  <v-dialog v-model="destroyDialog">
      <v-card>
        <v-card-title class="headline">Estas segur?</v-card-title>
        <v-card-text>Esta accio es irreversible.</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" flat @click.native="destroyDialog = false">Disagree</v-btn>
          <v-btn color="green darken-1" flat @click.native="destroy()">Agree</v-btn>
        </v-card-actions>
      </v-card>

  </v-dialog>
        <v-dialog v-model="editDialog" @keydown.esc="editDialog = false">
            <v-toolbar color="primary" class="white--text">
            <v-btn color="white" flat icon @click.native="editDialog = false"><v-icon class="mr-1">close</v-icon></v-btn>

                Editar tasca
               <v-spacer></v-spacer> <v-btn color="white" flat @click.native="editDialog = false"><v-icon class="mr-1">exit_to_app</v-icon>Sortir</v-btn>
               <v-btn color="white" flat @click.native="editDialog = false"><v-icon class="mr-1">save</v-icon>Guardar</v-btn>
            </v-toolbar>
            <v-card>
                <v-card-text>
        <v-form>
            <v-text-field v-model="name" label="Nom" hint="El nom de la tasca..."></v-text-field>
            <v-switch v-model="completed" :label="completed ? 'Completada' : 'Pendent'"></v-switch>
                <v-textarea v-model="description" label="Descripcio" hint="Descripció"></v-textarea>
            <div class="text-xs-center">
            <v-btn color="grey" @click.native="editDialog = false"><v-icon class="mr-1">exit_to_app</v-icon>Sortir</v-btn>
               <v-btn color="success" @click.native="editDialog = false"><v-icon class="mr-1">save</v-icon>Guardar</v-btn>
                </div>
        </v-form>

                    </v-card-text>
      </v-card>

  </v-dialog>
        <v-dialog v-model="showDialog" @keydown.esc="showDialog = false">
            <v-toolbar color="primary" class="white--text">
            <v-btn color="white" flat icon @click.native="showDialog = false"><v-icon class="mr-1">close</v-icon></v-btn>

                Tasca en detall
               <v-spacer></v-spacer> <v-btn color="white" flat @click.native="showDialog = false"><v-icon class="mr-1">exit_to_app</v-icon>Sortir</v-btn>
               <v-btn color="white" flat @click.native="showDialog = false"><v-icon class="mr-1">save</v-icon>Guardar</v-btn>
            </v-toolbar>
      <v-card>
          <v-card-text>
        <v-form>
            <v-text-field v-model="showName" label="Nom" hint="El nom de la tasca..."></v-text-field>
            <v-autocomplete label="User" :items="dataUsers" v-model="user" item-text="name" clearable></v-autocomplete>
            <v-switch v-model="showCompleted" :label="showCompleted ? 'Completada' : 'Pendent'"></v-switch>
                <v-textarea v-model="showDescription" label="Descripcio" hint="Descripció"></v-textarea>
            <div class="text-xs-center">
            <v-btn color="grey" @click.native="showDialog = false"><v-icon class="mr-1">exit_to_app</v-icon>Sortir</v-btn>
               <v-btn color="success" @click.native="showDialog = false"><v-icon class="mr-1">save</v-icon>Guardar</v-btn>
                </div>
        </v-form>
              </v-card-text>
      </v-card>

  </v-dialog>
  <v-dialog v-model="createDialog" fullscreen>
      <v-toolbar color="primary" class="white--text">
            <v-btn color="white" flat icon @click.native="createDialog = false"><v-icon class="mr-1">close</v-icon></v-btn>

                Tasca en detall
               <v-spacer></v-spacer> <v-btn color="white" flat @click.native="createDialog = false"><v-icon class="mr-1">exit_to_app</v-icon>Sortir</v-btn>
               <v-btn color="white" flat @click.native="createDialog = false"><v-icon class="mr-1">save</v-icon>Guardar</v-btn>
            </v-toolbar>
      <v-card>
        <v-card-title class="headline">Estas segur?</v-card-title>
        <v-card-text>Esta accio es irreversible.</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" flat @click.native="createDialog = false">Disagree</v-btn>
          <v-btn color="green darken-1" flat @click.native="create(task)">Agree</v-btn>
        </v-card-actions>
      </v-card>
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
      <v-toolbar-title class="white--text">Tasques</v-toolbar-title>
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
            <v-layout row wrap>
                <v-flex lg3 class="mr-2">
                <v-select label="Filtres" :items="filters" v-model="filter"></v-select>
                </v-flex>
                <v-flex lg3 class="mr-2">
                    <v-select label="User" :items="users" v-model="user" clearable></v-select>
                </v-flex>
                <v-flex lg5>
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
                    :items="dataTasks"
                    :search="search"
                    no-results-text="No s'ha trobat cap registre coincident"
                    :loading="loading"
                    no-data-text=""
                    rows-per-page-text="Tasques per pàgina"
                    :rows-per-page-items="[5,10,25,50,100,200,{'text':'Tots','value':-1}]"
                    :pagination.sync="pagination"
                    class="hidden-md-and-down">

                <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                <template slot="items" slot-scope="{item: task}">
                    <tr>
                        <td>{{ task.id}}</td>
                        <td>{{ task.name}}</td>
                        <td>{{ task.user}}</td>
                        <td>{{ task.completed}}</td>
                        <td>{{ task.created_at}}</td>
                        <td>{{ task.updated_at}}</td>
                        <td>
                        <v-btn color="success" icon flat title="Modificar la tasca"
                               @click="showEdit(task)">
                            <v-icon>border_color</v-icon>
                        </v-btn>
                            <v-btn color="success" icon flat title="Modificar la tasca"
                                   @click="showShow(task)">
                            <v-icon>remove_red_eye</v-icon>
                        </v-btn>
                        <v-btn color="error" flat icon title="Eliminar la tasca"
                               @click="showDestroy(task)">
                            <v-icon>delete</v-icon>
                        </v-btn>
                        <v-btn color="primary" icon flat title="Mostrar snackbar"
                               @click="snackbar=true">
                            <v-icon>info</v-icon>
                        </v-btn>
                        </td>
                    </tr>

                </template>
            </v-data-table>
              <v-data-iterator class="hidden-lg-and-up"
                               :items="dataTasks"
                               :search="search"
                               no-results-text="No s'ha trobat cap registre coincident"
                               no-data-text="No hi han dades disponibles"
                               rows-per-page-text="Tasques per pàgina"
                               :rows-per-page-items="[5,10,25,50,100,200,{'text':'Tots','value':-1}]"
                               :loading="loading"
                               :pagination.sync="pagination"
              >
                <v-flex
                        slot="item"
                        slot-scope="{item:task}"
                        xs12
                        sm6
                        md4
                >
                    <v-card class="mb-1">
                        <v-card-title v-text="task.name"></v-card-title>
                        <v-list dense>
                            <v-list-tile>
                              <v-list-tile-content>Completed:</v-list-tile-content>
                              <v-list-tile-content class="align-end">{{ task.completed }}</v-list-tile-content>
                            </v-list-tile>
                            <v-list-tile>
                              <v-list-tile-content>User:</v-list-tile-content>
                              <v-list-tile-content class="align-end">{{ task.user_id }}</v-list-tile-content>
                            </v-list-tile>
                        </v-list>
                    </v-card>
                </v-flex>
            </v-data-iterator>
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
  name: 'Tasques',
  data () {
    return {
      name: '',
      description: '',
      completed: false,
      showName: '',
      showDescription: '',
      showCompleted: false,
      showUserId: '',
      dataTasks: this.tasks,
      taskBeingRemoved: '',
      createDialog: false,
      destroyDialog: false,
      editDialog: false,
      showDialog: false,
      snackbar: true,
      user: 'Astio',
      filter: 'Totes',
      dataUsers: this.users,
      filters: [
        'Totes',
        'Completades',
        'Pendents'
      ],
      search: '',
      loading: false,
      creating: false,
      editing: false,
      removing: false,
      headers: [
        {
          text: 'id', value: 'id'
        },
        {
          text: 'Nom', value: 'name'
        },
        {
          text: 'Usuari', value: 'user'
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
    tasks: {
      type: Array,
      required: true
    },
    users: {
      type: Array,
      required: true
    }
  },
  methods: {
    refresh () {
      this.loading = true
      // todo -> axios
      window.axios.get('/api/v1/user/tasks').then(response => {
        console.log(response)
        this.dataTasks = response.data
      }).catch(error => {
        console.log(error)
        this.loading = false
      }).finally(
        this.loading = false
      )
      // setTimeout(() => { this.loading = false }, 5000)
    },
    opcio1 () {
      console.log('Opcio1')
    },
    opcio2 () {
      console.log('Opcio2')
    },
    create (task) {
      console.log('create' + task.id)
    },
    showCreate (task) {
      this.createDialog = true
    },
    edit (task) {
      console.log('Update Task' + task.id)
    },
    show (task) {
      console.log('Show Task' + task.id)
    },
    removeTask ($task) {
      this.dataTasks.splice(this.dataTasks.indexOf($task), 1)
    },
    destroy () {
      this.removing = true
      window.axios.delete('/api/v1/user/tasks/' + this.taskBeingRemoved.id).then(() => {
        // this.refresh() // Problema -> rendiment
        this.removeTask(this.taskBeingRemoved)
      }).catch(error => {
        console.log(error)
        this.removing = false
        this.destroyDialog = false
      }).finally(() => {
        this.removing = false
        this.destroyDialog = false
      })
    },
    showEdit (task) {
      this.editDialog = true
    },
    showShow (task) {
      this.showDialog = true
    },
    showDestroy (task) {
      this.destroyDialog = true
      this.taskBeingRemoved = task
    },
    showCreateDialog () {
      console.log('TODO SHOW DIALOG TO CREATE TASK')
    }
  }
}

</script>
