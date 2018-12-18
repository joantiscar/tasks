<template>
  <span>
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
    <v-btn icon dark class="white--text" @click="refresh" :loading="loading" :readonly="loading">
      <v-icon>refresh</v-icon>
    </v-btn>

  </v-toolbar>
  <v-card>
    <v-card-title>
      <v-layout row wrap>
        <v-flex xs4>
          <user-select :users="dataUsers" label="Filtrar per usuari" class="pr-4"></user-select>
        </v-flex>
        <v-flex xs4>
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
    >

    <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
    <template slot="items" slot-scope="{item: task}">
      <tr>
        <td>{{ task.id}}</td>
        <td>{{ task.name}}</td>
        <v-avatar :title="task.user_name">
          <img :src="task.user_gravatar" alt="avatar">
        </v-avatar>
        <td>
          <task-completed-toggle :task="task" :tags="tags"></task-completed-toggle>
        </td>
        <td><task-tags :tags="tags" :task="task"></task-tags></td>
        <td><span :title="task.created_at_formatted">{{task.created_at_human}}</span></td>
        <td><span :title="task.updated_at_formatted">{{task.updated_at_human}}</span></td>
        <td>
          <task-destroy :task="task" @removed="removeTask" :uri="uri"></task-destroy>
            <task-edit :task="task" :users="dataUsers" @edited="refresh"></task-edit>
          <!--<v-btn v-if="$can('tasks.show', task)" color="success" icon flat title="Modificar la tasca"-->
                 <!--@click="showShow">-->
            <!--<v-icon>remove_red_eye</v-icon>-->
          <!--</v-btn>-->
        </td>
      </tr>

    </template>
  </v-data-table>
  </v-card>
  </span>
</template>
<script>
import TaskCompletedToggle from './TaskCompletedToggle'
import TaskEdit from './TaskEdit'
import TaskCreate from './TaskCreate'
import TaskDestroy from './TaskDestroy'
import TaskTags from './TaskTags'
export default {
  name: 'tasks-list',
  components: { TaskCompletedToggle, TaskEdit, TaskCreate, TaskDestroy, TaskTags},
  data () {
    return {
      dataUsers: this.users,
      search: '',
      dataTasks: this.tasks,
      loading: false,
      headers: [
        { text: 'id', value: 'id' },
        { text: 'Nom', value: 'name' },
        { text: 'Usuari', value: 'user' },
        { text: 'Completat', value: 'completed' },
        { text: 'Etiquetes', value: 'tags' },
        { text: 'Creat', value: 'created_at_timestamp' },
        { text: 'Modificat', value: 'updated_at_timestamp' },
        { text: 'Accions', sortable: false, value: 'full_search' }
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
    refresh () {
      this.loading = true
      // todo -> axios
      window.axios.get(this.uri).then(response => {
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
    removeTask (task) {
      this.dataTasks.splice(this.dataTasks.indexOf(task), 1)
    },
    opcio1 () {
      console.log('Opcio1')
    },
    opcio2 () {
      console.log('Opcio2')
    }
  }
}
</script>
