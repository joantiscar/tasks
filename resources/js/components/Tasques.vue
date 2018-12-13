<template>
    <span>
  <v-dialog v-model="showDialog" @keydown.esc="showDialog = false">
        <v-toolbar color="primary" class="white--text">
            <v-btn color="white" flat icon @click.native="showDialog = false"><v-icon class="mr-1">close</v-icon></v-btn>

                Crear tasca
               <v-spacer></v-spacer> <v-btn color="white" flat @click.native="showDialog = false"><v-icon class="mr-1">exit_to_app</v-icon>Sortir</v-btn>
               <v-btn color="white" flat @click.native="showDialog = false"><v-icon class="mr-1">save</v-icon>Guardar</v-btn>
            </v-toolbar>
            <v-card>
                <v-card-text>
        <v-form>
            <v-text-field readonly v-model="taskBeingShown.name" label="Nom" hint="El nom de la tasca..."></v-text-field>
            <v-switch readonly v-model="taskBeingShown.completed" :label="taskBeingShown.completed ? 'Completada' : 'Pendent'"></v-switch>
            <v-text-field readonly label="User" v-model="taskBeingShown.user_name" item-text="name" item-value="id" clearable></v-text-field>
                <v-textarea readonly v-model="taskBeingShown.description" label="Descripcio" hint="Descripció"></v-textarea>
            <div class="text-xs-center">
            <v-btn color="grey" @click.native="showDialog = false"><v-icon class="mr-1">exit_to_app</v-icon>Sortir</v-btn>
                </div>
        </v-form>
                </v-card-text>
      </v-card>

  </v-dialog>

          <tasks-list :tasks="dataTasks" :users="dataUsers"></tasks-list>
          <task-create :users="users" @created="add"></task-create>

      <!--<v-data-iterator class="hidden-lg-and-up"-->
                               <!--:items="dataTasks"-->
                               <!--:search="search"-->
                               <!--no-results-text="No s'ha trobat cap registre coincident"-->
                               <!--no-data-text="No hi han dades disponibles"-->
                               <!--rows-per-page-text="Tasques per pàgina"-->
                               <!--:rows-per-page-items="[5,10,25,50,100,200,{'text':'Tots','value':-1}]"-->
                               <!--:loading="loading"-->
                               <!--:pagination.sync="pagination"-->
              <!--&gt;-->
                <!--<v-flex-->
                        <!--slot="item"-->
                        <!--slot-scope="{item:task}"-->
                        <!--xs12-->
                        <!--sm6-->
                        <!--md4-->
                <!--&gt;-->
                    <!--<v-card class="mb-1">-->
                        <!--<v-card-title v-text="task.name"></v-card-title>-->
                        <!--<v-list dense>-->
                            <!--<v-list-tile>-->
                              <!--<v-list-tile-content>Completed:</v-list-tile-content>-->
                              <!--<v-list-tile-content class="align-end">{{ task.completed }}</v-list-tile-content>-->
                            <!--</v-list-tile>-->
                            <!--<v-list-tile>-->
                              <!--<v-list-tile-content>User:</v-list-tile-content>-->
                              <!--<v-list-tile-content class="align-end">{{ task.user_id }}</v-list-tile-content>-->
                            <!--</v-list-tile>-->
                        <!--</v-list>-->
                    <!--</v-card>-->
                <!--</v-flex>-->
            <!--</v-data-iterator>-->

    </span>
</template>

<script>
import TaskCreate from './TaskCreate'
import TasksList from './TasksList'

export default{
  name: 'Tasques',
  components: {
    TasksList,
    TaskCreate
  },
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
      taskBeingCreated: {
        id: '',
        name: '',
        user_id: '',
        completed: false
      },
      taskBeingShown: '',
      taskBeingEdited: '',
      createDialog: false,
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
      loading: false,
      creating: false,
      editing: false,
      removing: null

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
    },
    uri: {
      type: String,
      required: true
    }
  },
  // watch: {
  //   // dataTasks (newDataTasks, oldDataTasks) {
  //   //     // PROBLEMA -> WATCH ARRAYS MALA COSA O OBJECTES
  //   //   console.log(this.dataTasks)
  //   // }
  //   // dataTasks: {
  //   //   handler: function (newDataTasks, oldDataTasks) {
  //   //     // PROBLEMA -> WATCH ARRAYS MALA COSA O OBJECTES
  //   //     console.log(this.dataTasks)
  //   //   },
  //   //   deep: true
  //   // }
  //
  // },
  methods: {
    add (task) {
      console.log(task);
      this.dataTasks.push(task)
    },
    showCreate () {
      this.createDialog = true
    },
    show (task) {
      console.log('Show Task' + task.id)
    },
    editTask ($task) {
      this.dataTasks.splice(this.dataTasks.indexOf($task), 1, $task)
    },
    createTask ($task) {
      this.dataTasks.splice(0, 0, $task)
    },

    // destroyWithPromises (task) {
    //     // ES6 async await
    //
    //     let result = this.$confirm().then(
    //     if (result) {
    //         console.log('ok')
    //     }
    //
    //     ).catch()

    showEdit (task) {
      this.editDialog = true
      this.taskBeingEdited = task
    },
    showShow (task) {
      this.showDialog = true
      this.taskBeingShown = task
    },

    complete (task) {
      this.taskBeingEdited = task
      this.edit()
    }
  },
  created () {
    console.log('Usuari logat:')
    console.log(window.laravel_user)
  }
}

</script>
