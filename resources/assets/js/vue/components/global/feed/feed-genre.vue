<template>
  <div>
    <genre-logo :genre="item" />
  </div>
</template>

<script>
export default {
  name: "DiscoveryGenre",
  props: { item: Object },
  data() {
    return {
      imgUrl: this.item.image.files.original.url,
      hovered: null,
    };
  },
  computed: {
    outerClass: function() {
      return (
        this.item.component +
        " bg-" +
        this.item.name.replace(/\s+/g, "").toLowerCase()
      );
    },
  },
};
</script>

<style lang="scss" scoped>
.discovery-genre {
  img.masonry-image {
    transition: opacity 0.5s ease-in-out;
    opacity: 0.9;
    overflow: hidden;
    // height: 110px;
  }
  h2 {
    font-weight: 900;
    text-transform: uppercase;
  }
}

.discovery-genre:hover img.masonry-image {
  opacity: 0.6;
}

.p-item-phase-logo {
  width: 32px;
  height: 22px;
  margin-right: 15px;
  position: relative;
  background-size: contain;
  background-repeat: no-repeat;
}
</style>
