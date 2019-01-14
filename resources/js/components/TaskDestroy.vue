<template>

  <v-btn v-if="$can('tasks.destroy', task)" :loading="loading === task.id" :disabled="loading === task.id"
  color="error" flat icon title="Eliminar la tasca"
  @click="destroy">
  <v-icon>delete</v-icon>
  </v-btn>
</template>
<script>
export default{
  'name': 'TaskDestroy',
  data () {
    return {
      loading: false
    }
  },
  props: {
    task: {
      type: Object,
      required: true
    },
    uri: {
      type: String,
      default: '/api/v1/tasks'
    }
  },
  methods: {
    async destroy () {
      // ES6 async await

      let result = await this.$confirm('Les tasques esborrades no es poden recuperar',
        { title: 'Esteu segurs?', buttonTrueText: 'Eliminar', buttonFalseText: 'Cancel·lar', color: 'blue' })
      if (result) {
        this.loading = true
        window.axios.delete(this.uri + '/' + this.task.id).then(() => {
          // this.refresh() // Problema -> rendiment
          this.$emit('removed', this.task)
          this.$snackbar.showMessage("S'ha esborrat correctament la tasca")
        }).catch(error => {
          this.$snackbar.showError(error.message)
          this.loading = false
        }).finally(() => {
          this.loading = false
          // })
        })
      }
    }
  }
}
</script>
