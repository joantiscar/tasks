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
            <v-text-field v-model="taskBeingEdited.name" label="Nom" hint="El nom de la tasca..."></v-text-field>
            <v-switch v-model="taskBeingEdited.completed" :label="completed ? 'Completada' : 'Pendent'"></v-switch>
                <v-textarea v-model="taskBeingEdited.description" label="Descripcio" hint="Descripció"></v-textarea>
            <div class="text-xs-center">
            <v-btn color="grey" @click.native="editDialog = false"><v-icon class="mr-1">exit_to_app</v-icon>Sortir</v-btn>
               <v-btn color="success" @click.native="edit()"><v-icon class="mr-1">save</v-icon>Guardar</v-btn>
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
            <v-text-field v-model="taskBeingShown.showName" label="Nom" hint="El nom de la tasca..."></v-text-field>
            <v-text-field label="User" v-model="taskBeingShown.user"></v-text-field>
            <v-switch v-model="taskBeingShown.showCompleted" :label="showCompleted ? 'Completada' : 'Pendent'"></v-switch>
                <v-textarea v-model="taskBeingShown.showDescription" label="Descripcio" hint="Descripció"></v-textarea>
            <div class="text-xs-center">
            <v-btn color="grey" @click.native="showDialog = false"><v-icon class="mr-1">exit_to_app</v-icon>Sortir</v-btn>
                </div>
        </v-form>
              </v-card-text>
      </v-card>

  </v-dialog>
  <v-dialog v-model="createDialog" @keydown.esc="createDialog = false">
            <v-toolbar color="primary" class="white--text">
            <v-btn color="white" flat icon @click.native="createDialog = false"><v-icon class="mr-1">close</v-icon></v-btn>

                Crear tasca
               <v-spacer></v-spacer> <v-btn color="white" flat @click.native="createDialog = false"><v-icon class="mr-1">exit_to_app</v-icon>Sortir</v-btn>
               <v-btn color="white" flat @click.native="createDialog = false"><v-icon class="mr-1">save</v-icon>Guardar</v-btn>
            </v-toolbar>
            <v-card>
                <v-card-text>
        <v-form>
            <v-text-field v-model="taskBeingCreated.name" label="Nom" hint="El nom de la tasca..."></v-text-field>
            <v-switch v-model="taskBeingCreated.completed" :label="completed ? 'Completada' : 'Pendent'"></v-switch>
                <v-textarea v-model="taskBeingCreated.description" label="Descripcio" hint="Descripció"></v-textarea>
            <div class="text-xs-center">
            <v-btn color="grey" @click.native="createDialog = false"><v-icon class="mr-1">exit_to_app</v-icon>Sortir</v-btn>
               <v-btn color="success" @click.native="create()"><v-icon class="mr-1">save</v-icon>Guardar</v-btn>
                </div>
        </v-form>
                </v-card-text>
      </v-card>

  </v-dialog>
  <v-snackbar :timeout="snackbarTimeout" :color="snackbarColor" v-model="snackbar">
      {{ snackbarMessage }}
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
                        <td><span :title="task.created_at_formatted">{{task.created_at_human}}</span></td>
                        <td><span :title="task.updated_at_formatted">{{task.updated_at_human}}</span></td>
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
      snackbarMessage: 'Default message',
      snackbarTimeout: 3000,
      snackbarColor: 'success',
      snackbar: false,
      name: '',
      description: '',
      completed: false,
      showName: '',
      showDescription: '',
      showCompleted: false,
      showUserId: '',
      dataTasks: this.tasks,
      taskBeingRemoved: '',
      taskBeingCreated: {
        id: '',
        name: '',
        user: '',
        completed: ''
      },
      taskBeingShown: '',
      taskBeingEdited: '',
      createDialog: false,
      destroyDialog: false,
      editDialog: false,
      showDialog: false,

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
          text: 'Creat', value: 'created_at_timestamp'
        },
        {
          text: 'Modificat', value: 'updated_at_timestamp'
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
      this.creating = true
      window.axios.post('/api/v1/user/tasks', this.taskBeingCreated).then(() => {
        // this.refresh() // Problema -> rendiment
        this.createTask(this.taskBeingCreated)
        this.showMessage("S'ha editat correctament la tasca")
      }).catch(error => {
        this.showError(error)
        this.creating = false
        this.editDialog = false
      }).finally(() => {
        this.creating = false
        this.editDialog = false
      })
    },
    showCreate (task) {
      this.createDialog = true
      this.taskBeingCreated = task
    },
    show (task) {
      console.log('Show Task' + task.id)
    },
    removeTask ($task) {
      this.dataTasks.splice(this.dataTasks.indexOf($task), 1)
    },
    editTask ($task) {
      this.dataTasks.splice(this.dataTasks.indexOf($task), 1, $task)
    },
    createTask ($task) {
      this.dataTasks.splice(0, 0, $task)
    },
    showError (error) {
      this.snackbarMessage = error
      this.snackbar = true
      this.snackbarColor = 'error'
    },
    showMessage (message) {
      this.snackbarMessage = message
      this.snackbar = true
      this.snackbarColor = 'success'
    },

    destroy () {
      this.removing = true
      window.axios.delete('/api/v1/user/tasks/' + this.taskBeingRemoved.id).then(() => {
        // this.refresh() // Problema -> rendiment
        this.removeTask(this.taskBeingRemoved)
        this.showMessage("S'ha esborrat correctament la tasca")
      }).catch(error => {
        this.showError(error)
        this.removing = false
        this.destroyDialog = false
      }).finally(() => {
        this.removing = false
        this.destroyDialog = false
      })
    },
    edit () {
      this.editing = true
      window.axios.put('/api/v1/user/tasks/' + this.taskBeingEdited.id, this.taskBeingEdited).then(() => {
        // this.refresh() // Problema -> rendiment
        this.editTask(this.taskBeingEdited)
        this.showMessage("S'ha editat correctament la tasca")
      }).catch(error => {
        this.showError(error)
        this.editing = false
        this.editDialog = false
      }).finally(() => {
        this.editing = false
        this.editDialog = false
      })
    },
    showEdit (task) {
      this.editDialog = true
      this.taskBeingEdited = task
    },
    showShow (task) {
      this.showDialog = true
      this.taskBeingShown = task
    },
    showDestroy (task) {
      this.destroyDialog = true
      this.taskBeingRemoved = task
    }
  }
}

</script>
