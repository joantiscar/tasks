<template>
  <span>
    <v-dialog v-model="dialog" width="400">
      <v-card>
        <v-card-title>Afegir una etiqueta a la tasca {{task.name}}</v-card-title>
        <v-card-text>
         <v-combobox
           v-model="selectedTags"
           :items="tags"
           item-text="name"
           item-value="name"
           label="Escull o tria una etiqueta"
           multiple
           chips
         >
           <template slot="selection" slot-scope="data">
             <v-chip>
               <v-chip
                 :selected="data.selected"
                 :disabled="data.disabled"
                 :key="JSON.stringify(data.item)"
                 class="v-chip--select-multi "
                 @input="data.parent.selectItem(data.item)"
               >
              {{ data.item.name }}
            </v-chip>
             </v-chip>
           </template>
         </v-combobox>
         </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
        <v-btn color="error" flat @click="dialog = false">Cancelar</v-btn>
        <v-btn color="primary" flat @click="add()">Afegir</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  <v-chip v-for="tag in task.tags" v-text="tag.name" :key="tag.id" :color="tag.color" @dblclick="removeTag()"></v-chip>
    <v-btn icon @click="dialog = true"><v-icon>add</v-icon></v-btn>
  </span>
</template>

<script>
export default {
  name: 'TaskTags',
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
    add () {
      window.axios.post(('/api/v1/task/' + this.task.id + '/tags'), this.newTag).then((response) => {
        this.$snackbar.showMessage('Etiqueta afegida correctament')
      }).catch((error) => {
        this.$snackbar.showError(error)
      })
    },
    async removeTag () {
      let result = await this.$confirm('',
        { title: 'Esteu segurs?', buttonTrueText: 'Eliminar', buttonFalseText: 'Cancel·lar', color: 'blue' })
      if (result) {
        window.axios.post(('/api/v1/task/' + this.task.id + '/tags/' + this.tag)).then((response) => {
          this.$snackbar.showMessage('Etiqueta eliminada correctament')
        }).catch((error) => {
          this.$snackbar.showError(error)
        })
      }
    }
  }
}
</script>
