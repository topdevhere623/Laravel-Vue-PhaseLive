<template>
  <div>
    <home-hero/>

    <div class="page-content-padded" style="height:auto;">
      <div class="page-main">
        <home-featured
            :featured-items="featuredItems"
            v-if="featuredItems.length"
        />

        <div>
          <h1>Latest News</h1>
          <home-latest-news
              :latest-news="news.articles.slice(0, 6)"
          ></home-latest-news>
        </div>
        <div>
          <h1>Charts</h1>
          <home-charts :chart-items="chartItems"/>
        </div>
        <div>
          <h1>Latest Releases</h1>
          <home-latest-releases
              :latest-releases="app.releases.slice(0, 3)"
          />
        </div>
        <div>
          <h1>Genres</h1>
          <home-genres :genres="app.genres.slice(0, 5)"/>
        </div>

        <div class="home-banner" v-if="!app.user.loggedin">
          <overlay/>
          <div class="hero-content">
            <h1>Ready to join phase? It's free!</h1>
            <ph-button
                color="white"
                size="giant"
                @click.native="showAuthModal()"
            >
              <h2>Register</h2>
              <p>
                Find Out More
              </p>
            </ph-button>
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
    <div class="home-banner-push" v-if="!app.user.loggedin"></div>
  </div>
</template>

<script>
import {mapState} from "vuex";
import SidebarGroup from "global/sidebar-group";
import PhButton from "global/ph-button";
import HomeHero from "./home-hero";
import HomeFeatured from "./home-featured";
import HomeLatestNews from "./home-latest-news";
import HomeLatestReleases from "./home-latest-releases";
import HomeCharts from "./home-charts";
import HomeGenres from "./home-genres";
import Overlay from "../../global/overlay";

export default {
  props: ["featured-items", "chart-items"],
  computed: {
    ...mapState(["app", "news"])
  },
  methods: {
    showAuthModal: function () {
      this.$modal.show("modal-auth-register");
    }
  },
  components: {
    PhButton,
    SidebarGroup,
    HomeHero,
    HomeFeatured,
    HomeLatestNews,
    HomeLatestReleases,
    HomeCharts,
    HomeGenres,
    Overlay
  }
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";

/**
 * Home Banner
 */
.home-banner {
  height: 500px;
  width: 100%;
  position: absolute;
  left: 0;
  top: 100%;
  background: url("~/img/new-banner.jpg");
  background-size: cover;
  background-position: 0 25%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;

  .hero-content {
    padding: 0 20px;
    z-index: 20;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
}

.home-banner-push {
  height: 500px;
}
</style>
