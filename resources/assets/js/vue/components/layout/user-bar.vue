<template>
  <div class="user-bar">
    <div v-if="!app.user.loggedin" style="margin: 0 10px">
      <back-button />
    </div>
    <div
      class="user-bar-main"
      :class="{ 'user-bar-guest': !app.user.loggedin }"
    >
      <div class="user-bar-left" v-if="app.user.loggedin">
        <back-button />

        <!--                <v-popover :disabled="!app.user.account_verified">-->
        <ph-button
          v-if="$can('create releases')"
          @click.native="showUpload"
          :style="!app.user.stripe_account_id ? 'opacity:0.5;' : null"
          :disabled="!app.user.stripe_account_id ? 'disabled' : null"
        >
          Upload
          <template v-if="!app.user.stripe_account_id || !app.user.approved_at" slot="tooltip">
            <p>Complete verification in your account section</p>
          </template>
          <template v-else-if="app.user.tracks_count_this_month >= free_release_limit" slot="tooltip">
            <p>Upload restriction reached: upgrade to receive unlimited uploads</p>
          </template>
        </ph-button>
        <!--                </v-popover>-->

        <!-- <span>
                    {{ app.user.name }} - <router-link :to="{ name: 'news' }">News</router-link>
        </span>-->
      </div>

      <div class="user-bar-actions" v-if="app.user.loggedin">
        <a class="user-bar-item fa-layers fa-fw" @click="showCart" href="#">
          <i class="fa fa-shopping-cart"></i>
          <span
            class="fa-layers-counter message-counter"
            v-if="cart.items.length"
            >{{ cart.items.length }}</span
          >
        </a>
        <router-link class="user-bar-item" to="/account/mymusic">
          <i class="fa fa-music"></i>
        </router-link>
        <a class="user-bar-item" href="#" @click.prevent="toggleMessages">
          <span class="fa-layers fa-fw">
            <i class="fas fa-envelope"></i>
            <span
              class="fa-layers-counter message-counter"
              v-if="messenger.unreadThreads.length"
              >{{ messenger.unreadThreads.length }}</span
            >
          </span>
        </a>
        <message-dropdown
          :show="messages.show"
          :threads="messenger.unreadThreads"
        />
        <router-link class="user-bar-item" :to="'/user/' + app.user.path">
          <avatar
            v-if="app.user.avatar"
            :src="app.user.avatar.files.medium.url"
            :alt="app.user.avatar.alt"
            :size="35"
          ></avatar>
        </router-link>
      </div>

      <div class="user-bar-actions" v-else>
        <a class="user-bar-item fa-layers fa-fw" @click="showCart" href="#">
          <i class="fa fa-shopping-cart"></i>
          <span
            class="fa-layers-counter message-counter"
            v-if="cart.items.length"
            >{{ cart.items.length }}</span
          >
        </a>
      </div>

      <!--            <div class="user-bar-actions" v-if="app.user.loggedin">-->
      <!--                <a class="user-bar-item" @click="showCart" href="#">-->
      <!--                    <i class="fa fa-shopping-cart"></i>-->
      <!--                </a>-->
      <!--            </div>-->
    </div>
    <div class="user-bar-player" v-show="$store.state.player.status.set">
      <player></player>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import store from "store";
import { PlayerEvents } from "events";

import Player from "global/player";
import PhButton from "global/ph-button";
import Avatar from "global/avatar";
import MessageDropdown from "../pages/user/messages/message-dropdown";

export default {
  components: {
    Player,
    PhButton,
    Avatar,
    MessageDropdown,
  },

  data() {
    return {
      moment: window.moment,
      free_release_limit: window.free_release_limit,
      messages: {
        show: false,
      },
    };
  },

  computed: mapState(["app", "messenger", "cart"]),

  mounted() {
    document.addEventListener("click", this.handleClickOutside);

    if (this.app.user.loggedin) {
      store.dispatch("messenger/fetchThreads");
    }
  },

  destroyed() {
    document.removeEventListener("click", this.handleClickOutside);
  },

  methods: {
    handleClickOutside(evt) {
      if (!this.$el.contains(evt.target)) {
        this.messages.show = false;
      }
    },

    showCart: function () {
      this.$modal.show("modal-cart");
    },

    showUpload: function () {
      this.$modal.show("modal-upload");
    },

    showUploadVideo: function () {
      this.$modal.show("modal-upload-video");
    },

    toggleMessages: function () {
      this.messages.show = !this.messages.show;
    },
  },
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";

.user-bar {
  height: 50px;
  background: $color-grey;
  display: flex;
  align-items: center;
  justify-content: space-between;

  @media (max-width: 1024px) {
    height: auto;
    flex-direction: column;
    // padding-top: 2em;
    padding: 20px 0;
  }
  &.hidden {
    display: none;
  }
}
.user-bar-main {
  justify-content: space-between;
  flex: 1;

  font-size: 20px;
  align-items: center;
  //padding: 0 1em;

  display: flex;

  @media (max-width: 1024px) {
    // flex-direction: column;
  }
}
.user-bar-guest {
  justify-content: flex-end;
}
.user-bar-left {
  flex: 1;
  display: flex;
  align-items: center;

  & > * {
    margin: 0 10px;

    @media (max-width: 488px) {
      margin: 0 0.7em;
    }

    @media (max-width: 448px) {
      margin: 0 0.5em;
    }

    @media (max-width: 421px) {
      margin: 0 0.3em;
    }

    @media (max-width: 396px) {
      margin: 0 0.3em;
    }
  }
}
.user-bar-actions {
  display: flex;
  position: relative;
  justify-content: flex-end;
  align-items: center;
}
a.user-bar-item {
  margin: 0 10px;
  color: initial;
  display: block;
  position: relative;

  @media (max-width: 1024px) {
    margin: 0 8px;
  }
}
.message-counter {
  background: $color-blue;
  font-size: 150%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 40px;
  right: -3px;
  position: absolute;
  top: -4px;
}
.user-bar-player {
  flex: 0 0 18%;
  font-size: 90%;
  min-width: 250px;
  max-width: 500px;
}
</style>
