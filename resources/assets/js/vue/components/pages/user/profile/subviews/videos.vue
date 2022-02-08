<template>
  <div>
    <ph-button @click.native="$modal.show('modal-upload-video');" size="medium">Add Video</ph-button>
    <spinner
      style="margin: 3em auto;"
      :animation-duration="1000"
      :size="60"
      color="black"
      v-show="loadingVideos"
    />
    <div v-if="videos.length">
      <item v-for="video in videos" :item="video" :key="video.id" />
    </div>
    <div>
        
    </div>
  </div>
</template>

<script>
import ProfileMixin from "../profile-mixin";
import { HalfCircleSpinner as Spinner } from "epic-spinners";
import Item from "global/items/item";

export default {
  data() {
    return {
      loadingVideos: false,
      videos: [],
    };
  },
  created: function () {
    this.fetchVideos();
  },
  methods: {
    fetchVideos() {
      this.loadingVideos = true;
      axios
        .get("/api/user/" + this.user.id + "/videos")
        .then((response) => {
          this.videos = response.data;
        })
        .finally(() => {
          this.loadingVideos = false;
        });
    },
  },
  mixins: [ProfileMixin],
  components: {
    Item,
    Spinner,
  },
};
</script>

<style lang="scss" scoped>
</style>
