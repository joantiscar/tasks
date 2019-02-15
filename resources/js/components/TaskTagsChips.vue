<template>
<span>
    <v-dialog v-model="dialog" width="400">
      <v-card>
        <v-card-title>Afegir una etiqueta a la tasca {{dataTask.name}}</v-card-title>
        <v-card-text>
         <v-combobox
           v-model="dataSelectedTags"
           :items="tags"
           item-text="name"
           item-value="name"
           label="Escull o tria una etiqueta"
           multiple
           chips
           :readonly="readonly"
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
        <v-card-actions v-if="!readonly">
        <v-btn flat @click="dialog = false">Cancelar</v-btn>
        <v-btn color="primary" flat @click="add()">Afegir</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  <v-chip v-for="tag in dataTask.tags" v-text="tag.name" :key="tag.id" :color="tag.color" @dblclick="removeTag(tag)"></v-chip>
    <v-btn v-if="!readonly" icon @click="dialog = true"><v-icon>add</v-icon></v-btn>
  </span>
</template>

<script>
export default {
  name: 'TaskTagsChips',
  data () {
    return {
      dialog: false,
      newTag: '',
      dataSelectedTags: this.selectedTags,
      data: '',
      dataTask: this.task
    }
  },
  model: {
    prop: 'selectedTags',
    event: 'updated'
  },
  props: {
    task: {
      type: Object,
      default: function () {
        return {}
      }
    },
    tags: {
      type: Array,
      required: true
    },
    selectedTags: {
      type: Array,
      default: function () {
        return []
      }
    },
    readonly: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    add () {
      this.$emit('updated', this.dataSelectedTags)
      this.dialog = false
    },
    removeTag (tag) {
      this.$emit('deleted', tag)
    }
  }
}
</script>

<style scoped>

</style>
