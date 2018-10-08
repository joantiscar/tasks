<template>
  <div id="app">
    <tasks></tasks>
  </div>
</template>

<script>
import Tasks from './components/Tasks.vue'
import EditableText from './components/EditableText.vue'

export default {
  name: 'app',
  components: {
    'tasks' : Tasks,
      'editable-text' : EditableText
  }
}
</script>

<style>
/*#app {*/
  /*font-family: 'Avenir', Helvetica, Arial, sans-serif;*/
  /*-webkit-font-smoothing: antialiased;*/
  /*-moz-osx-font-smoothing: grayscale;*/
  /*text-align: center;*/
  /*color: #2c3e50;*/
  /*margin-top: 60px;*/
/*}*/
</style>
