<template>
    <span class="fa-layers fa-fw player-control" @click="togglePlayback">
        <span>
            <i class="fa fa-fw fa-circle" :data-fa-transform="'grow-' + size"></i>
        </span>
        <span v-show="!playing">
            <i class="fa fw-fw fa-play" :data-fa-transform="'shrink-' + (size / 8 + 3)" style="color:white"></i>
        </span>
        <span v-show="playing">
            <i class="fa fw-fw fa-pause" :data-fa-transform="'shrink-' + (size / 8 + 3)" style="color:white"></i>
        </span>
    </span>
</template>

<script>
  import { PlayerEvents } from 'events'

  export default {
    props: {
      track: {
        type: Object,
        required: true,
      },
      size: {
        type: Number,
        default: 7,
      },
      type: {
        type: String,
        default: 'preview',
      },
    },
    data() {
      return {}
    },
    computed: {
      playing: function () {
        return (this.$store.state.player.status.playing && this.thisTrackisLoaded())
      },
    },
    created: function () {

    },
    methods: {
      thisTrackisLoaded() {
        return this.$store.state.player.track.id === this.track.id
      },
      togglePlayback() {
        if (!this.thisTrackisLoaded()) {
            if (this.$store.state.app.user.id !== -1) {
                axios.post('/api/user/track', {
                    user: this.$store.state.app.user.id,
                    track: this.track,
                })
            }
          PlayerEvents.$emit('setTrack', {
            track: this.track,
            type: this.type,
          })
        }
        PlayerEvents.$emit('setTogglePlayback')
      },
    },
    components: {},
  }
</script>

<style lang="scss" scoped>
    .player-control {
        cursor: pointer;

        span:first-child {
            color: #0039ff;
        }

        span:last-child {
            color: white;
        }
    }
</style>
