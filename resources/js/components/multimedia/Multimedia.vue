<template>
  <div>
    <video-component />
    <audio-component />
  </div>
</template>

<script>
import VideoComponent from './VideoComponent'
import AudioComponent from './AudioComponent'

export default {
  name: 'Multimedia',
  components: { AudioComponent, VideoComponent }

}
</script>
