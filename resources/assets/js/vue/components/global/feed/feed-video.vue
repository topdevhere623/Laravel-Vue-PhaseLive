<template>
  <router-link
    :to="getRouterObject(item)"
    :class="'masonry-item ' + item.component"
  >
    <img :src="imgUrl" :alt="item.title" class="masonry-image masonry-image-release">
    <div class="masonry-inner masonry-inner-fixed">
      <h4>Video</h4>
      <h2>{{ item.title }}</h2>
    </div>
      <span class="p-player-control fa-layers fa-fw player-vertical">
        <span>
          <i class="fa fa-fw fa-circle" data-fa-transform="grow-30" style="color:#ff0000"></i>
        </span>
        <span>
          <i class="fa fw-fw fa-play" data-fa-transform="shrink-4" style="color:white"></i>
        </span>
      </span>

  </router-link>
</template>

<script>
export default {
  name: 'DiscoveryVideo',
  props: { item: Object },
  data() {
    return {
      imgUrl: "https://phase-website.s3.eu-west-2.amazonaws.com/covers/Y20JJ_ddy9M-XvZhahLzyWj9JTxslJgMNLU3VBWZx0hJ.jpg",
    };
  },
}
</script>

<style lang="scss" scoped>
  .discovery-video {
    // height: 180px;

    img.masonry-image {
      opacity: 0.9;
      transition: opacity 0.5s ease-in-out;
    }

    .video-actions {
      text-align: center;
    }

  }

  .masonry-item h4,
  .masonry-item h2 {
    color: #fff;
    text-decoration: none;
  }

  .discovery-video:hover img.masonry-image {
    opacity: 0.7;
  }

  .player-vertical {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 20;
  }


</style>
