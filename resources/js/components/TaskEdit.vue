<template>
  <span>
  <v-btn v-if="$can('tasks.update', task)" color="success" icon flat title="Modificar la tasca" @click="dialog  = true">
    <v-icon>border_color</v-icon>
  </v-btn>
  <v-dialog v-model="dialog" @keydown.esc="dialog = false">
    <v-toolbar color="primary" class="white--text">
      <v-btn color="secondary" flat icon @click.native="dialog = false">
        <v-icon class="mr-1">close</v-icon>
      </v-btn>

      Editar tasca
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
    <v-card>
      <v-card-text>
        <task-form :task="task" :users="users" :tags="tags" @saved="edit"></task-form>
      </v-card-text>
    </v-card>
  </v-dialog>
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
