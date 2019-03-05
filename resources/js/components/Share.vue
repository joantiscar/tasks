<template>
    <v-btn
            v-if="show"
            color="accent"
            @click="share"
            dark
            icon
            flat
    >
        <span class="mr-2" v-if="menu">Comparteix</span>

        <v-icon>share</v-icon>
    </v-btn>
</template>

<script>
export default {
  name: 'Share',
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
    },
    menu: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    show () {
      return ('share' in navigator)
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
  }
}
</script>
