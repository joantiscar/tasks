<template>
    <v-layout
        align-start
        justify-center
        row
        wrap>
        <v-flex xs12>
            <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs>
        </v-flex>
<v-flex xs12 md6>
    <v-toolbar color="primary">
        <span class="title">{{ task.name }}</span>
        <v-spacer></v-spacer>
    </v-toolbar>
    <task-show-content class="elevation-10" :task="task" :tags="tags"></task-show-content>
</v-flex>
    </v-layout>
</template>

<script>
import TaskShow from './TaskShowMobile'
import TaskShowContent from './TaskShowContent'
export default {
  name: 'ShowTask',
  components: { TaskShowContent, TaskShow },
  data () {
    return {
      items: [
        {
          text: 'Tasques',
          disabled: false,
          href: '/tasques'
        },
        {
          text: 'Tasca ' + this.task.name,
          disabled: false,
          href: '/tasques/' + this.task.id
        }
      ]
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
  }
}
</script>
