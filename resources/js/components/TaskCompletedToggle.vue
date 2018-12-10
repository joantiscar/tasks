<template>
    <v-switch :loading="loading" :disabled="loading" v-model="dataTask.completed" :label="dataTask.completed ? 'Completada' : 'Pendent'"></v-switch>
</template>

<script>
export default {
  name: 'Toggle',
  data () {
    return {
      dataTask: this.task,
      loading: false
    }
  },
  props: {
    task: {
      type: Object,
      required: true
    }
  },
  watch: {
    // task (task) {
    //   this.dataTask = task
    // },
    dataTask: {
      handler: function (dataTask) {
        if (dataTask.completed) this.completeTask()
        else this.uncompleteTask()
      },
      deep: true
    }
    // task (task) {
    //   this.dataCompleted = task.completed
    // },
    // Watchers Imperativa NO DECLARATIVA

  },
  methods: {
    async uncompleteTask () {
      // LOADING I DISABLED TODO
      this.loading = true
      await window.axios.delete('/api/v1/completed_task/' + this.task.id).then((response) => {
        this.$snackbar.showMessage("S'ha descompletat correctament la tasca")
        this.loading = false
      }).catch(error => {
        this.$snackbar.showError(error)
        this.removing = null
      }) // TODO ACABAR
    },
    async completeTask () {
      this.loading = true
      await window.axios.post('/api/v1/completed_task/' + this.task.id).then((response) => {
        this.$snackbar.showMessage("S'ha completat correctament la tasca")
        this.loading = false
      }).catch(error => {
        this.$snackbar.showError(error)
        this.removing = null
      }) // TODO ACABAR
    }
  }
}
</script>
