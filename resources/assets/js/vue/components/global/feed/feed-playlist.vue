<template>
  <!-- <router-link
    :to="getRouterObject(item)"
    :class="'masonry-item ' + item.component"
  > -->
    <div
      :class="'masonry-item ' + item.component"
      @mouseover="hovered = item.id"
      @mouseleave="hovered = null"
    >
    <transition name="fade">
      <div class="overlay" v-show="hovered === item.id">
        <div class="button-container">
          <router-link
            :to="getRouterObject(item)"
            class="button foot_button mint small"
          >View Playlist</router-link>
        </div>
        <!-- <div class="masonry-item-footer">
          <actions :actionable="item" @like="liked" @unlike="unliked"/>
        </div> -->
      </div>
    </transition>
    <img :src="imgUrl" :alt="this.item.name" class="masonry-image masonry-image-release">
    <div class="masonry-inner masonry-inner-fixed">
      <h4>Playlist</h4>
      <h2>{{ item.name }}</h2>
      <p>{{ limitChars(item.description) }}</p>
      <ul class="list-unstyled clearfix">
        <li>Example Track Name Here</li>
        <li>Example Track Name Here</li>
        <li>Example Track Name Here</li>
        <li>Example Track Name Here</li>
      </ul>
      <!-- {{ item.tracks }} -->
    </div>
  <!-- </router-link> -->
  </div>
</template>

<script>
export default {
  name: 'DiscoveryPlaylist',
  props: { item: Object },
  data() {
    return {
      imgUrl:
        "https://phase-website.s3.eu-west-2.amazonaws.com/" +
        'covers/KoKAXLKJwhk-NT8CHsA6M6hlag2kfBafe2wjTVaInmp4.jpg',
      hovered: null
    };
  },
  created: function() {
    console.log(this.item);
  },

}
</script>

<style scoped>
  .discovery-playlist {
    min-height: 210px;
  }

/* .masonry-item h2 {
  color: #fff;
}

.masonry-item h4 {
  color: #fff;
}

.masonry-item p {
  color: #fff;
} */

.masonry-item ul {
  color: #ffffff;
  font-size: 0.7rem;
  line-height: 1.6;
  margin: 12px 15px 6px 15px;
  letter-spacing: 0.5px;
  padding-bottom: 5px;
  clear: both;
}

</style>
