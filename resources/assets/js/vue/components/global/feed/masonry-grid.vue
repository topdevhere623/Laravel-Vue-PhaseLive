<template>
  <section class="masonry-section">
    <div>
      <form action="#" method="GET" name="gridfilter" class="w-full gridfilter clearboth mx-0 px-0">
        <ul class="gridfilter_list list-unstyled list-inline float-left">
          <li>
            <label v-bind:class="[selectedCategory === 'all' ? 'active' : '']">
              <input type="radio" v-model="selectedCategory" value="all">All
            </label>
          </li>
          <li>
            <label v-bind:class="[selectedCategory === 'release' ? 'active' : '']">
              <input type="radio" v-model="selectedCategory" value="release">Releases
            </label>
          </li>
          <li>
            <label v-bind:class="[selectedCategory === 'track' ? 'active' : '']">
              <input type="radio" v-model="selectedCategory" value="track">Tracks
            </label>
          </li>
          <li v-if="$can('upload videos')">
            <label v-bind:class="[selectedCategory === 'video' ? 'active' : '']">
              <input type="radio" v-model="selectedCategory" value="video">Videos
            </label>
          </li>
          <li v-if="$can('add events')">
            <label v-bind:class="[selectedCategory === 'event' ? 'active' : '']">
              <input type="radio" v-model="selectedCategory" value="event">Events
            </label>
          </li>
          <li v-if="$can('add merch')">
            <label v-bind:class="[selectedCategory === 'merch' ? 'active' : '']">
              <input type="radio" v-model="selectedCategory" value="merch">Merch
            </label>
          </li>
          <li>
            <label v-bind:class="[selectedCategory === 'post' ? 'active' : '']">
              <input type="radio" v-model="selectedCategory" value="post">Posts
            </label>
          </li>
          <li>
            <label v-bind:class="[selectedCategory === 'genre' ? 'active' : '']">
              <input type="radio" v-model="selectedCategory" value="genre">Genres
            </label>
          </li>
<!--          <li>-->
<!--            <label v-bind:class="[selectedCategory === 'playlist' ? 'active' : '']">-->
<!--              <input type="radio" v-model="selectedCategory" value="playlist">Playlists-->
<!--            </label>-->
<!--          </li>-->
        </ul>
        <div class="float-right gridfilter_list_count">{{ filteredItemCount }}</div>
      </form>
    </div>
    <div id="masonry-container" v-bind:class="[gridLoaded ? 'showGrid' : '']">
      <component
        :is="item.component"
        v-for="item in filteredGrid"
        :key="item.id + item.component"
        :item="item"
      />
    </div>
  </section>
</template>

<script>
  import Macy from "macy";

  import FeedEvent from "global/feed/feed-event";
  import FeedGenre from "global/feed/feed-genre";
  import FeedMerch from "global/feed/feed-merch";
  import FeedPlaylist from "global/feed/feed-playlist";
  import FeedPost from "global/feed/feed-post";
  import FeedRelease from "global/feed/feed-release";
  import FeedTrack from "global/feed/feed-track";
  import FeedVideo from "global/feed/feed-video";

  export default {
    props: { feed_items: Array },
    components: {
      FeedEvent,
      FeedGenre,
      FeedMerch,
      FeedPlaylist,
      FeedPost,
      FeedRelease,
      FeedTrack,
      FeedVideo
    },
    data() {
      return {
        selectedCategory: "all",
        requiresRefresh: false,
        gridLoaded: false
      };
    },
    computed: {
      filteredGrid: function() {
        var vm = this;
        var category = vm.selectedCategory;

        if (category === "all") {
          return vm.feed_items;
        } else {
          return vm.feed_items.filter(function(feed) {
            return feed.type === category;
          });
        }
      },
      filteredItemCount: function() {
        return this.filteredGrid.length;
      }
    },
    watch: {
      filteredGrid: function(newVal, oldVal) {
        this.requiresRefresh = true;
      }
    },
    updated: function() {
      if (this.requiresRefresh) {
        this.masonryGridInstance.recalculate(true);
      }
    },
    mounted: function() {
      this.$nextTick(function() {
        // https://github.com/bigbite/macy.js
        this.masonryGridInstance = Macy({
          container: "#masonry-container",
          trueOrder: false,
          waitForImages: true,
          margin: 10,
          columns: 3,
          breakAt: {
            1200: 3,
            940: 2,
            520: 2,
            400: 1
          }
        });

        this.masonryGridInstance.on(
          this.masonryGridInstance.constants.EVENT_RECALCULATED,
          function(ctx) {
            // console.log("EVENT_RECALCULATED");
            ctx.requiresRefresh = false;
          }
        );

        // Event Reference - these can be removed.
        // this.masonryGridInstance.on(
        //   this.masonryGridInstance.constants.EVENT_INITIALIZED,
        //   function(ctx) {
        //     console.log("EVENT_INITIALIZED");
        //   }
        // );

        // this.masonryGridInstance.on(this.masonryGridInstance.constants.EVENT_IMAGE_LOAD, function(
        //   ctx
        // ) {
        //   console.log("EVENT_IMAGE_LOAD");
        // });

        // this.masonryGridInstance.on(
        //   this.masonryGridInstance.constants.EVENT_IMAGE_COMPLETE,
        //   this.showGrid()
        // );

        // this.masonryGridInstance.on(this.masonryGridInstance.constants.EVENT_RESIZE, function(
        //   ctx
        // ) {
        //   console.log("EVENT_RESIZE");
        // });
      });
    }
  };
</script>

<style lang="scss">
  @import "~styles/helpers/_variables.scss";

  #masonry-container::before,
  #masonry-container::after,
  .clearfix::after,
  .clearfix::before,
  .masonry-inner::before,
  .masonry-inner::after {
    content: "";
    display: table;
    clear: both;
  }

  .masonry-item a {
    text-decoration: none;
  }

  .masonry-item {
    margin-bottom: 0px;
    border-radius: 0px;
    position: relative;
    display: block;

    p {
      max-width: 95%;
      margin: 0px $padding-sm 6px $padding-sm;
      padding: 0px;
      font-size: 0.7rem;
      font-weight: 300;
      color: $color-grey;
      line-height: 1.2;
      letter-spacing: 0px;
    }

    h2 {
      color: #fff;
      font-size: 18px;
      font-weight: 500;
      max-width: 100%;
      margin: 0px $padding-sm 6px $padding-sm;
      padding: 0px;
      line-height: 1.1;
      text-decoration: none;
      z-index: 20;
    }

    h3 {
      color: #fff;
      font-size: 11px;
      max-width: 100%;
      margin: 0px $padding-sm 6px $padding-sm;
      padding: 0px;
      line-height: 1.4;
      letter-spacing: -0.5px;
      text-decoration: none;
      text-transform: uppercase;
      z-index: 25;
    }

    h4 {
      color: $color-secondary;
      font-size: 8px;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin: 0px $padding-sm 6px $padding-sm;
      padding: 0px;
      font-weight: 400;
      text-decoration: none;
      z-index: 30;
    }

    img.masonry-image {
      width: 100%;
      display: block;
      height: 100%;
      z-index: 0;
    }

    .overlay {
      background: rgba(#fff, 0.5);
      display: flex;
      height: 100%;
      position: absolute;
      width: 100%;

      .foot_button {
        position: absolute;
        bottom: 50px;
        left: $padding-sm;
        border: 1px solid #3300ff;
        background: #3300ff;
        color: #fff;
      }

      .masonry-item-footer {
        position: absolute;
        bottom: 0px;
        left: 0px;
        width: 100%;
        min-height: 30px;
        background-color: $color-grey;
        .actions {
          margin: 8px 0px 0px 8px;
        }
      }

    }
  }

  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.5s;
  }
  .fade-enter,
  .fade-leave-to {
    opacity: 0;
  }

  .masonry-inner {
    margin: 19px 0px $padding-sm 0px;
    width: 100%;
    z-index: 15;
  }

  .masonry-inner-fixed {
    position: absolute;
    top: 0px;
    left: 0px;
  }

  ul.gridfilter_list {
    margin-bottom: 2px;
  }

  ul.gridfilter_list li label {
    display: block;
    color: $color-grey3;
    text-align: center;
    padding: $padding-sm;
    text-decoration: none;
  }

  ul.gridfilter_list li label:hover {
    background-color: $color-2;
    color: $color-grey3;
  }

  ul.gridfilter_list li label.active {
    background-color: $color-grey3;
    color: #fff;
  }

  ul.gridfilter_list li label input[type="radio"] {
    display: none;
  }

  .gridfilter_list_count {
    padding-top: $padding-sm;
    padding-bottom: $padding-sm;
    text-align: right;
    color: $color-blue2;
  }

  .discovery-event {
    background-color: #fff;
  }

  .discovery-genre {
    background-color: #fff;
  }

  .discovery-merch {
    background-color: #fff;
  }

  .discovery-track {
    background-color: $color-grey3;
    transition: all 0.5s;
  }

  .masonry-item.discovery-track:hover {
    background-color: #3a3535;
  }

  .discovery-video {
    background-color: $color-grey;
  }

  .masonry-item::before {
    // height: 100%;
    position: absolute;
    top: 0px;
    left: 0px;
    width: 100%;
    content: "";
    display: block;
    opacity: 0.8;
    background-image: linear-gradient(to top, rgba(255,0,0,0), rgb(0, 0, 0));
    // z-index: 1;
  }


  .masonry-item.discovery-playlist  .overlay .foot_button {
    bottom: 21px;
  }

  .masonry-item.discovery-track::before {
    display: none;
  }

  .showGrid {
    transition: opacity 0.5s ease-in-out;
    opacity: 1;
  }

  .hideGrid {
    transition: opacity 0.5s ease-in-out;
    opacity: 0;
  }


  // Was having trouble with the button component's :to attribute and getRouterObject()
  .button {
    cursor: pointer;
    display: inline-block;
    background: none;
    border-radius: 999px;
    outline: none;
    font-size: 10px;
    padding: 7px 12px;
    letter-spacing: 1px;
    border: 1px solid $color-primary;
    color: $color-primary;
    text-align: center;

    // Color Variations
    &.inverted {
      color: white;
      border-color: white;
    }
    &.white-border {
      background: transparent;
      border-color: white;
      color: white;
    }
    &.white {
      background: white;
      border-color: white;
      color: $color-blue2;
    }
    &.blue {
      background: $color-blue;
      border-color: $color-blue;
      color: white;
    }
    &.blue2 {
      color: black;
      border-color: $color-2;
    }
    &.mint {
      // color: #fff;
      border-color: $color-2;
    }

    // Size Variations
    &.medium {
      padding: 7px 20px;
      border-width: 2px;
      font-size: 120%;
    }
    &.large {
      padding: 12px 30px;
      border-width: 2px;
      font-size: 150%;
    }
    &.giant {
      padding: 15px 40px;
      border-width: 2px;
      font-size: 180%;
    }

    // Other Variations
    &.thick {
      border-width: 2px;
    }

    // Type Variations
    &.search-filter {
      width: 100%;
      height: 100%;
      font-size: 12px;
      padding-left: 0;
      padding-right: 0;

      &.active {
        background: $color-2;
      }
    }
  }
  a.button {
    text-decoration: none;
  }

  .float-left{
    width: 81%;
  }
</style>
