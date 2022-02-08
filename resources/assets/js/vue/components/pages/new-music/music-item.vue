<template>
  <div class="p-item">
    <div class="p-item-image">
      <router-link
          :to="getRouterObject(mutableTrack)"
      >
        <avatar :size="130"
                :tile="true"
                :labels="labels"
                :src="mutableTrack.release.image.files.medium.url"
        />
      </router-link>
    </div>
    <div class="p-item-main">
      <div class="p-item-detail">
        <div class="p-item-title">
          <router-link
              :to="getRouterObject(mutableTrack)"
              style="text-decoration: none;"
          >
            <span>{{ mutableTrack.name }}</span>
          </router-link>
          <play-pause-button :track="item"/>
        </div>
        <div class="p-item-subtitle">
          {{ mutableTrack.release.name }}
        </div>
      </div>
      <div class="p-item-meta">
        <actions :actionable="mutableTrack"
                 @like="liked"
                 @unlike="unliked"
                 @share="shared"
                 @commented="commented"
        />
        <div class="p-item-time">
          {{ moment(mutableTrack.created_at).fromNow() }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Actions from 'global/actions/actions';
import ActionMenu from 'global/actions/action-menu';
import Avatar from 'global/avatar';
import PlayPauseButton from "../../global/play-pause-button";

export default {
  props: {
    item: {
      type: Object,
      required: true,
    }
  },
  data() {
    return {
      moment: window.moment,
      mutableTrack: this.item,
      track: {
        rect: null,
        progress: 0,
        dragging: false,
      }
    }
  },
  computed: {
    labels: function () {
      // tl: {
      //     text: 'pending',
      //         color: 'orange'
      // },
      let labels = {};
      // if(this.isNew(this.item.track)) {
      //     labels['tr'] = {
      //         text: 'new',
      //         color: 'blue'
      //     }
      // }
      return labels;
    }
  },
  methods: {
    liked() {
      this.mutableTrack.is_liked = true;
      this.mutableTrack.likes_count += 1;
    },
    unliked() {
      this.mutableTrack.is_liked = false;
      this.mutableTrack.likes_count -= 1;
    },
    shared() {
      this.mutableTrack.is_shared = true
      this.mutableTrack.shares_count += 1
    },
    commented() {
      this.mutableTrack.comments_count += 1
    },
  },
  components: {
    PlayPauseButton,
    Actions,
    ActionMenu,
    Avatar,
  }
}
</script>

<style lang="scss" scoped>

</style>
