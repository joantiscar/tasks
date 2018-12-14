<template>
  <span>
  <v-btn v-if="$can('tasks.update', task)" color="success" icon flat title="Modificar la tasca" @click="dialog  = true">
    <v-icon>border_color</v-icon>
  </v-btn>
  <v-dialog v-model="dialog" @keydown.esc="dialog = false">
    <v-toolbar color="primary" class="white--text">
      <v-btn color="white" flat icon @click.native="dialog = false">
        <v-icon class="mr-1">close</v-icon>
      </v-btn>

      Editar tasca
      <v-spacer></v-spacer>
      <v-btn color="white" flat @click.native="dialog = false">
        <v-icon class="mr-1">exit_to_app</v-icon>
        Sortir
      </v-btn>
      <v-btn color="white" flat @click.native="dialog = false">
        <v-icon class="mr-1">save</v-icon>
        Guardar
      </v-btn>
    </v-toolbar>
    <v-card>
      <v-card-text>
        <v-form>
          <v-text-field v-model="editingTask.name" label="Nom" hint="El nom de la tasca..."></v-text-field>
          <v-switch v-model="editingTask.completed"
                    :label="editingTask.completed ? 'Completada' : 'Pendent'"></v-switch>
              <user-select :users="users" :user="editingTask.user" label="User" v-model="editingTask.user"></user-select>

          <v-textarea v-model="editingTask.description" label="Descripcio" hint="Descripció"></v-textarea>
          <div class="text-xs-center">
            <v-btn color="grey" @click.native="dialog = false">
              <v-icon class="mr-1">exit_to_app</v-icon>
              Sortir
            </v-btn>
            <v-btn color="success" @click.native="edit" :disabled="loading" :loading="loading">
              <v-icon class="mr-1">save</v-icon>
              Guardar
            </v-btn>
          </div>
        </v-form>
      </v-card-text>
    </v-card>
  </v-dialog>
    </span>
</template>
<script>
export default {
  name: 'task-edit',
  data () {
    return {
      loading: false,
      dataUsers: this.users,
      editingTask: {
        id: this.task.id,
        name: this.task.name,
        description: this.task.description,
        user_id: this.task.user_id,
        user: this.task.user
      },
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
    edit () {
      this.loading = true
      window.axios.put(this.uri + '/' + this.task.id, this.editingTask).then((response) => {
        // this.refresh() // Problema -> rendiment
        this.$snackbar.showMessage("S'ha editat correctament la tasca")
        this.$emit('edited', response.data)
      }).catch((error) => {
        this.$snackbar.showError(error)
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
