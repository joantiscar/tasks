<template>
    <v-btn
            color="accent"
            @click="share"
            v-if="show"
            fab
            fixed
            bottom
            right
            dark
    >
        <v-icon>share</v-icon>
    </v-btn>
</template>

<script>
export default {
  name: 'ShareFab',
  data () {
    return {
      dataTitle: this.title,
      dataText: this.text,
      dataUrl: this.url
    }
  },

  props: {
    title: {
      type: String,
      default: 'Tasques Joan Tíscar'
    },
    text: {
      type: String,
      default: 'pos moltes mes tasques'
    },
    url: {
      type: String,
      default: 'https://tasks.joantiscar.scool.cat'
    }
  },
  methods: {
    share () {
      navigator.share({
        title: this.dataTitle,
        text: this.dataText,
        url: this.dataUrl
      })
        .then(() => console.log('Successful share'))
        .catch(error => console.log('Error sharing:', error))
    }
  },
  computed: {
    show () {
      return ('share' in navigator)
    }
  }
}
</script>
