<template>
  <v-form>
    <v-text-field v-model="name"
                  :error-messages="nameErrors"
                  @input="$v.name.$touch()"
                  @blur="$v.name.$touch()"
                  label="Nom"
                  hint="El nom de la tasca..."></v-text-field>
    <v-switch v-model="completed"
              :label="completed ? 'Completada' : 'Pendent'"></v-switch>
    <!--<v-select label="User" :items="users" v-model="user_id" item-text="name" item-value="id"-->
              <!--clearable></v-select>-->
    <user-select :users="users" label="User" v-model="user_id"></user-select>

    <v-textarea v-model="description" label="Descripcio" hint="Descripció"></v-textarea>
    <div class="text-xs-center">
      <v-btn color="grey" @click.native="$emit('close')">
        <v-icon class="mr-1">exit_to_app</v-icon>
        Sortir
      </v-btn>
      <v-btn color="success" @click.native="create" :disabled="loading || $v.$invalid" :loading="loading">
        <v-icon class="mr-1">save</v-icon>
        Guardar
      </v-btn>
    </div>
  </v-form>
</template>
<script>
import { validationMixin } from 'vuelidate'
import { required } from 'vuelidate/lib/validators'
export default {
  mixins: [validationMixin],
  validations: {
    name: { required }
  },
  name: 'TaskForm',
  data () {
    return {
      name: '',
      completed: false,
      description: '',
      user_id: '',
      loading: false

    }
  },
  props: {
    users: {
      type: Array,
      required: true
    },
    uri: {
      type: String,
      default: '/api/v1/tasks'
    }
  },
  computed: {
    nameErrors () {
      const errors = []
      if (!this.$v.name.$dirty) return errors
      !this.$v.name.required && errors.push('El nom és obligatori')
      return errors
    }
  },
  methods: {
    reset () {
      this.name = ''
      this.description = ''
      this.completed = ''
      this.user_id = ''
    },
    create () {
      this.creating = true
      const task = {
        'name': this.name,
        'description': this.description,
        'completed': this.completed,
        'user_id': this.user_id
      }
      window.axios.post(this.uri, task).then((response) => {
        // this.refresh() // Problema -> rendiment
        this.$snackbar.showMessage("S'ha editat correctament la tasca")
        this.$emit('created', response.data)
      }).catch((error) => {
        this.$snackbar.showError(error)
        this.creating = false
        this.reset
      }).finally(() => {
        this.creating = false
      })
    }
  }
}
</script>
