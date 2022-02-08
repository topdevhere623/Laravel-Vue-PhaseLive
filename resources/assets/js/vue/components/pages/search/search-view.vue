<template>
  <div class="search-view">
    <filter-container>
      <class-filter v-model="filters.classes" :single="true"></class-filter>
      <genre-filter v-model="filters.genres"></genre-filter>
      <key-filter v-model="filters.keys" :single="false"></key-filter>
      <div class="bpm-filter">
        <h2>BPM</h2>
        <p class="bpm-values">
          {{ filters.bpm[0] + " > " + filters.bpm[1] }}
        </p>
        <vue-slider
          v-model="filters.bpm"
          :min="0"
          :max="200"
          :enable-cross="false"
          :lazy="true"
          v-on:drag-end.once="doSearch"
        ></vue-slider>
      </div>
    </filter-container>
    <div class="search-results">
      <div class="search-results-count">
        <div v-show="loading">
          Loading...
        </div>
        <div v-show="!loading">
          Showing {{ results.length }} results
          <span v-if="$store.state.search.searchTerm.length"
            >for '{{ $store.state.search.searchTerm }}'</span
          >
          <span
            v-if="
              filters.genres.length ||
                filters.classes.length ||
                filters.keys.length
            "
            >in</span
          >
          <span v-for="(genre, i) in filters.genres" :key="i"
            >'{{ genre.name }}'<span v-if="filters.genres[i + 1]"
              >,
            </span></span
          >
          <span v-for="(type, i) in filters.classes" :key="i"
            >'{{ type.name }}'<span v-if="filters.classes[i + 1]"
              >,
            </span></span
          >
          <span
            v-for="(key, i) in filters.keys"
            v-html="'\'' + key.name + '\''"
            :key="i"
            ><span v-if="filters.keys[i + 1]">, </span></span
          >
        </div>
      </div>
      <div class="search-results-grid">
        <div
          class="search-result"
          v-for="(item, index) in results"
          v-show="!loading"
          :key="index"
        >
          <search-result :result="item" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

import PhButton from "global/ph-button";
import FilterContainer from "global/filters/filter-container";
import ClassFilter from "global/filters/class-filter";
import GenreFilter from "global/filters/genre-filter";
import KeyFilter from "global/filters/key-filter";
import ReleaseTile from "global/releases/release-tile";
import TrackTile from "global/releases/track-tile";
import ArtistTile from "global/artists/artist-tile";
import VueSlider from "vue-slider-component";
import "vue-slider-component/theme/default.css";
import AvatarTrack from "../../global/avatar-track";

import SearchResult from "./search-result";

export default {
  data() {
    return {
      loading: false,
      results: [],
      filters: {
        classes: [],
        genres: [],
        keys: [],
        bpm: [0, 200],
      },
    };
  },
  computed: {
    ...mapGetters({
      vuexSearchTerm: "search/getSearchTerm",
    }),
  },
  mounted: function() {
    this.doSearch();
  },
  watch: {
    vuexSearchTerm: _.debounce(function() {
      this.doSearch();
    }, 300),
    filters: {
      handler: function() {
        this.doSearch();
      },
      deep: true,
    },
  },
  methods: {
    doSearch() {
      this.loading = true;
      axios
        .post("/api/search", {
          term: this.vuexSearchTerm,
          classes: this.filters.classes,
          genres: this.filters.genres,
          keys: this.filters.keys,
          bpm: this.filters.bpm,
        })
        .then((response) => {
          this.loading = false;
          this.results = response.data;
        });
    },
  },
  components: {
    PhButton,
    FilterContainer,
    ClassFilter,
    GenreFilter,
    KeyFilter,
    VueSlider,

    AvatarTrack,
    SearchResult,
  },
};
</script>

<style lang="scss">
.vue-slider {
  padding: 20px 0;

  .vue-slider-process {
    background-color: #9eefe1;
  }
  .vue-slider-dot-tooltip-inner {
    border-color: #9eefe1;
    background-color: #9eefe1;
  }
}
</style>

<style lang="scss" scoped>
.bpm-filter {
  margin-bottom: 50px;
}
.search-filter-group {
  margin-bottom: 30px;
}

.bpm-filter {
  .bpm-values {
    margin: 30px 0;
  }
}
.search-view {
  display: flex;
  align-items: flex-start;

  @media (max-width: 900px) {
    display: block;
  }

  .search-results {
    padding: 0 20px;
    margin: 32px 0;

    .search-results-grid {
      margin-top: 20px;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      @media (max-width: 900px) {
        grid-template-columns: repeat(3, 1fr);
      }
      @media (max-width: 650px) {
        grid-template-columns: repeat(2, 1fr);
      }
      grid-gap: 10px;
    }
  }
}
</style>
