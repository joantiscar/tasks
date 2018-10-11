<template>
    <span>
        <span v-if="!editing" @dblclick="editing=true">
            {{ text }}
        </span>
        <span v-if="editing" @keyup.esc="editing=false"
        @keyup.enter="edit">
            <input type="text" v-model="currentText">
        </span>
    </span>
</template>




<script>
export default {
    name: 'EditableText',
    data() {
        return{
            editing: false,
            currentText: this.text
        }
    },
    props: {
        'text': {
            type: String,
            required: true
        }
    },
    // props: [ 'text' ],
    methods: {
      edit() {
          this.editing = false
          this.$emit('edited', this.currentText)
          this.currentText = ''
      }
    },
    watch: {
        text(newText) {
            this.currentText = this.text
        }
    }
}


</script>
<style>

</style>