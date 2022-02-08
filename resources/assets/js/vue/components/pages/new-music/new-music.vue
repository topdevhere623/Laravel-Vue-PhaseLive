<template>
  <div class="page-content-padded page-news-index">
    <div class="page-main">
      <div class="pad-sides" v-if="music.items.length">
        <div v-for="item in music.items" :key="item.id">
          <music-item :item="item"></music-item>
        </div>
      </div>

      <spinner style="margin: 3em auto;" v-else
        :animation-duration="1000"
        :size="80"
        color="black"
      />

      <div style="margin: 4em 0" class="centered-text" v-if="hasAnotherPage && music.items.length">
        <ph-button size="large" @click.native="loadNextPage" :loading="loadingNextPage">
          Show Me More
        </ph-button>
      </div>
    </div>

    <aside class="sidebar-right">
      <sidebar-group title="News" :items="news.articles.slice(0, 5)"></sidebar-group>
      <sidebar-group title="Merch" :items="merch.items.slice(0, 5)"></sidebar-group>
    </aside>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';
import store from 'store';
import { HalfCircleSpinner as Spinner } from 'epic-spinners'
import SidebarGroup from 'global/sidebar-group';
import MusicItem from './music-item';
import PhButton from 'global/ph-button';

export default {
  data() {
    return {
      loadingNextPage: false,
    }
  },

  components: {
    SidebarGroup,
    Spinner,
    MusicItem,
  },

  computed: {
    ...mapState([
      'news',
      'merch',
      'music'
    ]),
    ...mapGetters('music', [
      'hasAnotherPage',
    ])
  },

  beforeRouteEnter (to, from, next) {
    store.dispatch('music/fetchMusic').then(() => {
      next();
    });
  },

  methods: {
    loadNextPage: function() {
      this.loadingNextPage = true;
      store.dispatch('music/fetchMusic').then(() => {
        this.loadingNextPage = false;
      });
    }
  },
}
</script>

<style scoped>
.pad-sides {
  padding: 0 30px;
}
</style>
