<template>
    <v-container grid-list-md text-xs-center>
        <v-layout align-start justify-center row fill-heigh>
            <v-flex xs6>
            <v-card >

                <v-card-title class="display-2">Tasques</v-card-title>
            <div class="flex-row">

                <div v-if="errorMessage">
                    Hi ha un error: {{errorMessage}}

                </div>

                <input type="text"
                       name="name"
                       v-model="newTask" @keyup.enter="add"
                       class="m-3 mt-5 p-2 pl-5 shadow rounded focus:shadow-outline text-grey-darker">
                <button id="button_add_task" @click="add()">Afegir</button>
                <!--<input :value="newTask" @input="newTask = $event.target.value">-->
            </div>
            <ul class="list-reset m-3 pl-5">
                <!--<li v-for="dataTask in dataTasks" v-if="dataTask.completed">{{dataTask.name}}</li>-->
                <!--<li v-else>{{dataTask.name}}</li>-->
                <li class="text-grey-darker" v-for="dataTask in filteredTasks" :key="dataTask.id"><span
                        :class="{ strike: dataTask.completed }">

                    <editable-text :text="dataTask.name"
                                   @edited="editName(dataTask, $event)">

                    </editable-text>

                </span>&nbsp;<span :id="'delete_task_' + dataTask.id" @click="remove(dataTask)">&#x274c;</span>
                    <button @click="editName">Editar</button>

                </li>

            </ul>
            <template v-if="total>0">
            <h3>Filtres:</h3>
            <h5>Active filter: {{ filter }}</h5>
            <ul>
                <li class="list-reset">
                    <button @click="setFilter('all')">Totes</button>
                </li>
                <li class="list-reset">
                    <button @click="setFilter('completed')">Completades</button>
                </li>
                <li class="list-reset">
                    <button @click="setFilter('active')">Actives</button>
                </li>
            </ul>
            </template>
            Total: {{total}}
            </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
/* eslint-disable no-undef */

import EditableText from './EditableText.vue'

var filters = {
  all: function (dataTasks) {
    return dataTasks
  },
  completed: function (dataTasks) {
    return dataTasks.filter(function (dataTask) {
      // if (dataTasks.completed) return true
      // else return false
      return dataTasks.completed
    })
  },
  active: function (dataTasks) {
    return dataTasks.filter(function (dataTask) {
      // if (!dataTasks.completed) return true
      // else return false
      return !dataTasks.completed
    })
  }
}
export default {
  components: {
    'editable-text': EditableText
  },
  data () {
    return {
      errorMessage: false,
      filter: 'all', // all completed active
      newTask: '',
      dataTasks: this.tasks
    }
  },
  props: {
    'tasks': {
      type: Array,
      default: function () {
        return []
      }
    }
  },
  computed: {
    filteredTasks () {
      return filters[this.filter](this.dataTasks)
    },
    total () {
      return this.dataTasks.length
    }
  },
  watch: {
    tasks (newTasks) {
      this.dataTasks = newTasks
    }
  },
  methods: {
    editName (dataTask, text) {
      console.log('acho')
      dataTask.name = text
    },
    add () {
      axios.post('/api/v1/tasks', {
        name: this.newTask,
        completed: false
      }).then((response) => {
        this.dataTasks.splice(0, 0, { id: response.data.id, name: this.newTask, completed: this.completed })
        this.newTask = ''
      }).catch((error) => {
        console.log(response)
      })
    },
    remove (dataTask) {
      console.log('estic dins del remove')
      window.console.log(dataTask.id)
      axios.delete('/api/v1/tasks/' + dataTask.id, {
      }).then((response) => {
        console.log('ok')
        this.dataTasks.splice(this.dataTasks.indexOf(dataTask), 1)
      }).catch((error) => {
      })
    },
    setFilter (newFilter) {
      this.filter = newFilter
    }
  },
  created () {
    // Si tinc prop tasks no fer res
    // Else vull fer petició a la api per obtindre les tasques
    if (this.dataTasks.length === 0) {
      console.log('entra if')
      // axios.get('/api/v1/task')
      this.dataTasks = axios.get('/api/v1/tasks').then((response) => {
        console.log('entra ok')
        console.log(response.data)
        this.dataTasks = response.data
      }).catch((error) => {
        console.log('entra_error')
        this.errorMessage = error.response
      })
    } else {
      console.log('else')
    }
  }
}

// CAR
// {
//     marca: 'Renault',
//     consum: '51/100',
//     start: function(){
//     console.log('arranca');
// }
// }

</script>

<style>
    .strike {
        text-decoration: line-through;

    }

</style>
