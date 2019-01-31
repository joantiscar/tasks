<template>
    <span>
        <v-avatar color="grey lighten-4" class="mx-auto d-block" :size="size" :tile="tile" @click="change" @dblclick="$emit('dblclick')">
            <img ref="previewImage"
                 :src="src"
                 :alt="alt"
                 :title="alt">
            <form class="upload" v-if="editable">
                <input
                        ref="file"
                        type="file"
                        name="photo"
                        accept="image/*"
                        :disabled="uploading"
                        @change="photoChange"/>
            </form>
        </v-avatar>
        <confirm-icon v-if="removable && user.photo"
                      icon="delete"
                      color="pink"
                      :working="deleting"
                      @confirmed="remove()"
                      :tooltip="tooltip"
                      :message="message"
        ></confirm-icon>
    </span>
</template>

<script>
import ConfirmIconComponent from './ConfirmIconComponent'

export default {
  name: 'UserAvatarComponent',
  components: {
    'confirm-icon': ConfirmIconComponent
  },
  data () {
    return {
      uploading: false,
      deleting: false,
      path: ''
    }
  },
  props: {
    editable: {
      type: Boolean,
      default: false
    },
    removable: {
      type: Boolean,
      default: false
    },
    user: {
      type: Object,
      default: () => { return {} }
    },
    tooltip: {
      type: String,
      required: true
    },
    message: {
      type: String,
      required: true
    },
    uri: {
      type: String,
      required: true
    },
    size: {
      type: String,
      default: '40'
    },
    alt: {
      required: true
    },
    src: {
      type: String,
      required: true
    },
    tile: {
      type: Boolean,
      default: false
    },
    imageTypeName: {
      type: String,
      required: true
    }
  },
  methods: {
    photoChange (event) {
      this.uploading = true
      let target = event.target || event.srcElement
      if (target.value.length !== 0) {
        const formData = new FormData()
        formData.append(this.imageTypeName, this.$refs.file.files[0])
        this.preview()
        this.save(formData)
      }
    },
    save (formData) {
      console.log(formData)
      window.axios.post(this.uri, formData)
        .then(response => {
          this.uploading = false
          this.path = response.data
          this.$emit('input', this.path)
        })
        .catch(error => {
          this.uploading = false
          this.$snackbar.showError(error)
        })
    },
    preview () {
      if (this.$refs.file.files && this.$refs.file.files[0]) {
        let reader = new FileReader()
        reader.onload = e => {
          this.$refs.previewImage.setAttribute('src', e.target.result)
        }
        reader.readAsDataURL(this.$refs.file.files[0])
      }
    },
    change () {
      if (this.editable) this.$refs.file.click()
      this.$emit('click')
    },
    remove () {
      this.deleting = true
      window.axios.delete(this.uri)
        .then(response => {
          this.deleting = false
          this.path = ''
          this.$emit('input', this.path)
          this.$refs.previewImage.setAttribute('src', 'img/default.png')
          this.user.photo = null
        })
        .catch(error => {
          this.deleting = false
          this.$snackbar.showError(error)
        })
    }
  }
}
</script>

<style scoped>
    .upload > input
    {
        display: none;
    }
</style>
