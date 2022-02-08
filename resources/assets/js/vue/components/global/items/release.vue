<template>
    <div class="p-item">
        <div class="p-item-image">
            <router-link
                :to="getRouterObject(release)">
               <avatar :size="130"
                    :src="release.image.files.thumb.url"
                    :tile="true"
                    :recent="release.is_recent"
                />
            </router-link>

        </div>
        <div class="p-item-main">
            <div class="p-item-detail">
                <div class="p-item-title">
                    <router-link
                        :to="getRouterObject(release)"
                        style="text-decoration: none;">
                        <span>{{ release.name }}</span>
                    </router-link>
                </div>
            </div>
            <div class="release-description">
                {{ release.description }}
            </div>

          <div class="tracks" v-if="release.tracks">
            <div class="track flex" v-for="(track, index) in release.tracks">
              <div class="flex-1">
                <div class="track-image">
                  <img v-if="track.image" :src="track.image.files.medium.url" :alt="track.image.alt">
                </div>
                <div>
                  {{ index + 1 }} - {{ track.name }}
                  <play-pause-button :track="track" type="preview"></play-pause-button>
                </div>
              </div>
            </div>
          </div>

            <div class="p-item-meta">
                <actions :actionable="release"></actions>
                <div class="p-item-time">
                    {{ moment(release.release_date).fromNow() }}
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import Actions from 'global/actions/actions';
    import ActionMenu from 'global/actions/action-menu';
    import Avatar from 'global/avatar';
    import AvatarTrack from "global/avatar-track";
    import PlayPauseButton from "global/play-pause-button";

    export default {
        props: {
            release: {
                type: Object,
                required: true,
            }
        },
        data () {
            return {
                moment: window.moment,
              tracks: null,
            }
        },
        created: function() {
        //   this.getReleaseTracks();
        },
        methods: {
        //   getReleaseTracks : function()
        //   {
        //     window.axios.get('/api/release/'+this.release.id+'/tracks').then(response => {
        //       let responseData = response.data;
        //       this.tracks = responseData.tracks;
        //     })
        //   }
        },
        components: {
            Actions,
            ActionMenu,
            Avatar,
            AvatarTrack,
            PlayPauseButton
        }
    }
</script>

<style lang="scss" scoped>


    .p-item{

        @media(max-width: 768px){
            padding: 0px;
        }

        @media(max-width: 500px){
            flex-direction: column;
            margin-top: 1em;
            height: auto;

            .p-item-image{
                align-self: flex-start;
            }
        }
    }

    .release-description {
        flex: 1;
        font-size: 14px;
        padding: 20px 0;

        @media(max-width: 375px){
            font-size: 12px;
        }

        @media(max-width: 340px){
            font-size: 11px;
        }
    }
    .item-title {
        font-size: 19px;
    }
    .item-main {
        justify-content: flex-start;
    }

    .tracks
    {
      margin-bottom: 10px;
    }
</style>
