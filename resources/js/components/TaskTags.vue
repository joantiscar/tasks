<template>

  <task-tags-chips v-model="task.tags" :task="task" :tags="tags" @updated="add" @deleted="removeTag"></task-tags-chips>

</template>

<script>
import TaskTagsChips from './TaskTagsChips'
export default {
  name: 'TaskTags',
  components: { TaskTagsChips },
  data () {
    return {
      dialog: false,
      newTag: '',
      selectedTags: [],
      data: ''
    }
  },
  props: {
    task: {
      type: Object,
      required: true
    },
    tags: {
      type: Array,
      required: true
    }
  },
  methods: {
    add (tags) {
      window.axios.post(('/api/v1/task/' + this.task.id + '/tags/multiple'), tags).then((response) => {
        this.$snackbar.showMessage('Etiquetes afegides correctament')
      }).catch((error) => {
        this.$snackbar.showError(error.message)
      })
    },
    async removeTag (tag) {
      let result = await this.$confirm('',
        { title: 'Esteu segurs?', buttonTrueText: 'Eliminar', buttonFalseText: 'Cancel·lar', color: 'blue' })
      if (result) {
        window.axios.delete(('/api/v1/task/' + this.task.id + '/tags/' + tag.id)).then((response) => {
          this.$snackbar.showMessage('Etiqueta eliminada correctament')
        }).catch((error) => {
          this.$snackbar.showError(error.message)
        })
      }
    }
  }
}
</script>
