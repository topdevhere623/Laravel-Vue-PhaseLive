<template>
    <div style="margin-bottom: 20px;">
        <div class="release">
            <div class="release-info flex">
                <div class="release-image">
                    <span class="tag tag-left" :class="release.status">{{ release.status }}</span>
                    <img :src="release.image.files.medium.url" :alt="release.image.alt" width="130">
                    <span v-if="isNew" class="tag tag-right new">New</span>
                </div>
                <div class="release-details">
                    <div class="flex justify-between">
                        <div>
                            <router-link :to="{ name: 'release', params: { releaseid: release.slug }}">
                                <h2>{{ release.name }}</h2>
                            </router-link>
                            <p class="text-sm">{{ release.uploader.name }}</p>
                        </div>
                        <div v-if="release.tracks.length" class="play-button">
                           <play-pause-button :track="release.tracks[0]" :size="15" />
                        </div>
                        <div>
                            <span class="text-sm"><span class="text-blue">Release Date: </span> {{ formattedDate }}</span>
                        </div>
                        <div v-click-outside="() => contextMenu = false">
                            <span @click="contextMenu = !contextMenu"><i class="fa fa-ellipsis-h"></i></span>
                            <div v-show="contextMenu" style="position: relative;">
                                <ul class="context-menu">
                                    <router-link :to="{ name: 'account_stats'}">
                                        <li>Sales & Feedback</li>
                                    </router-link>
                                    <li v-if="release.status === 'live'" @click="updateStatus({release: release, status: 'offline'})">Take Offline</li>
                                    <li v-if="release.status === 'offline'" @click="updateStatus({release: release, status: 'live'})">Make Live</li>
                                    <li @click="removeRelease(release)">Delete</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="release-description flex text-xs">
                        <div style="width: 85%;">
                            <p><span class="text-blue">{{ release.class | capitalize }} description: </span> {{ release.description }}</p>
                        </div>
                        <ph-button class="button-responsive">{{ formattedPrice }}</ph-button>
                    </div>
                    <div class="text-xs text-blue tab-buttons">
                        <span
                            @click="changeTab('details')"
                            class="tabButton"
                        >
                            {{ release.class | capitalize }} details
                        </span>
                        <span
                            @click="changeTab('tracks')"
                            v-if="['album', 'compilation'].includes(release.class) && release.tracks.length"
                            class="tabButton"
                        >
                            Tracks
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="tabs text-sm" v-if="tabOpen">
            <div v-show="tab === 'details'" class="details">
                <!-- <span v-if="release.class === 'single'" class="details_item">
                    <strong>Format:</strong>
                </span> -->
                <span class="details_item">
                    <strong>Genres:</strong>
                    <span v-for="(genre, index) in release.genres" :key="index">
                        {{ genre.name }}<span v-if="release.genres[index + 1]">, </span>
                    </span>
                </span>
                <span v-if="release.class === 'single'" class="details_item">
                    <strong>Key:</strong> {{ release.tracks[0] && release.tracks[0].key }}
                </span>
                <span v-if="release.class === 'single'" class="details_item">
                    <strong>BPM:</strong> {{ release.tracks[0] && release.tracks[0].bpm }}
                </span>
                <span class="details_item">
                    <strong>Homepage Feature:</strong> {{ release.featured ? 'Featured' : 'Not featured' }}
                </span>
            </div>

            <track-list
                v-if="tab === 'tracks'"
                :tracks="release.tracks"
            />
        </div>
    </div>
</template>

<script>
    import { mapActions } from 'vuex'
  import PlayPauseButton from 'global/play-pause-button'
  import TrackList from 'global/track-list';
  import moment from 'moment'

  export default {
    name: 'release',

    data() {
      return {
        tab: 'details',
        tabOpen: false,
        contextMenu: false,
      }
    },

    props: {
      release: {
        required: true,
        type: Object,
      }
    },

    computed: {
      formattedPrice() {
        const formatter = new Intl.NumberFormat('en-GB', {
          style: 'currency',
          currency: 'GBP',
          minimumFractionDigits: 2,
        })

        return formatter.format(this.release.price / 100)
      },
      formattedDate() {
        return moment(this.release.release_date).format('DD/MM/YYYY')
      },
      isNew: {
          get: function () {
              return moment(this.release.release_date).isBetween(moment().subtract(7, 'days'), moment().add(2, 'days'))
          },
          set: function (newValue) {
              // return moment(this.release.release_date).isBetween(moment().subtract(7, 'days'), moment().add(2, 'days'))
          }
      }
    },

    methods: {
      ...mapActions({
        removeRelease: 'app/removeUserRelease',
        updateStatus: 'app/updateUserRelease'
      }),
      changeTab(tab) {
        if (this.tab === tab) {
          this.tabOpen = !this.tabOpen
        } else {
          this.tabOpen = true
        }

        this.tab = tab
      },
    },

    components: {
      PlayPauseButton,
      TrackList
    }
  }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";

    .release {
        background: $color-grey;
        padding: 20px;
    }

    .flex{
      @media(max-width: 550px){
        flex-direction: column;
      }
    }

    .release-image {
        position: relative;
    }
    .release-details {
        padding-left: 20px;
        margin-right: 5px;
        display: flex;
        justify-content: space-between;
        flex-direction: column;

        @media(max-width: 550px){
          padding-top: 14px;
          padding-left: 0px;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 10px;

            @media(max-width: 450px){
              font-size: 24px;
            }
        }
    }
    .release-description {
        padding-top: 20px;
    }

    .button-responsive{
      @media(max-width: 550px){
        padding: 16px 0px;
      }
    }

    .tabs {
        background: #f0f0f0;
        padding: 20px;
        margin-bottom: 20px;
    }
    .context-menu {
        position: absolute;
        background: #f0f0f0;
        padding: 10px;
        font-size: 12px;
        width: 115px;
        right: calc(100% - 17px);
        box-shadow: -2px 4px 10px rgba(0,0,0,0.3);
        z-index: 100;

        li {
            padding: 5px 0;
            cursor: pointer;
        }
    }
    .tag {
        font-size: 10px;
        text-transform: uppercase;
        padding: 2px 5px;
        border-radius: 10px;
        position: absolute;
        color: #fff;
    }
    .tag-left {
        top: 5px;
        left: -10px;
    }
    .tag-right {
        top: 5px;
        right: -10px;
    }
    .pending {
        background: #ff9933;
    }
    .live {
        background: #33cc99;
    }
    .offline {
        background: #818181;
    }
    .new {
        background: #818181;
    }
    .tabButton {
        margin-right: 30px;
        cursor: pointer;
    }
    .details {
        display: flex;
        flex-wrap: wrap;

        &_item {
            margin-right: 20px;
        }
    }
    .play-button {
        margin: 0px 12px;

        @media(max-width: 550px){
            margin: 12px 12px;
        }
    }
    .tab-buttons {
        margin-top: 12px;
    }
</style>
