<template>
  <v-layout justify-center row wrap>
    <v-flex xs12 md10>
      <span>Audio de prova: ACDC - Back in Black</span>
      <audio src="https://upload.wikimedia.org/wikipedia/en/4/45/ACDC_-_Back_In_Black-sample.ogg" preload="auto" ref="audio">
        Tu navegador no implementa el elemento <code>audio</code>.
      </audio>
      <v-card>
        <v-layout row justify-start>
          <v-btn v-model="pause" flat icon @click="pause = !pause">
            <v-icon>{{playIcon}}</v-icon>
          </v-btn>
          <v-btn @click="rebobinar" flat icon>
            <v-icon>fast_rewind</v-icon>
          </v-btn>
          <v-btn @click="adelantar" flat icon>
            <v-icon>fast_forward</v-icon>
          </v-btn>
          <volume-slider @updated="updateVolume"></volume-slider>
        </v-layout>
      </v-card>
    </v-flex>

  </v-layout>
</template>
<script>
import VolumeSlider from './VolumeSlider'

export default {
  name: 'AudioComponent',
  components: { VolumeSlider },
  data () {
    return {
      pause: false,
      volume: 0,
      playIcon: 'play_arrow'
    }
  },
  watch: {
    pause (newValue) {
      if (newValue) {
        this.$refs.audio.play()
        this.playIcon = 'pause'
      } else {
        this.$refs.audio.pause()
        this.playIcon = 'play_arrow'
      }
    },
    volume (newValue) {
      this.$refs.audio.volume = newValue
    }
  },
  methods: {
    updateVolume (newValue) {
      this.volume = newValue / 100
    },
    adelantar () {
      this.$refs.audio.currentTime += 10
    },
    rebobinar () {
      this.$refs.audio.currentTime -= 10
    }
  }
}
</script>
