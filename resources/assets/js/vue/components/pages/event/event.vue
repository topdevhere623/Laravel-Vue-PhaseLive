<template>
    <div class="page-content-padded page-event-view">
        <div class="page-main">
          <h1>Event</h1>
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
  import store from 'store';

  export default {
    name: 'PageEvent',
    components: {
      SidebarGroup,
      Spinner
    },
    data () {
      return {
      }
    },
    computed: mapState([
      // 'app',
      'news',
    ])
  }
</script>

<style lang="scss">
  // @import "~styles/helpers/_variables.scss";
</style>
