<template>
    <div>
        <div class="release" :style="`background: ${backgroundColor}`">
            <div class="release-info flex">
                <div class="release-image">
                    <img :src="release.image.files.medium.url" :alt="release.image.alt">
                </div>
                <div class="release-details">
                    <div class="flex justify-between">
                        <div>
                            <router-link :to="{ name: 'release', params: { releaseid: release.slug }}">
                                <h2>{{ release.name }}</h2>
                            </router-link>
                            <p class="text-sm">{{ release.uploader.name }}</p>
                        </div>
                        <div>
                        </div>
                    </div>
                    <div class="release-description flex text-xs">
                        <div style="width: 85%;">
                            <p>{{ release.description }}</p>
                            <social-sharing url="https://phase.test/"
                                            :title="`I have just purchased new music ${release.name} by ${release.uploader.name}`"
                                            description=""
                                            :quote="`I have just purchased new music ${release.name} by ${release.uploader.name}`"
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
                    </div>
                </div>
            </div>
        </div>
        <div class="tracks">
            <div class="track flex" v-for="(track, index) in tracks">
                <div class="flex-1">
                    <div class="track-image">
                        <img v-if="track.image" :src="track.image.files.medium.url" :alt="track.image.alt">
                    </div>
                    <div>
                        {{ index + 1 }} - {{ track.name }}
                        <play-pause-button :track="track" type="streamable"></play-pause-button>
                    </div>
                </div>
                <div>
                    <a :href="`/api/mymusic/download/mp3/${track.id}`" title="Download Track" v-if="item[index].count < 5">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SocialSharing from 'vue-social-sharing'
    import PlayPauseButton from '../../../global/play-pause-button.vue'

  export default {
    name: 'my-music-release',

    data() {
      return {
        release: null,
        tracks: null,
      }
    },

    props: {
      item: {
        required: true
      },
      background: {}
    },

    created() {
      this.release = this.item[0].track.release
      this.tracks = []
      this.item.forEach(track => {
        this.tracks.push(track.track)
      })
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
    @import "~styles/helpers/_variables.scss";

    .release {
        padding: 20px;

        @media(max-width: 414px){
            padding: 0px;
        }
    }

    .release-info{
        @media(max-width: 370px){
            display: grid;
        }
    }

    .release-image {
        position: relative;
        img {
            height: 130px;
            width: 130px;
            object-fit: cover;
            border-radius: 5px;
        }

        @media(max-width: 370px){
            padding-bottom: 1em;
        }
    }
    .release-details {
        padding-left: 20px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        flex-direction: column;
        h2 {
            margin-top: 0;
            margin-bottom: 10px;

            @media(max-width: 414px){
                font-size: 20px;
            }
        }

        @media(max-width: 370px){
            padding-left: 0px;
        }
    }
    .release-description {
        padding-top: 20px;
    }
    .context-menu {
        position: absolute;
        background: #f0f0f0;
        padding: 10px;
        font-size: 12px;
        width: 115px;
        li {
            padding: 5px 0;
            cursor: pointer;
        }
    }
    .tracks {
        padding-top: 15px;
        padding-left: 30px;
        padding-right: 18px;
    }
    .track-image {
        position: relative;
        img {
            height: 60px;
            width: 60px;
            object-fit: cover;
        }
    }
    .track {
        margin-bottom: 15px;
    }
    .flex-1 {
        flex-grow: 1;
    }
    .mt-4 {
        margin-top: 1em;
    }
    .social-share .svg-inline--fa {
        cursor: pointer;
    }
</style>
