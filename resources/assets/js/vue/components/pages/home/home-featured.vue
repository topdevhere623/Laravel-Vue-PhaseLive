<template>
  <div>
    <div v-if="featuredItems">
      <h1>Featured</h1>
      <div class="home-featured">
        <split-grid :data="featuredItems" type="Featured" />
      </div>
    </div>

    <spinner
      style="margin: 3em auto"
      v-else
      :animation-duration="1000"
      :size="80"
      color="black"
    />
  </div>
</template>

<script>
import { HalfCircleSpinner as Spinner } from "epic-spinners";
import SplitGrid from "../../global/split-grid";

export default {
  props: ["featured-items"],
  components: {
    Spinner,
    SplitGrid,
  },
};
</script>

<style lang="scss" scoped></style>
