<template>
  <div class="search-filter-group">
    <h2>Key/Note</h2>
    <br />
    <div class="filter-buttons">
      <div class="button-container" v-for="(key, index) in $store.state.app.keys" :key="index">
        <ph-button
          size="medium"
          color="blue2"
          width="100%"
          type="search-filter"
          :active="isActive(key)"
          @click.native="
                    single ? setSingleFilter(key) : toggleFilter(key)
                "
        >{{ key.name | clean }}</ph-button>
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
  },
  mixins: [FilterMethods],
  filters: {
    clean(value) {
      if (!value) return "";
      value = value.toString();
      return value.replace(/;/g, "");
    },
  },
};
</script>

<style lang="scss" scoped></style>
