<template>
    <div>
        <ph-button size="large" @click.native="$modal.show('modal-upload')" v-if="!loading && releases.data.length && app.user.account_verified">Upload</ph-button>

        <div class="release-wrapper" v-if="releases.data.length">
            <release v-for="release in releases.data" :key="release.id" :release="release" />

            <div style="margin: 4em 0" class="centered-text" v-if="hasAnotherPage && releases.data.length">
                <ph-button size="large" @click.native="loadNextPage" :loading="loadingNextPage">
                    Show Me More
                </ph-button>
            </div>
        </div>

        <div style="margin: 4em 0" class="centered-text" v-if="!loading && !releases.data.length">
              <h2>No Releases Yet</h2>
              <ph-button 
                  size="large" 
                  v-if="!app.user.stripe_account_id || !app.user.approved_at"
                  v-tooltip.top="{ content: 'Complete verification in your account section'  }"
                  @click.native="$modal.show('modal-upload')"
                  :disabled="true"
                  :style="'opacity:0.5;display:block;'"
                >
                  Create Release
              </ph-button>
              <ph-button v-else
                  size="large" 
                  @click.native="$modal.show('modal-upload')"
                  :style="'display:block;'"
                >
                  Create Release
              </ph-button>
        </div>
        <div v-if="loading || loadingNextPage">
            <spinner style="margin: 3em auto;"
                     :animation-duration="1000"
                     :size="60"
                     :color="'black'"
            />
        </div>
    </div>
</template>

<script>
    import { HalfCircleSpinner as Spinner } from 'epic-spinners';
    import { mapGetters, mapState } from 'vuex';
    import Menu from '../account-menu';
    import PhButton from "global/ph-button";
    import TrackList from 'global/track-list';
    import { UserEvents } from "events";
    import Release from './release'

    export default {
        data () {
            return {
              loadingNextPage: false,
              loading: false,
            }
        },

      computed: {
          ...mapGetters({
            'releases': 'app/getUsersReleases',
            'hasAnotherPage' :'app/releasesHasAnotherPage',
          }),
          ...mapState(['app'])
      },

        mounted: function() {
          UserEvents.$emit('updateTitle', 'My Releases')
          this.loading = true;
          this.$store.dispatch('app/fetchUsersReleases')
              .finally(() => {
                  this.loading = false;
              });
        },

        methods: {
          loadNextPage: function() {
            this.loadingNextPage = true;
            this.$store.dispatch('app/fetchUsersReleases').then(() => {
              this.loadingNextPage = false;
            });
          },
        },

        components: {
          Release,
            'account-menu': Menu,
            TrackList,
            PhButton,
            Spinner,
        }
    }
</script>

<style lang="scss" scoped>
.release-wrapper {
    padding-top: 50px;
}
</style>