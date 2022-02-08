<template>
    <div class="page-content-padded page-discover-index">
        <div class="page-main">
            <masonry-grid v-if="app.feed.length" v-bind:feed_items="app.feed"/>
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
  import { HalfCircleSpinner as Spinner } from 'epic-spinners'
  import SidebarGroup from 'global/sidebar-group';
  import MasonryGrid from 'global/feed/masonry-grid';
  import store from 'store';

  export default {
    components: {
      SidebarGroup,
      Spinner,
      MasonryGrid
    },
    data () {
      return {
        loadedAll: false,
      }
    },
    computed: mapState([
      'app',
      'news',
    ]),
    created: function() {
      this.fetchFeed()
    },
    methods: {
      fetchFeed() {
        store.dispatch('app/fetchFeed')
          .then(() => {
            this.loadedAll = true
          });
      }
    },
  }
</script>
