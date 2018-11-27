import Vue from 'vue'
const EventBus = new Vue()
export default EventBus

// bus.$emit() // Disparar Esdeveniments -> Tags o en Tasks dispararem showSnackBar
// bus.$on('show') -> Mostrar el snackbar