<template>
  <div class="discover">
    <filter-container>
      <genre-filter v-model="filters.genres">
        <div class="section-wrapper">
          <span class="section-number">1</span>
          <h2>Choose your interest</h2>
        </div>
      </genre-filter>

      <class-filter v-model="filters.classes" :single="true">
        <div class="section-wrapper">
          <span class="section-number">2</span>
          <h2>Select a Class</h2>
        </div>
      </class-filter>

      <filter-filter v-model="filters.filter" :single="true">
        <div class="section-wrapper">
          <span class="section-number">3</span>
          <h2>Select a Filter</h2>
        </div>
      </filter-filter>

      <div class="bpm-filter">
        <h2>BPM</h2>
        <p class="bpm-values">{{ sliderValue[0] + " > " + sliderValue[1] }}</p>
        <div :style="noFiltersSelected ? 'opacity:0.5' : 'opacity:1;'">
          <vue-slider
            v-model="sliderValue"
            :min="0"
            :max="200"
            :enable-cross="false"
            :lazy="true"
            @change="getFilteredResults"
          ></vue-slider>
        </div>
      </div>

      <!-- <div class="key-filter">
              <key-filter v-model="filters.keys" :single="false"></key-filter>
      </div>-->
    </filter-container>

    <div class="discover-results">
      <div
        class="discover-start"
        v-if="noFiltersSelected"
        style="margin-top: 32px;"
      >
        <div>Select some of the filters to discover new music</div>
      </div>

      <div
        v-else-if="
          results &&
            (filters.classes.length ||
              filters.genres.length ||
              filters.filter.length ||
              filters.bpm.length)
        "
      >
        <div class="discover-section">
          <h2 style="margin-top:0;">Results</h2>
          <p v-if="results.length === 0"></p>
          <div class="discover-row">
            <div
              class="discover-result"
              v-for="(album, index) in results"
              :key="index"
            >
              <release-tile :release="album" :size="150"></release-tile>
            </div>
          </div>
        </div>
        <div style="margin: 0 0 4em 0" class="centered-text" v-if="nextPageUrl">
          <ph-button
            size="medium"
            color="blue2"
            :loading="loadingNextPage"
            @click.native="loadNextPage"
            >Load More</ph-button
          >
        </div>
      </div>

      <div v-else>
        <spinner
          style="margin: 3em auto;"
          :animation-duration="1000"
          :size="60"
          color="black"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { HalfCircleSpinner as Spinner } from "epic-spinners";
import FilterContainer from "global/filters/filter-container";
import ClassFilter from "global/filters/class-filter";
import GenreFilter from "global/filters/genre-filter";
import FilterFilter from "global/filters/filter-filter";
import ReleaseTile from "global/releases/release-tile";
import KeyFilter from "global/filters/key-filter";
import VueSlider from "vue-slider-component";
import "vue-slider-component/theme/default.css";

export default {
  name: "discover",

  components: {
    Spinner,
    FilterContainer,
    GenreFilter,
    ClassFilter,
    FilterFilter,
    ReleaseTile,
    KeyFilter,
    VueSlider,
  },

  computed: {
    noFiltersSelected() {
      if (
        (!this.filters.classes.length &&
          !this.filters.genres.length &&
          !this.filters.filter.length &&
          this.filters.bpm[0] + this.filters.bpm[1] === 200) ||
        (!this.results && !this.loading)
      ) {
        return true;
      }
      return false;
    },
  },

  data() {
    return {
      loading: false,
      filters: {
        classes: [],
        genres: [],
        filter: [],
        bpm: [],
        keys: [],
      },
      results: null,
      nextPageUrl: null,
      loadingNextPage: false,
      sliderValue: [0, 200],
    };
  },

  watch: {
    filters: {
      handler: function() {
        this.getFilteredResults();
      },
      deep: true,
    },
  },

  methods: {
    getFilteredResults() {
      this.results = null;
      this.loading = true;
      this.filters.bpm = this.sliderValue;

      axios
        .post("/api/discover", this.filters)
        .then((response) => {
          this.results = response.data.data;
          this.nextPageUrl = response.data.next_page_url;
          this.loading = false;
        })
        .catch((error) => {
          this.loading = false;
        });
    },

    loadNextPage() {
      this.loadingNextPage = true;
      axios
        .post(this.nextPageUrl, this.filters)
        .then((response) => {
          let newResults = [],
            currentResults = this.results;
          Object.entries(response.data.data).forEach(([key, item]) => {
            newResults.push(item);
          });
          this.results = currentResults.concat(newResults);
          this.nextPageUrl = response.data.next_page_url;
          this.loadingNextPage = false;
        });
    },
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

<style scoped lang="scss">
.section-wrapper {
  display: flex;
  align-items: flex-start;
  .section-number {
    margin-right: 10px;
    min-width: 20px;
    height: 20px;
    padding: 10px;
    border-radius: 50%;
    background-color: #0039ff;
    color: #fff;
    display: block;
    display: flex;
    align-items: center;
    justify-content: center;
  }
}

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

.discover {
  display: flex;
  align-items: flex-start;

  @media (max-width: 900px) {
    display: block;
  }

  .discover-results {
    padding: 0 20px;

    .discover-section {
      margin: 30px 0;
      .header {
        margin-bottom: 20px;
        align-items: flex-start;
        h2 {
          margin: 0 10px 0 0;
        }
      }

      .discover-row {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
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
}
</style>
