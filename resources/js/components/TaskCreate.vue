<template>
  <span>
  <v-dialog v-model="dialog" @keydown.esc="dialog = false">
    <v-toolbar color="primary" class="white--text">
      <v-btn color="white" flat icon @click.native="dialog = false">
        <v-icon class="mr-1">close</v-icon>
      </v-btn>

      Crear tasca
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
        <task-form :users="users" @close="dialog=false" @created="$emit('created',)"></task-form>
      </v-card-text>
    </v-card>
  </v-dialog>
     <v-btn
       fab
       bottom
       right
       color="pink"
       fixed
       class="white--text"
       @click="dialog = true"
       v-if="$can('user.tasks.store')"
     >
            <v-icon>add</v-icon>

        </v-btn>
    </span>
</template>
<script>
import TaskForm from './TaskForm'

export default {
  name: 'TaskCreate',
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
    }

  }
}
</script>
