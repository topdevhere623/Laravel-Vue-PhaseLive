<template>
    <div class="p-item" :style="`background: ${backgroundColor}`">
        <div class="p-item-image">
            <router-link
                    :to="getRouterObject(mutableTrack)"
            >
                <avatar :size="130"
                        :tile="true"
                        :src="mutableTrack.release.image.files.medium.url"
                />
            </router-link>
        </div>
        <div class="p-item-main">
            <div class="p-item-detail">
                <div class="p-item-title">
                    <router-link
                            :to="getRouterObject(mutableTrack)"
                            style="text-decoration: none;"
                    >
                        <span>{{ mutableTrack.name }}</span>
                    </router-link>
                    <play-pause-button :track="item.track" type="streamable"></play-pause-button>
                </div>
                <div class="p-item-subtitle">
                    {{ mutableTrack.release.uploader.name }}
                </div>
                <social-sharing url="https://phase.test/"
                                :title="`I have just purchased new music ${mutableTrack.name} by ${mutableTrack.release.uploader.name}`"
                                description=""
                                :quote="`I have just purchased new music ${mutableTrack.name} by ${mutableTrack.release.uploader.name}`"
                                hashtags="phase,music"
                                twitter-user="phase"
                                inline-template>
                    <div class="mt-4 social-share">
                        <network network="facebook">
                            <i class="fab fa-facebook"></i>
                        </network>
                        <network network="twitter">
                            <i class="fab fa-twitter"></i>
                        </network>
                    </div>
                </social-sharing>
            </div>
            <div>
                <a :href="`/api/mymusic/download/mp3/${mutableTrack.id}`" title="Download Track" v-if="item.count < 5">
                    <i class="fas fa-download"></i>
                </a>
                <span v-else>You have reached your download limit</span>
            </div>
        </div>
    </div>
</template>

<script>
  import PlayPauseButton from '../../../global/play-pause-button.vue'

  export default {
    name: 'my-music-track',

    props: {
      item: {
        required: true
      },
      background: {}
    },

    data () {
      return {
        moment: window.moment,
        mutableTrack: this.item.track,
      }
    },

    computed: {
      formattedDate() {
        return moment(this.release.release_date).format('DD/MM/YYYY')
      },
      backgroundColor() {
        if (this.background) {
          return '#e6e6e6'
        } else {
          return '#fff'
        }
      }
    },

    components: {
      PlayPauseButton
    }
  }
</script>

<style lang="scss" scoped>

  .p-item{
    @media(max-width: 370px){
      display: grid;
      height: auto;
    }
  }
  .p-item-image{
    @media(max-width: 414px){
      margin-right: 0.5em;
    }

  }

  .p-item-main {
    flex-direction: row;

    @media(max-width: 370px){
      padding-top: 1em;
    }

  }
  .mt-4 {
    margin-top: 1em;
  }
  .social-share .svg-inline--fa {
    cursor: pointer;
  }
</style>
