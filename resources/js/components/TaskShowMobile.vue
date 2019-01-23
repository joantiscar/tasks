<template>
  <v-list-tile class="hidden-lg-and-up" v-if="$can('tasks.show', task)" @click="dialog = true">
  <v-list-tile-title>Detalls</v-list-tile-title>
  <v-list-tile-action>
    <v-icon color="success" title="Mira els detalls de la tasca">remove_red_eye</v-icon>
    </v-list-tile-action>
    <v-dialog v-model="dialog" @keydown.esc="dialog = false">
      <v-toolbar dark class="secondary darken-2">
        <v-btn color="white" flat icon @click.native="dialog = false">
          <v-icon class="mr-1">close</v-icon>
        </v-btn>
        <span class="title">{{ task.name }}</span>
        <v-spacer></v-spacer>
      </v-toolbar>
      <v-card>
        <v-card-text>
          <v-layout align-center justify-center row fill-height>
            <v-flex xs5 class="pt-2 pb-2">
              <v-flex xs12>
                <v-avatar size="100">
                  <img :alt="task.user_name" :src="task.user_gravatar">
                </v-avatar>
              </v-flex>
              <v-flex xs12 class="pt-2">
                <span class="subheading">{{ task.user_name }}</span>
              </v-flex>
            </v-flex>
            <v-flex xs7>
              <v-list class="pb-3 pb-3">
                <v-list-tile>
                  <v-list-tile-content>
                    <task-completed-toggle :readonly="true" :status="task.completed" :task="task"
                                           :tags="tags"></task-completed-toggle>
                  </v-list-tile-content>
                </v-list-tile>
                <v-list-tile>
                  <v-list-tile-content>
                    <v-tooltip bottom>
                      <span slot="activator" class="font-weight-thin"> {{task.description}} </span>
                      <span>Descripció</span>
                    </v-tooltip>
                  </v-list-tile-content>
                </v-list-tile>
                <v-list-tile>
                  <v-list-tile-content>
                    <task-tags-chips :task="task" :tags="tags" :selected-tags="task.tags" :readonly="true"></task-tags-chips>
                  </v-list-tile-content>
                </v-list-tile>
                <v-list-tile>
                  <v-list-tile-content>
                    <v-tooltip bottom>
                      <span slot="activator" class="subheading font-weight-light"> Creada {{task.created_at_human}} </span>
                      <span>{{ task.created_at_formatted }}</span>
                    </v-tooltip>
                  </v-list-tile-content>
                </v-list-tile>
                <v-list-tile>
                  <v-list-tile-content>
                    <v-tooltip bottom>
                      <span slot="activator" class="subheading font-weight-light"> Actualitzada {{task.updated_at_human}} </span>
                      <span>{{ task.updated_at_formatted }}</span>
                    </v-tooltip>
                  </v-list-tile-content>
                </v-list-tile>
              </v-list>
            </v-flex>
          </v-layout>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-list-tile>
</template>
<script>
import TaskForm from './TaskForm'
import TaskTagsChips from './TaskTagsChips'

export default {
  name: 'task-edit',
  components: { TaskTagsChips, TaskForm },
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
