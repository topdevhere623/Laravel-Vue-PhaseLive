<template>
  <div
    :class="'masonry-item ' + item.component"
    @mouseover="hovered = item.id"
    @mouseleave="hovered = null"
    :style="`min-height:250px;background-size:cover;background-repeat:no-repeat;background-image:linear-gradient(to top, rgba(255,0,0,0), rgb(0, 0, 0)), url('${imgUrl}')`"
  >
    <transition name="fade">
      <div class="overlay" v-show="hovered === item.id">
        <div class="button-container">
          <router-link
            :to="getRouterObject(item)"
            class="button foot_button mint small"
          >View Release</router-link>
        </div>
        <div class="masonry-item-footer">
          <actions :actionable="item" @like="liked" @unlike="unliked"/>
        </div>
      </div>
    </transition>
    <!-- <img :src="imgUrl" :alt="this.item.name" class="masonry-image masonry-image-release"> -->
    <div class="masonry-inner masonry-inner-fixed">
      <h4>Release</h4>
      <h2>{{ item.name }}</h2>
      <p>{{ limitChars(item.description) }}</p>
    </div>
  </div>
</template>

<script>
  import PhButton from "global/ph-button";
  import Actions from "global/actions/actions";
  export default {
    name: "DiscoveryRelease",
    components: {
      Actions,
      PhButton
    },
    props: { item: Object },
    data() {
      return {
        imgUrl:
          "https://phase-website.s3.eu-west-2.amazonaws.com/" +
          this.item.image.files.thumb.path,
        hovered: null
      };
    },
    methods: {
      liked() {
        this.item.is_liked = true;
        this.item.likes_count += 1;
      },
      unliked() {
        this.item.is_liked = false;
        this.item.likes_count -= 1;
      }
    }
  };
</script>

<style lang="scss" scoped>

</style>

