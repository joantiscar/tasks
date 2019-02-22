<template>
  <tasks-list :tags="tags" :tasks="dataTasks" :users="dataUsers"></tasks-list>
</template>

<script>
import TaskCreate from './TaskCreate'
import TasksList from './TasksList'
import EmptyTasksCreateButton from './EmptyTasksCreateButton'

export default {
  name: 'Tasques',
  components: {
    EmptyTasksCreateButton,
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
      //                                                                                                                                                                                                                                                                                                                                     Fet per lo de La Sénia
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
    tags: {
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
