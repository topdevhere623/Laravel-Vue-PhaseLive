<template>
  <div class="page-content-padded page-news-index">
    <div class="page-main">
      <h1 class="no-top centered-text">News</h1>
      <nav class="sub-nav">
        <ul class="centered-text">
          <li :class="{ active: !category }">
            <router-link to="/news">All</router-link>
          </li>
          <li
            v-for="categoryli in news.categories"
            :class="{ active: '/' + category === categoryli.path }"
          >
            <router-link :to="'/news' + categoryli.path">{{
              categoryli.title
            }}</router-link>
          </li>
        </ul>
      </nav>
      <div v-if="!news.articles.length">
        <spinner
          style="margin: 5em auto"
          :animation-duration="1000"
          :size="100"
          color="black"
        />
      </div>
      <div class="articles">
        <div class="article" v-for="article in news.articles">
          <news-article :data="article" :items="[]"></news-article>
        </div>
      </div>
      <div
        style="margin: 4em 0"
        class="centered-text"
        v-if="hasAnotherPage && news.articles.length"
      >
        <ph-button
          size="large"
          @click.native="loadNextPage"
          :loading="loadingNextPage"
        >
          Show Me More
        </ph-button>
      </div>
    </div>
    <!-- <aside class="sidebar-right">
            <sidebar-group title="News" :items="news.articles.slice(0, 5)"></sidebar-group>
        </aside> -->
  </div>
</template>

<script>
import { mapState } from "vuex";
import { mapGetters } from "vuex";
import { HalfCircleSpinner as Spinner } from "epic-spinners";
import store from "store";

import SidebarGroup from "global/sidebar-group";
import NewsArticle from "./article";
import PhButton from "global/ph-button";

export default {
  props: ["category"],
  data() {
    return {
      //variables: window.variables,
      loadingNextPage: false,
    };
  },
  computed: {
    ...mapState(["news"]),
    ...mapGetters("news", ["hasAnotherPage"]),
  },
  beforeRouteEnter(to, from, next) {
    store
      .dispatch("news/fetchCategories")
      .then(() => {
        store.dispatch("news/requireArticles", to.params.category);
      })
      .then(() => {
        next();
      });
  },
  beforeRouteUpdate(to, from, next) {
    store.dispatch("news/requireArticles", to.params.category).then(() => {
      next();
    });
  },
  methods: {
    loadNextPage: function () {
      this.loadingNextPage = true;
      store
        .dispatch("news/fetchArticles", this.$route.params.category)
        .then(() => {
          this.loadingNextPage = false;
        });
    },
  },
  components: {
    Spinner,
    SidebarGroup,
    NewsArticle,
    PhButton,
  },
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";
.page-news-index {
  .articles {
    overflow: auto;

    .article {
      lost-column: 1/3; // 3 40px;

      .news-index-article {
        width: 100%;
        min-height: 100%;
      }
    }
  }
}
</style>
