<template>
  <div>
    <avatar-track
      :fullWidth="true"
      :tile="true"
      :src="release.image.files.medium.url"
      :track="release.tracks[0]"
      :recent="release.is_recent"
    />
    <div v-if="mode === 'charts'" class="release-tile-chart-position">
      <div class="position"># {{ chartPosition }}</div>
      <div class="line"></div>
    </div>
    <router-link class="release-tile" :to="getRouterObject(release)">
      <div class="release-tile-image">
        <!-- <avatar :tile="true" :size="size" :src="release.image.files.medium.url" ></avatar> -->
      </div>
      <div class="release-tile-text">
        <p class="release-name">
          {{ release.name ? release.name : "release name" }}
        </p>
        <small class="mt-5 uploaded-by">{{ release.uploader.name }}</small>
      </div>
    </router-link>
  </div>
</template>

<script>
import Avatar from "global/avatar";
import AvatarTrack from "../../global/avatar-track";
export default {
  props: {
    size: Number,
    release: Object,
    mode: String,
    position: Number,
  },
  data() {
    return {};
  },
  created: function () {},
  components: {
    Avatar,
    AvatarTrack,
  },
  computed: {
    chartPosition() {
      return this.position + 1;
    },
  },
};
</script>

<style lang="scss" scoped>
.release-tile-chart-position {
  margin: 15px 0;
  max-width: 40px;
  text-align: center;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  color: var(--strong-blue);


  .poisition {
    font-weight: bold;
    color: var(--strong-blue);
  }
  .line {
    width: 100%;
    background: var(--strong-blue);
    height: 3px;
    border-radius: 12px;
  }
}
.release-tile {
  text-decoration: none;
}
.release-tile-text {
  text-align: left;
  margin: 1em 0;
}
.release-name {
  text-align: left;
  font-size: 12px;
  margin-bottom: 5px;
  font-weight: bold;
}

.uploaded-by {
  font-size: 11px;
  text-align: left;
}
</style>

<style lang="css">
.release-tile-image > div {
  width: 100% !important;
}
</style>
