<template>
  <v-form>
    <v-text-field v-model="name"
                  :error-messages="nameErrors"
                  @input="$v.name.$touch()"
                  @blur="$v.name.$touch()"
                  :disabled="loading"
                  label="Nom"
                  hint="El nom de la tasca..."></v-text-field>
    <v-switch v-model="editingTask.completed"
              :disabled="loading"
              :label="editingTask.completed ? 'Completada' : 'Pendent'"></v-switch>
    <!--<v-select label="User" :items="users" v-model="editingTask.user_id" item-text="name" item-value="id"-->
              <!--clearable></v-select>-->
    <span>Tags: <task-tags-chips v-model="editingTask.tags" :selected-tasks="editingTask.tags" :task="editingTask" :tags="tags"></task-tags-chips></span>
    <user-select :users="users" label="User" v-model="editingTask.user_id"></user-select>

    <v-textarea v-model="editingTask.description" label="Descripcio" hint="Descripció" :disabled="loading"></v-textarea>
    <div class="text-xs-center">
      <v-btn flat class="grey--text" @click.native="$emit('close')" :disabled="loading" :loading="loading">
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
import TaskTagsChips from './TaskTagsChips'
export default {
  components: { TaskTagsChips },
  mixins: [validationMixin],
  validations: {
    name: { required }
  },
  name: 'TaskForm',
  data () {
    return {
      loading: false,
      name: this.task.name,
      editingTask: {
        id: this.task.id,
        name: this.task.name,
        completed: this.task.completed,
        description: this.task.description,
        user_id: this.task.user_id,
        tags: this.task.tags
      }
    }
  },
  props: {
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
    },
    task: {
      type: Object,
      default: function () {
        return {
          tags: []
        }
      }
    }
  },
  computed: {
    nameErrors () {
      const errors = []
      console.log(this.$v)
      if (!this.$v.name.$dirty) return errors
      !this.$v.name.required && errors.push('El nom és obligatori')
      return errors
    }
      },
  methods: {
    reset () {
      this.editingTask.name = ''
      this.editingTask.description = ''
      this.editingTask.completed = false
      this.editingTask.user_id = ''
    },
    create () {
      this.loading = true
      const task = {
        'name': this.name,
        'description': this.editingTask.description,
        'completed': this.editingTask.completed,
        'user_id': this.editingTask.user.id,
        'tags': this.editingTask.tags
      }
      this.$emit('saved', task)
    }
  }
}
</script>
