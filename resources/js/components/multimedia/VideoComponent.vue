<template>
  <v-layout justify-center row wrap>
    <v-flex xs12 md10>
      <video src="http://clips.vorwaerts-gmbh.de/VfE_html5.mp4" ref="video" width="100%">
        Tu navegador no implementa el elemento <code>video</code>.
      </video>
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
          <v-spacer></v-spacer>
          <v-btn v-model="fullscreen" flat icon @click="fullscreen = !fullscreen">
            <v-icon>{{fullscreenIcon}}</v-icon>
          </v-btn>
        </v-layout>
      </v-card>
    </v-flex>

  </v-layout>
</template>
<script>
import VolumeSlider from './VolumeSlider'

export default {
  name: 'VideoComponent',
  components: { VolumeSlider },
  data () {
    return {
      pause: false,
      fullscreen: false,
      volume: 0,
      playIcon: 'play_arrow',
      fullscreenIcon: 'fullscreen'
    }
  },
  watch: {
    pause (newValue) {
      if (newValue) {
        this.$refs.video.play()
        this.playIcon = 'pause'
      } else {
        this.$refs.video.pause()
        this.playIcon = 'play_arrow'
      }
    },
    fullscreen (newValue) {
      if (this.$refs.video.requestFullscreen) {
        this.$refs.video.requestFullscreen()
        if (newValue) {
          this.$refs.video.play()
          this.fullscreenIcon = 'fullscreen_exit'
        } else {
          this.$refs.video.pause()
          this.fullscreenIcon = 'fullscreen'
        }
      }
    },
    volume (newValue) {
      this.$refs.video.volume = newValue
    }
  },
  methods: {
    updateVolume (newValue) {
      this.volume = newValue / 100
    },
    adelantar () {
      this.$refs.video.currentTime += 10
    },
    rebobinar () {
      this.$refs.video.currentTime -= 10
    }
  }
}
</script>
