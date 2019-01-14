<template>
    <div class="inline-flex">
      <div></div>
        <div class="overflow-visible content-center">
                <div v-if="errorMessage">
                    Hi ha un error: {{errorMessage}}

                </div>
                <h1 class="text-pink-lighter antialiased text-4x1">Tasques</h1>
            <div class="inline-flex"><input type="text"
                        placeholder="Introdueix una tasca"
                        name="name"
                        v-model="newTask" @keyup.enter="add"
                        class="shadow-lg border rounded w-full pa-2 px-3 mr-2 text-grey-darker leading-tight focus:outline-none focus:shadow-outline">
                <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded" id="button_add_task" @click="add()">Afegir</button></div>

                <!--<input :value="newTask" @input="newTask = $event.target.value">-->
            <ul class="list-reset m-3 pl-5">
                <!--<li v-for="dataTask in dataTasks" v-if="dataTask.completed">{{dataTask.name}}</li>-->
                <!--<li v-else>{{dataTask.name}}</li>-->
                <li class="text-grey-darker" v-for="dataTask in filteredTasks" :key="dataTask.id"><span
                        :class="{strike: estaCompletada(dataTask)}">

                    <editable-text :text="dataTask.name"
                                   @edited="editName(dataTask, $event)">

                    </editable-text>

                </span>&nbsp;<span :id="'delete_task_' + dataTask.id" @click="remove(dataTask)">&#x274c;</span>
                    <button @click="editName" class="m-2 p-3 bg-grey-light hover:bg-grey text-grey-darkest font-bold rounded inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/></svg>
                        <span>Edita</span>
                    </button>
                  <button @click="toggleCompleted(dataTask)" :class="colorButtonComplete(dataTask)" class="m-2 p-3 text-grey-darkest font-bold rounded inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/></svg>
                    <span>{{textButtonComplete(dataTask)}}</span>
                  </button>
                </li>

            </ul>
            </div>
      <div>
        <template v-if="total>0">
          <h3>Filtres:</h3>
          <h5>Active filter: {{ filter }}</h5>
          <ul>
            <li class="list-reset justify-start">
              <button @click="setFilter('all')">Totes</button>
            </li>
            <li class="list-reset justify-start">
              <button @click="setFilter('completed')">Completades</button>
            </li>
            <li class="list-reset justify-start">
              <button @click="setFilter('active')">Actives</button>
            </li>
          </ul>
        </template>
        Total: {{total}}
      </div>
    </div>
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
      return dataTask.completed
    })
  },
  active: function (dataTasks) {
    return dataTasks.filter(function (dataTask) {
      // if (!dataTasks.completed) return true
      // else return false
      return !dataTask.completed
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

      axios.put('/api/v1/tasks/' + dataTask.id, {
        name: text,
        completed: dataTask.completed
      }).then((response) => {
        console.log(response)
        dataTask.name = text
      }).catch((error) => {
        console.log(response)
      })
    },
    estaCompletada (dataTask) {
      return dataTask.completed
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
    },
    colorButtonComplete (task) {
      if (task.completed) return 'bg-red-light hover:bg-red'
      return 'bg-green-light hover:bg-green'
    },
    textButtonComplete (task) {
      if (task.completed) return 'Descompletar'
      return 'Completar'
    },
    toggleCompleted (task) {
      if (task.completed) {
        window.axios.delete('/api/v1/completed_task/' + task.id).then((response) => {
          this.$snackbar.showMessage("S'ha descompletat correctament la tasca")
          this.dataTasks.splice(this.dataTasks.indexOf(task), 1, response.data)
        }).catch(error => {
          this.$snackbar.showError(error.message)
        }) // TODO ACABAR
      } else {
        window.axios.post('/api/v1/completed_task/' + task.id).then((response) => {
          this.$snackbar.showMessage("S'ha completat correctament la tasca")
          this.dataTasks.splice(this.dataTasks.indexOf(task), 1, response.data)
        }).catch(error => {
          this.$snackbar.showError(error.message)
        })
      }
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
