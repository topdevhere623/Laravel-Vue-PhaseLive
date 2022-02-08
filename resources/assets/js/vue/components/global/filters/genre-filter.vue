<template>
  <div class="search-filter-group">
    <slot>
      <h2>{{ title }}</h2>
    </slot>
    <br />
    <div class="filter-buttons">
      <div class="button-container" v-for="genre in $store.state.app.genres">
        <ph-button
          size="medium"
          color="blue2"
          width="100%"
          type="search-filter"
          :active="isActive(genre)"
          @click.native="single ? setSingleFilter(genre) : toggleFilter(genre)"
        >{{ genre.name }}</ph-button>
      </div>
    </div>
    
  </div>
</template>

<script>
import FilterMethods from "./filter-methods";
export default {
  data() {
    return {
      filters: this.value,
    };
  },
  props: {
    value: {
      type: Array,
      default: [],
    },
    single: {
      type: Boolean,
      default: false,
    },
    title: {
      type: String,
      default: "Genres",
    },
  },
  created: function () {
    this.$store.dispatch("app/fetchGenres");
  },
  mixins: [FilterMethods],
};
</script>

<style lang="scss" scoped>
h3 {
  font-size: 17px;
  margin-bottom: 5px;
}
</style>