<template>
  <span>
  <v-dialog v-model="dialog" @keydown.esc="dialog = false">
    <v-toolbar color="primary" class="white--text">
      <v-btn color="secondary" flat icon @click.native="dialog = false">
        <v-icon class="mr-1">close</v-icon>
      </v-btn>

      Crear tasca
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
        <task-form :tags="tags" :users="users" @close="dialog=false" @saved="created"></task-form>
      </v-card-text>
    </v-card>
  </v-dialog>
     <v-btn
       color="accent"
       class="white--text"
       @click="dialog = true"
       v-if="$can('user.tasks.store')"
     >
            Crea la primera tasca!

        </v-btn>
    </span>
</template>
<script>
import TaskForm from './TaskForm'

export default {
  name: 'EmptyTasksCreateButton',
  components: { TaskForm },
  data () {
    return {
      dialog: false,
      dataUsers: {}
    }
  },
  props: {
    users: {
      type: Array,
      required: true
    },
    tags: {
      type: Array,
      required: true
    },
    uri: {
      type: String,
      default: '/api/v1/tasks'
    }

  },
  methods: {
    created (task) {
      window.axios.post(this.uri, task).then((response) => {
        this.$snackbar.showMessage("S'ha editat correctament la tasca")
        this.$emit('created', response.data)
      }).catch((error) => {
        this.$snackbar.showError(error.message)
      }).finally(() => {
        this.dialog = false
      })
    }
  }
}
</script>
