<template>
    <span>
  <v-dialog v-model="editDialog" @keydown.esc="editDialog = false">
            <v-toolbar color="primary" class="white--text">
            <v-btn color="white" flat icon @click.native="editDialog = false"><v-icon class="mr-1">close</v-icon></v-btn>

                Editar tag
               <v-spacer></v-spacer> <v-btn color="white" flat @click.native="editDialog = false"><v-icon class="mr-1">exit_to_app</v-icon>Sortir</v-btn>
               <v-btn color="white" flat @click.native="editDialog = false"><v-icon class="mr-1">save</v-icon>Guardar</v-btn>
            </v-toolbar>
            <v-card>
                <v-card-text>
        <v-form>
            <v-text-field v-model="tagBeingEdited.name" label="Nom" hint="El nom de la tag..."></v-text-field>
            <v-text-field v-model="tagBeingEdited.color" label="Color" hint="Color de la tag"></v-text-field>
          <v-textarea v-model="tagBeingEdited.description" label="Descripcio" hint="Descripció"></v-textarea>
            <div class="text-xs-center">
            <v-btn color="grey" @click.native="editDialog = false"><v-icon class="mr-1">exit_to_app</v-icon>Sortir</v-btn>
               <v-btn color="success" @click.native="edit()"><v-icon class="mr-1">save</v-icon>Guardar</v-btn>
                </div>
        </v-form>
                </v-card-text>
      </v-card>

  </v-dialog>
  <v-dialog v-model="showDialog" @keydown.esc="showDialog = false">
        <v-toolbar color="primary" class="white--text">
            <v-btn color="white" flat icon @click.native="showDialog = false"><v-icon class="mr-1">close</v-icon></v-btn>

                Crear tag
               <v-spacer></v-spacer> <v-btn color="white" flat @click.native="showDialog = false"><v-icon class="mr-1">exit_to_app</v-icon>Sortir</v-btn>
               <v-btn color="white" flat @click.native="showDialog = false"><v-icon class="mr-1">save</v-icon>Guardar</v-btn>
            </v-toolbar>
            <v-card>
                <v-card-text>
        <v-form>
            <v-text-field disabled v-model="tagBeingShown.name" label="Nom" hint="El nom de la tag..."></v-text-field>
            <v-text-field disabled v-model="tagBeingShown.color" label="Color" hint="Color de la tag"></v-text-field>
          <v-textarea disabled v-model="tagBeingShown.description" label="Descripcio" hint="Descripció"></v-textarea>
            <div class="text-xs-center">
            <v-btn color="grey" @click.native="showDialog = false"><v-icon class="mr-1">exit_to_app</v-icon>Sortir</v-btn>
                </div>
        </v-form>
                </v-card-text>
      </v-card>

  </v-dialog>
  <v-dialog v-model="createDialog" @keydown.esc="createDialog = false">
            <v-toolbar color="primary" class="white--text">
            <v-btn color="white" flat icon @click.native="createDialog = false"><v-icon class="mr-1">close</v-icon></v-btn>

                Crear tag
               <v-spacer></v-spacer> <v-btn color="white" flat @click.native="createDialog = false"><v-icon class="mr-1">exit_to_app</v-icon>Sortir</v-btn>
               <v-btn color="white" flat @click.native="createDialog = false"><v-icon class="mr-1">save</v-icon>Guardar</v-btn>
            </v-toolbar>
            <v-card>
                <v-card-text>
        <v-form>
            <v-text-field v-model="tagBeingCreated.name" label="Nom" hint="El nom de la tag..."></v-text-field>
            <v-text-field v-model="tagBeingCreated.color" label="Color" hint="Color de la tag"></v-text-field>
          <v-textarea v-model="tagBeingCreated.description" label="Descripcio" hint="Descripció"></v-textarea>
            <div class="text-xs-center">
            <v-btn color="grey" @click.native="createDialog = false"><v-icon class="mr-1">exit_to_app</v-icon>Sortir</v-btn>
               <v-btn color="success" @click.native="create()"><v-icon class="mr-1">save</v-icon>Guardar</v-btn>
                </div>
        </v-form>
                </v-card-text>
      </v-card>

  </v-dialog>

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
      <v-toolbar-title class="white--text">Tags</v-toolbar-title>
      <v-spacer></v-spacer>

        <v-btn icon dark class="white--text">
            <v-icon>settings</v-icon>
        </v-btn>
        <v-btn icon dark class="white--text" @click="refresh" :loading="loading" :disabled="loading">
            <v-icon>refresh</v-icon>
        </v-btn>

        </v-toolbar>
        <v-card>
        <v-card-title>
            <v-layout row wrap>
                <v-flex xs12>
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
              :items="dataTags"
              :search="search"
              no-results-text="No s'ha trobat cap registre coincident"
              :loading="loading"
              no-data-text=""
              rows-per-page-text="Tags per pàgina"
              :rows-per-page-items="[5,10,25,50,100,200,{'text':'Tots','value':-1}]"
              :pagination.sync="pagination"
              class="hidden-md-and-down">

                <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                <template slot="items" slot-scope="{item: tag}">
                    <tr>
                        <td>{{ tag.id}}</td>
                        <td>{{ tag.name}}</td>
                        <td>{{tag.description}}</td>
                        <td><v-icon :color="tag.color">bookmark</v-icon></td>
                        <td><span :title="tag.created_at_formatted">{{tag.created_at_human}}</span></td>
                        <td><span :title="tag.updated_at_formatted">{{tag.updated_at_human}}</span></td>
                        <td>
                        <v-btn v-if="$can('tags.update', tag)" color="success" icon flat title="Modificar la tag"
                               @click="showEdit(tag)">
                            <v-icon>border_color</v-icon>
                        </v-btn>
                            <v-btn v-if="$can('tags.show', tag)" color="success" icon flat title="Modificar la tag"
                                   @click="showShow(tag)">
                            <v-icon>remove_red_eye</v-icon>
                        </v-btn>
                        <v-btn v-if="$can('tags.destroy', tag)" :loading="removing === tag.id" :disabled="removing === tag.id" color="error" flat icon title="Eliminar la tag"
                               @click="destroy(tag)">
                            <v-icon>delete</v-icon>
                        </v-btn>
                        </td>
                    </tr>

                </template>
            </v-data-table>
        </v-card>
        <v-btn
          fab
          bottom
          right
          color="pink"
          fixed
          class="white--text"
          @click="showCreate"
          v-if="$can('user.tags.store')"
        >
            <v-icon>add</v-icon>

        </v-btn>
    </span>
</template>

<script>
export default{
  name: 'Tags',

  data () {
    return {
      name: '',
      description: '',
      completed: false,
      showName: '',
      showDescription: '',
      showCompleted: false,
      dataTags: this.tags,
      tagBeingRemoved: '',
      tagBeingCreated: {
      },
      tagBeingShown: '',
      tagBeingEdited: '',
      createDialog: false,
      editDialog: false,
      showDialog: false,
      filter: 'Totes',
      filters: [
        'Totes',
        'Completades',
        'Pendents'
      ],
      search: '',
      loading: false,
      creating: false,
      editing: false,
      removing: null,
      headers: [
        {
          text: 'id', value: 'id'
        },
        {
          text: 'Nom', value: 'name'
        },
        {
          text: 'Descripció', value: 'description'
        },
        {
          text: 'Color', value: 'color'
        },
        {
          text: 'Creat', value: 'created_at_timestamp'
        },
        {
          text: 'Modificat', value: 'updated_at_timestamp'
        },
        {
          text: 'Accions', sortable: false, value: 'full_search'
        }
      ],
      pagination: {
        rowsPerPage: 25
      }
    }
  },
  props: {
    tags: {
      type: Array,
      required: true
    }
  },
  // watch: {
  //   // dataTags (newDataTags, oldDataTags) {
  //   //     // PROBLEMA -> WATCH ARRAYS MALA COSA O OBJECTES
  //   //   console.log(this.dataTags)
  //   // }
  //   // dataTags: {
  //   //   handler: function (newDataTags, oldDataTags) {
  //   //     // PROBLEMA -> WATCH ARRAYS MALA COSA O OBJECTES
  //   //     console.log(this.dataTags)
  //   //   },
  //   //   deep: true
  //   // }
  //
  // },
  methods: {
    refresh () {
      this.loading = true
      // todo -> axios
      window.axios.get('/api/v1/tags').then(response => {
        console.log(response)
        this.dataTags = response.data
      }).catch(error => {
        console.log(error)
        this.loading = false
      }).finally(
        this.loading = false
      )
      // setTimeout(() => { this.loading = false }, 5000)
    },
    opcio1 () {
      console.log('Opcio1')
    },
    opcio2 () {
      console.log('Opcio2')
    },
    create () {
      this.creating = true
      window.axios.post('/api/v1/tags', this.tagBeingCreated).then((response) => {
        // this.refresh() // Problema -> rendiment
        this.createTag(response.data)
        this.$snackbar.showMessage("S'ha editat correctament la tag")
      }).catch((error) => {
        this.$snackbar.showError(error)
        this.creating = false
        this.editDialog = false
      }).finally(() => {
        this.creating = false
        this.createDialog = false
      })
    },
    showCreate () {
      this.createDialog = true
    },
    show (tag) {
      console.log('Show Tag' + tag.id)
    },
    removeTag ($tag) {
      this.dataTags.splice(this.dataTags.indexOf($tag), 1)
    },
    editTag ($tag) {
      this.dataTags.splice(this.dataTags.indexOf($tag), 1, $tag)
    },
    createTag ($tag) {
      this.dataTags.splice(0, 0, $tag)
    },

    // destroyWithPromises (tag) {
    //     // ES6 async await
    //
    //     let result = this.$confirm().then(
    //     if (result) {
    //         console.log('ok')
    //     }
    //
    //     ).catch()

    async destroy (tag) {
      // ES6 async await

      let result = await this.$confirm('Les tags esborrades no es poden recuperar',
        { title: 'Esteu segurs?', buttonTrueText: 'Eliminar', buttonFalseText: 'Cancel·lar', color: 'blue' })
      if (result) {
        this.removing = tag.id
        window.axios.delete('/api/v1/tags/' + tag.id).then(() => {
          // this.refresh() // Problema -> rendiment
          this.removeTag(tag)
          this.$snackbar.showMessage("S'ha esborrat correctament la tag")
        }).catch(error => {
          this.$snackbar.showError(error)
          this.removing = null
          this.destroyDialog = false
        }).finally(() => {
          this.removing = null
          this.destroyDialog = false
          // })
        })
      }
    },
    edit () {
      this.editing = true
      window.axios.put('/api/v1/tags/' + this.tagBeingEdited.id, this.tagBeingEdited).then(() => {
        // this.refresh() // Problema -> rendiment
        this.editTag(this.tagBeingEdited)
        this.$snackbar.showMessage("S'ha editat correctament la tag")
      }).catch((error) => {
        this.$snackbar.showError(error)
        this.editing = false
        this.editDialog = false
      }).finally(() => {
        this.editing = false
        this.editDialog = false
      })
    },
    showEdit (tag) {
      this.editDialog = true
      this.tagBeingEdited = tag
    },
    showShow (tag) {
      this.showDialog = true
      this.tagBeingShown = tag
    },

    complete (tag) {
      this.tagBeingEdited = tag
      this.edit()
    }
  },
  created () {
    console.log('Usuari logat:')
    console.log(window.laravel_user)
  }
}

</script>
