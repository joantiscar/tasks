<template>
  <span>
     <v-btn v-if="$can('tasks.update', task)" color="success" icon flat title="Modificar la tasca" class="hidden-md-and-down" @click="dialog  = true">
    <v-icon>border_color</v-icon>
  </v-btn>
  <v-list-tile class="hidden-lg-and-up" v-if="$can('tasks.update', task)" @click="dialog = true">
    <v-list-tile-title>Editar</v-list-tile-title>
    <v-list-tile-action>
    <v-icon color="success" title="Modificar la tasca">border_color</v-icon>
    </v-list-tile-action>
    <v-dialog v-model="dialog" @keydown.esc="dialog = false">
      <v-toolbar color="primary" class="white--text">
        <span class="hidden-md-and-down">Editar tasca</span>
        <v-spacer></v-spacer>
        <v-btn color="secondary" flat @click.native="dialog = false">
          <v-icon class="mr-1">exit_to_app</v-icon>
          Sortir
        </v-btn>
        <v-btn color="secondary" flat @click.native="dialog = false">
          <v-icon class="mr-1">save</v-icon>
          Guardar
        </v-btn>
      </v-toolbar>
      <v-card v-if="dialog === true">
        <v-card-text>
          <task-form :task="task" :users="users" :user="task.user" :tags="tags" @saved="edit" @close="dialog = false"></task-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-list-tile>
    </span>
</template>
<script>
import TaskForm from './TaskForm'
export default {
  name: 'task-edit',
  components: { TaskForm },
  data () {
    return {
      loading: false,
      dataUsers: this.users,
      dialog: false
    }
  },
  props: {
    users: {
      type: Array,
      required: true
    },
    task: {
      type: Object,
      required: true
    },
    uri: {
      type: String,
      default: '/api/v1/tasks'
    },
    tags: {
      type: Array,
      required: true
    }
  },
  watch: {
    task (task) {
      this.updateUser(task)
    }
  },
  methods: {
    updateUser (task) {
      this.user = this.users.find((user) => {
        return parseInt(user.id) === parseInt(task.user_id)
      })
    },
    edit (task) {
      this.loading = true
      window.axios.put(this.uri + '/' + this.task.id, task).then((response) => {
        // this.refresh() // Problema -> rendiment
        this.$snackbar.showMessage("S'ha editat correctament la tasca")
        this.$emit('edited', response.data)
      }).catch((error) => {
        this.$snackbar.showError(error.message)
        this.loading = false
        this.dialog = false
      }).finally(() => {
        this.loading = false
        this.dialog = false
      })
    }
  },
  created () {
    this.updateUser(this.task)
  }
}

</script>
