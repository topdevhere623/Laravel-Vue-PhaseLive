<template>
  <div class="search-filters">
    <div class="desktop-filters">
      <slot></slot>
    </div>
    <div class="mobile-filters">
      <div class="filter-toggle">
        <a @click.prevent="menuOpen = !menuOpen">
          <span v-if="!menuOpen">Show Filters</span>
          <span v-else>Hide Filters</span>
        </a>
      </div>
      <div v-if="menuOpen" class="mobile-filters-wrap">
        <slot />
      </div>
    </div>
  </div>
</template>

<script>
//import Component from '../';
export default {
  data() {
    return {
      menuOpen: false,
    };
  },
  created: function () {},
  components: {},
};
</script>

<style lang="scss">
.desktop-filters {
  @media (min-width: 900px) {
    display: block;
  }
  display: none;
}
.mobile-filters {
  @media (min-width: 900px) {
    display: none;
  }
  display: block;

  .hidden {
    display: none;
  }

  .mobile-filters-wrap {
  }
}

.filter-toggle {
  width: 100px;
  display: flex;
  justify-content: center;
  a {
    background-color: #3300ff;
    padding: 10px;
    border-radius: 12px;
    text-align: center;
    color: #fff;
    cursor: pointer;
  }
}

.search-filters {
  min-width: 260px;
  max-width: 260px;
  padding: 0 20px;

  .search-filter-group {
    margin: 32px 0;

    h2 {
      text-transform: uppercase;
      font-size: 22px;
      font-weight: bold;
      margin: 0;
    }

    .filter-buttons {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      align-items: center;

      .button-container {
        width: calc(50% - 10px);
        margin: 5px 0;
      }
    }
  }
}
</style>
