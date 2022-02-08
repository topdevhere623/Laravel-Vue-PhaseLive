<template>
  <div class="page-content-padded page-news-index">
    <div class="page-main">
      <div class="genres">
        <div class="genres-container">
          <div
            v-for="(genre, index) in app.genres"
            :key="genre.name"
            class="genre"
          >
            <genre-logo :genre="genre" />
          </div>
        </div>
      </div>
    </div>

    <aside class="sidebar-right">
      <sidebar-group
        title="News"
        :items="news.articles.slice(0, 5)"
      ></sidebar-group>
    </aside>
  </div>
</template>

<script>
import { mapState } from "vuex";
import SidebarGroup from "global/sidebar-group";
import store from "store";

export default {
  components: { SidebarGroup },

  computed: mapState(["app", "news"]),

  beforeRouteEnter(to, from, next) {
    store.dispatch("app/fetchGenres").then(() => {
      next();
    });
  },
};
</script>

<style lang="scss" scoped>
.page-content-padded {
  overflow: hidden;
}

.genres {
  margin-bottom: 2em;
  padding: 0 1em;
  box-sizing: border-box;
  @media (max-width: 700px) {
    padding: 0 2em 0 0;
  }
}
.genres-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  margin: 0 -1em;
}
.genre {
  height: 200px;
  width: 200px;
  padding: 1em;
  position: relative;
  &:after {
    content: "";
    display: block;
    padding-bottom: 100%;
  }

  .genre-name {
    font-weight: bold;
    text-transform: uppercase;
    font-size: 16px;
    text-align: center;
  }
  .genre-bg {
    height: 100%;
    width: 100%;
    background-size: auto;
    background-position: center;
    background-repeat: no-repeat;
  }
}
</style>
