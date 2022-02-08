<template>
  <div class="page-content-padded page-news-index">
    <div class="page-main">
      <div v-if="release">
        <h2>Tracks for sample {{ release.name }}</h2>

        <div v-if="release.tracks.length">
          <div v-for="item in release.tracks" :key="item.id">
            <music-item :item="item"></music-item>
          </div>
        </div>
        <div v-else>
          No Tracks for this sample.
        </div>
      </div>

      <spinner style="margin: 3em auto;" v-else
        :animation-duration="1000"
        :size="80"
        color="black"
      />
    </div>

    <aside class="sidebar-right">
      <sidebar-group title="News" :items="news.articles.slice(0, 5)"></sidebar-group>
    </aside>
  </div>
</template>

<script>
    import { mapState } from 'vuex';
    import SidebarGroup from 'global/sidebar-group';
    import MusicItem from '../new-music/music-item';
    import { HalfCircleSpinner as Spinner } from 'epic-spinners'

    export default {
        data () {
            return {
                release: '',
            }
        },
        // beforeRouteEnter (to, from, next) {
        //   this.fetchRelease().then(() => {
        //     next();
        //   });
        // },
        mounted: function() {
            this.fetchRelease();
        },
        computed: {
          ...mapState([
              'app',
              'news'
          ]),
        },
        methods: {
            fetchRelease() {
                axios.get('/api/release/' + this.$route.params.releaseid).then(response => {
                    this.release = response.data;
                });
            }
        },
        components: {
            SidebarGroup,
            MusicItem,
            Spinner,
        }
    }
</script>

<style lang="scss" scoped>

</style>
