<template>
  <div class="search-filter-group">
    <slot>
      <h2>{{ title }}</h2>
    </slot>
    <br />
    <div class="filter-buttons">
      <div class="button-container" v-for="classItem in $store.state.app.classes">
        <ph-button
          size="medium"
          color="blue2"
          type="search-filter"
          :active="isActive(classItem)"
          @click.native="single ? setSingleFilter(classItem) : toggleFilter(classItem)"
        >{{ classItem.name }}</ph-button>
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
      default: "Class",
    },
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