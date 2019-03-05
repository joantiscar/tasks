<template>
  <span>
  <v-btn flat icon v-if="$can('tasks.show', task)" @click="dialog = true">
    <v-icon color="success" title="Mira els detalls de la tasca">remove_red_eye</v-icon>
  </v-btn>
    <v-dialog v-model="dialog" @keydown.esc="dialog = false" max-width="1000">
      <v-toolbar dark class="secondary darken-2">
        <v-btn color="white" flat icon @click.native="dialog = false">
          <v-icon class="mr-1">close</v-icon>
        </v-btn>
        <span class="title">{{ task.name }}</span>
        <v-spacer></v-spacer>
      </v-toolbar>
      <v-card v-if="dialog === true">
        <v-card-text>
          <task-show-content :tags="tags" :task="task"/>
        </v-card-text>
      </v-card>
    </v-dialog>
    </span>
</template>
<script>
import TaskShowContent from './TaskShowContent'

export default {
  name: 'task-show-mobile',
  components: { TaskShowContent },
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
        this.$snackbar.showMessage('S\'ha editat correctament la tasca')
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
