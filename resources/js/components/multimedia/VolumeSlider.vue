<template>
    <div id="volume-slider" class="ma-0 pa-0">
        <svg id="volume-icon" class="volume-icon" viewBox="-1 0 33 32">
            <defs>
                <mask id="circle-mask" x="-1" y="0" width="33" height="32">
                    <circle cx="-1" cy="16" r="33" fill="white" id="circle-mask-shape" />
                </mask>

                <mask id="volume-mask" x="-1" y="0" width="33" height="32">
                    <path d="M22.485 25.985c-0.384 0-0.768-0.146-1.061-0.439-0.586-0.586-0.586-1.535 0-2.121 4.094-4.094 4.094-10.755 0-14.849-0.586-0.586-0.586-1.536 0-2.121s1.536-0.586 2.121 0c2.55 2.55 3.954 5.94 3.954 9.546s-1.404 6.996-3.954 9.546c-0.293 0.293-0.677 0.439-1.061 0.439v0zM17.157 23.157c-0.384 0-0.768-0.146-1.061-0.439-0.586-0.586-0.586-1.535 0-2.121 2.534-2.534 2.534-6.658 0-9.192-0.586-0.586-0.586-1.536 0-2.121s1.535-0.586 2.121 0c3.704 3.704 3.704 9.731 0 13.435-0.293 0.293-0.677 0.439-1.061 0.439zM13 30c-0.26 0-0.516-0.102-0.707-0.293l-7.707-7.707h-3.586c-0.552 0-1-0.448-1-1v-10c0-0.552 0.448-1 1-1h3.586l7.707-7.707c0.286-0.286 0.716-0.372 1.090-0.217s0.617 0.519 0.617 0.924v26c0 0.404-0.244 0.769-0.617 0.924-0.124 0.051-0.254 0.076-0.383 0.076z" fill="white" mask="url(#circle-mask)"></path>
                </mask>

                <linearGradient id="grad-1" x1="0" x2="1" y1="0" y2="0">
                    <stop offset="20%" stop-color="#9a88aa" />
                    <stop offset="100%" stop-color="#6e33a5" />
                </linearGradient>
            </defs>

            <path class="volume-icon-bg" fill="#cbc8ce" d="M22.485 25.985c-0.384 0-0.768-0.146-1.061-0.439-0.586-0.586-0.586-1.535 0-2.121 4.094-4.094 4.094-10.755 0-14.849-0.586-0.586-0.586-1.536 0-2.121s1.536-0.586 2.121 0c2.55 2.55 3.954 5.94 3.954 9.546s-1.404 6.996-3.954 9.546c-0.293 0.293-0.677 0.439-1.061 0.439v0zM17.157 23.157c-0.384 0-0.768-0.146-1.061-0.439-0.586-0.586-0.586-1.535 0-2.121 2.534-2.534 2.534-6.658 0-9.192-0.586-0.586-0.586-1.536 0-2.121s1.535-0.586 2.121 0c3.704 3.704 3.704 9.731 0 13.435-0.293 0.293-0.677 0.439-1.061 0.439zM13 30c-0.26 0-0.516-0.102-0.707-0.293l-7.707-7.707h-3.586c-0.552 0-1-0.448-1-1v-10c0-0.552 0.448-1 1-1h3.586l7.707-7.707c0.286-0.286 0.716-0.372 1.090-0.217s0.617 0.519 0.617 0.924v26c0 0.404-0.244 0.769-0.617 0.924-0.124 0.051-0.254 0.076-0.383 0.076z"></path>

            <rect x="-1" y="0" width="33" height="32" mask="url(#volume-mask)" fill="url(#grad-1)" />
        </svg>

        <div class="volume-track">
            <span id="volume-indicator" class="volume-indicator"></span>
            <input type="hidden" name="volume" id="volume-input" ref="volume-input" />
        </div>
    </div>

</template>

<script>
export default {
  name: 'VolumeSlider',
  data () {
    return {
      volumeSlider: null,
      volume: 0,
      sliderTag: this.$refs.volumeSlider
    }
  },
  methods: {
    update () {
      if (this.volumeSlider._volume !== this.volume) {
        this.volume = this.volumeSlider._volume
        this.$emit('updated', this.volume)
      }
    }
  },
  mounted () {
    class VolumeSlider {
      constructor () {
        this.slider = document.getElementById('volume-slider')
        this.icon = document.getElementById('volume-icon')
        this.indicator = document.getElementById('volume-indicator')
        this.shape = document.getElementById('circle-mask-shape')
        // this.input     = this.$refs.volumeInput;
        this.input = document.getElementById('volume-input')

        this._lock = false
        this._charging = false
        this._charge = 0
        this._volume = 0

        this.input.value = this._volume

        this.icon.addEventListener('mousedown', () => { this.charge() })
        this.icon.addEventListener('mouseup', () => { this.release(this._charge) })
        this.icon.addEventListener('touchstart', () => { this.charge() })
        this.icon.addEventListener('touchend', () => { this.release(this._charge) })
      }

      /**
     * Begin charge cycle
     */
      charge () {
        if (this._lock) { return false }
        this._lock = true

        // Reset
        this._charge = 0
        this._charging = true

        // Hide indicator
        this.indicator.style.visibility = 'hidden'
        this.indicator.style.opacity = '0'

        /**
       * Charge loop
       */
        let cycle = () => {
          if (this._charging && ++this._charge < 100) {
            requestAnimationFrame(() => {
              cycle()
            })
          }

          // Update icon styles
          this.shape.style.transform = `scale(${this._charge / 100})`
          this.icon.style.transform = `rotate(${-0.35 * this._charge}deg)`
        }

        setTimeout(() => cycle(), 100)
      }

      /**
     * Release and fire based on charge
     * @param  {float} charge
     */
      release (charge) {
      // Reset charge animation
        this._charging = false
        requestAnimationFrame(() => { this.shape.style.transform = `scale(0)` })

        // Animation vars
        let y_cap = charge * 0.35

        let y_start = -0.3 * charge

        let x_cap = charge

        let x_start = -10

        let duration = 20 + (4 * charge)

        let start = new Date().getTime()

        let volume = this._volume

        let rotate

        // Y animation
        let y_swap = duration * 0.55

        let y_duration_up = y_swap

        let y_duration_down = duration - y_swap

        let y = y_start

        let y_diff_up = -y_cap

        let y_diff_down = (y_cap - y_start)

        // X animation
        let x = x_cap

        let x_diff = x_cap - 10

        // Display indicator
        this.indicator.style.visibility = 'visible'
        this.indicator.style.opacity = '1'

        /**
       * Animation loop
       */
        let animate = () => {
          let elapsed = new Date().getTime() - start

          if (elapsed < duration) {
          // Animate
            requestAnimationFrame(() => { animate() })

            if (elapsed < y_duration_up) {
            // Y up
              y = this.easeOut(elapsed, y_start, y_diff_up, y_duration_up)
            } else {
            // Y down
              y = this.easeIn(elapsed - y_duration_up, y_start - y_cap, y_diff_down, y_duration_down)
            }

            // Set values
            x = this.linearTween(elapsed, 0, x_diff, duration)
            rotate = this.easeInOut(elapsed, -0.35 * this._charge, 0.35 * this._charge, duration)
            this._volume = this.easeOut(elapsed, volume, charge - volume, duration)
          } else {
          // End of animation
            this._lock = false

            // Set values
            x = x_cap
            y = 0
            rotate = 0
            this._volume = charge
          }

          // Render values
          this.icon.style.transform = `rotate(${rotate}deg)`
          this.indicator.style.transform = `translateX(${x}px) translateY(${y}px)`
          this.input.value = this._volume
        }
        animate()
      }

      /**
     * Linear progression
     */
      linearTween (t, b, c, d) {
        return c * t / d + b
      }

      /**
     * Cubic ease-in progression
     */
      easeIn (t, b, c, d) {
        t /= d
        return c * t * t * t + b
      }

      /**
     * Cubic ease-out progression
     */
      easeOut (t, b, c, d) {
        t /= d
        t--
        return c * (t * t * t + 1) + b
      }

      /**
     * Cubic ease-in-out progression
     */
      easeInOut (t, b, c, d) {
        t /= d / 2
        if (t < 1) {
          return c / 2 * t * t * t + b
        }
        t -= 2
        return c / 2 * (t * t * t + 2) + b
      }
    }

    this.volumeSlider = new VolumeSlider()
    this.$nextTick(function () {
      window.setInterval(() => {
        this.update()
      }, 100)
    })
  }
}
</script>

<style scoped>
    body {
        background: #f9f9f9;
    }
    #volume-slider {
        align-items: center;
        display: flex;
        margin: 3em auto;
        padding: 15px 0;
        width: 132px;
    }
    .volume-icon {
        cursor: pointer;
        height: 30px;
        transform: rotate(0deg);
        transform-origin: center left;
        width: 30px;
    }
    .volume-icon .volume-icon-bg {
        fill: #cbc8ce;
        transition: fill 300ms;
    }
    .volume-icon:hover .volume-icon-bg {
        fill: #b6aebf;
    }
    #circle-mask-shape {
        transform: scale(0);
        transform-origin: center center;
    }
    .volume-track {
        background-color: #e1dee5;
        border-radius: 2px;
        flex: 1;
        height: 2px;
        margin-left: 2px;
        position: relative;
    }
    .volume-indicator {
        background-color: #6e33a5;
        border-radius: 50%;
        height: 6px;
        left: 0;
        position: absolute;
        top: -2px;
        transition: visibility 100ms, opacity 100ms;
        width: 6px;
    }

</style>
