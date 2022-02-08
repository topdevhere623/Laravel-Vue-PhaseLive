<template>
  <div>
    <notifications
        group="main"
        position="top center"
        classes="vue-notification-phase"
        width="400px"
    />
    <vue-snotify/>
    <modals/>
    <div
        class="body"
        id="page-content"
        :class="{ 'slideout-open': slideoutActive }"
    >
      <div class="page">
        <aside class="main-left" :class="{ searching: search.visible }">
          <main-left @slideoutToggle="toggleSlideout"/>
        </aside>
        <main class="viewport" style="min-height: 100vh">
          <top-bar
              @slideoutToggle="mobileSlideoutActivte = !mobileSlideoutActivte"
          />
          <user-bar v-if="app.user.loggedin || $route.path !== '/'"/>
          <!-- <transition-group mode="out-in" style="flex: 1"> -->
          <search-view v-if="search.visible" key="search-view"/>
          <router-view v-show="!search.visible" key="router-view"/>
          <!-- </transition-group> -->
          <vue-progress-bar/>
        </main>
        <aside
            class="main-right"
            v-if="app.user.loggedin || search.visible"
            :class="{ searching: search.visible }"
        >
          <main-right/>
        </aside>
      </div>
      <main-footer/>

      <slideout-menu
          @slideoutToggle="toggleSlideout"
          v-if="slideoutActive"
      />
      <mobile-slideout-menu
          @slideoutToggle="mobileSlideoutActivte = !mobileSlideoutActivte"
          v-if="mobileSlideoutActivte"
      />
    </div>
  </div>
</template>

<script>
import {mapState} from "vuex";
import Modals from "./modals/container";
import SlideoutMenu from "./layout/slideout-menu";
import MobileSlideoutMenu from "./layout/mobile-slideout-menu.vue";
import TopBar from "./layout/top-bar";
import UserBar from "./layout/user-bar";
import SearchView from "./pages/search/search-view";
import MainLeft from "./layout/main-left";
import MainRight from "./layout/main-right";
import MainFooter from "./layout/main-footer";
import {MessageEvents} from "../event-bus";

export default {
  data() {
    return {
      slideoutActive: false,
      mobileSlideoutActivte: false,
    };
  },

  components: {
    Modals,
    SlideoutMenu,
    TopBar,
    UserBar,
    SearchView,
    MainLeft,
    MainRight,
    MainFooter,
    MobileSlideoutMenu,
  },
  computed: {
    ...mapState(["search", "messenger", "app"]),
    homeClass() {
      if (this.$route.path === "/" && !this.app.user.loggedin) {
        return "pull-up";
      }
      return "";
    },
  },

  mounted() {
    //  [App.vue specific] When App.vue is finish loading finish the progress bar
    this.$Progress.finish();
    this.notificationTracker();

    if (this.$route.query.showModal) {
      this.$modal.show(this.$route.query.showModal);
      this.$router.push({query: {}});
    }
  },

  methods: {
    notificationTracker() {
      let userId = this.$store.state.app.user.id;
      window.Echo.private(`App.User.${userId}`).notification((notification) => {
        let notificationTypeStringArray = notification.type.split("\\");
        let notificationType =
            notificationTypeStringArray[notificationTypeStringArray.length - 1];
        if (notificationType == "NewMessage") {
          MessageEvents.$emit("newMessage", notification.data);
        }

        let html = ``;
        if (notification.image) {
          html += `<div style="flex-grow: 1">
                            <img src="${notification.image}" style="width: 90px; height: 90px;"/>
                        </div>`;
        }
        html += `<div style="flex-grow: 5; padding: 7px; line-height: 1.1;">
                            <p style="font-size:20px;"><b>${notification.title}</b></p>
                            <p style="font-size: 13px; margin-top: 5px;">${notification.message}</p>
                        </div>
                        `;
        this.$snotify.html(html, {
          timeout: 5000,
          showProgressBar: true,
          closeOnClick: false,
          pauseOnHover: true,
        });
      });
    },
    toggleSlideout() {
      this.slideoutActive = !this.slideoutActive;

      const el = document.body;

      if (this.slideoutActive) {
        el.classList.add("slideout-open");
      } else {
        el.classList.remove("slideout-open");
      }
    },
  },
  created: function () {
    this.$store.dispatch("app/fetchNavigation");
    this.$store.dispatch("news/requireArticles");
    this.$store.dispatch("merch/requireMerch");
    this.$store.dispatch("app/fetchPlans");
    this.$store.dispatch("app/fetchPricePerFeaturedSlot");
    this.$store.dispatch("cart/load");

    if (window.user) {
      this.$store.commit("app/setUser", window.user);
    }
    if (window.settings) {
      this.$store.commit("app/setSettings", window.settings);
    }
    this.$store.commit(
        "app/setReleaseClasses",
        window.variables.release_classes
    );
    this.$store.commit("app/setMusicKeys", window.variables.music_keys);
    /*
     * Vue Progress Bar
     */
    //  [App.vue specific] When App.vue is first loaded start the progress bar
    this.$Progress.start();
    //  hook the progress bar to start before we move router-view
    this.$router.beforeEach((to, from, next) => {
      //  does the page we want to go to have a meta.progress object
      if (to.meta.progress !== undefined) {
        let meta = to.meta.progress;
        // parse meta tags
        this.$Progress.parseMeta(meta);
      }
      //  start the progress bar
      this.$Progress.start();
      //  continue to next page
      next();
    });
    //  hook the progress bar to finish after we've finished moving router-view
    this.$router.afterEach((to, from) => {
      //  finish the progress bar
      this.$Progress.finish();
    });

    this.$store.state.messenger.threads.forEach((thread) => {
      Echo.channel(`thread`).listen("ThreadEvent", (event) => {
        this.$store.commit("messenger/newMessageInThread", event);
      });
    });
  },
  watch: {
    // Hide the search view when changing routes
    $route: function (from, to) {
      this.$store.commit("search/toggleSearch", false);
    },

    "$store.state.messenger.threads": {
      handler: function () {
        this.$store.state.messenger.threads.forEach((thread) => {
          Echo.channel(`thread`).listen("ThreadEvent", (event) =>
              this.$store.commit("messenger/newMessageInThread", event)
          );
        });
      },

      deep: true,
    },
  },
};
</script>

<style lang="scss" scoped>
@media (max-width: 1000px) {
  .main-right,
  .main-left {
    display: none;
  }
}

.pull-up {
  margin-top: -80px;
}
</style>
