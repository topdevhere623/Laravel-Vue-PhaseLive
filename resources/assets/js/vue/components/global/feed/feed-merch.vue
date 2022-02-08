<template>
  <router-link
    :to="getRouterObject(item)"
    :class="'masonry-item ' + item.component"
  >
    <img :src="imgUrl" :alt="this.item.name" class="masonry-image masonry-image-release">
    <div class="masonry-inner masonry-inner-fixed">
      <h4>Merch</h4>
      <h2>{{ item.title }}</h2>
    </div>
  </router-link>
</template>

<script>
export default {
  name: 'DiscoveryMerch',
  props: { item: Object },
  data() {
    return {
      imgUrl: this.item.image.files.medium.url,
    };
  },
  // created: function() {
  //   console.log(this.item);
  // },
}
</script>

<style lang="scss" scoped>
  .discovery-merch {
    // height: 185px;
    overflow: hidden;

    h2 {
      color: #fff;
    }
    h4 {
      // color: #366efc;
      color: #fff;
    }
    img.masonry-image {
      opacity: 0.9;
      transition: opacity 0.5s ease-in-out;
    }
  }

  .discovery-merch:hover img.masonry-image {
    opacity: 0.6;
  }
</style>