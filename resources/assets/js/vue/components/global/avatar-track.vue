<template>
  <div
    class="avatar"
    :style="
      fullWidth
        ? 'width:100%;height:auto;'
        : 'width:' + size + 'px;height:' + size + 'px;'
    "
    :class="{ center: center }"
  >
    <ph-label v-if="labels.tl" class="tl" size="small" :color="labels.tl.color">
      {{ labels.tl.text }}
    </ph-label>
    <div
      v-if="showImage"
      :style="`background-image:url('${src}');background-size:cover;`"
      style="width:100%;height:150px;"
    ></div>
    <!-- <img :src="src" :alt="alt" :class="{ tile: tile }" v-if="showImage"/> -->
    <ph-label v-if="labels.tr" class="tr" size="small" :color="labels.tr.color">
      {{ labels.tr.text }}
    </ph-label>
    <div class="is-new-badge" v-if="recent">
      new
    </div>
    <div class="play-pause" v-if="track && track.status === 'approved'">
      <play-pause-button :track="track" :size="25" />
    </div>
  </div>
</template>

<script>
import PhLabel from "./ph-label";
import PlayPauseButton from "../global/play-pause-button";

export default {
  props: {
    fullWidth: {
      type: Boolean,
      default: false,
    },
    showImage: {
      type: Boolean,
      default: true,
    },
    recent: {
      type: Boolean,
      default: false,
    },
    tile: {
      type: Boolean,
      default: false,
    },
    size: {
      type: Number,
      default: 100,
    },
    src: {
      type: String,
      default: "https://placehold.it/200x200",
    },
    alt: {
      type: String,
      default: "Image",
    },
    center: {
      type: Boolean,
      default: true,
    },
    labels: {
      type: Object,
      default: function() {
        return {};
      },
    },
    verified: {
      type: Boolean,
      default: false,
    },
    track: {
      type: Object,
    },
  },
  data() {
    return {};
  },
  created: function() {},
  components: {
    PhLabel,
    PlayPauseButton,
  },
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";
.avatar {
  width: 100px;
  height: 100px;
  position: relative;

  &.center {
    @media (min-width: 371px) {
      margin: 0 auto;
    }
  }
}
.play-pause {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
img {
  width: inherit;
  height: inherit;
  object-fit: cover;

  border-radius: 100%;
  &.tile {
    border-radius: 0;

    @media (max-width: 500px) {
      border-radius: 5px;
    }
  }
}
.label {
  font-size: 10px;
  position: absolute;
  top: 7px;

  &.tl {
    left: -12px;
  }
  &.tr {
    right: -12px;
  }
}
.verified-badge {
  position: absolute;
  top: 13px;
  right: 13px;
  color: $color-2;
  font-size: 35px;
}
.is-new-badge {
  background: #30f;
  text-align: center;
  padding: 7px;
  border-radius: 12px;
  color: #fff;
  position: absolute;
  top: -5px;
  font-size: 12px;
  left: -5px;
}
</style>
