<template>
    <v-form action="/password.update" method="post">
        <v-toolbar dark color="primary">
            <v-toolbar-title>Recuperar contrassenya </v-toolbar-title>
            <v-spacer></v-spacer>
        </v-toolbar>
        <v-card-text>
            <input type="hidden" name="_token" :value="csrfToken">
            <v-text-field prepend-icon="person" name="email" label="email" type="text" v-model="dataEmail" :error-messages="emailErrors" @input="$v.dataEmail.$touch()" @blur="$v.dataEmail.$touch()"></v-text-field>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" type="submit">Login</v-btn>
        </v-card-actions>
    </v-form>
</template>

<script>
// validationMixin = vuelidate.validationMixin
import { validationMixin } from 'vuelidate'
import { required, email, minLength } from 'vuelidate/lib/validators'

export default {
  mixins: [validationMixin],
  validations: {
    dataEmail: { required, minLength: minLength(6), email },
  },
  name: 'RecoverPassword',
  data () {
    return {
      dataEmail: this.email,
      password: ''
    }
  },
  props: {
    'email': '',
    'csrfToken': ''
  },
  computed: {
    emailErrors () {
      const errors = []
      if (!this.$v.dataEmail.$dirty) return errors

      !this.$v.dataEmail.minLength && errors.push('El camp email ha de tindre una mida minima de 6 caracters')
      !this.$v.dataEmail.required && errors.push('El camp email es obligatori')
      !this.$v.dataEmail.email && errors.push('El camp email ha de tindre un format mail valid')
      return errors
    },
    passwordErrors () {
      const errors = []
      if (!this.$v.password.$dirty) return errors
      !this.$v.password.minLength && errors.push('El camp password ha de tindre una mida minima de 6 caracters')
      !this.$v.password.required && errors.push('El camp password es obligatori')
      return errors
    }
  }
}
</script>

<style scoped>

</style>
