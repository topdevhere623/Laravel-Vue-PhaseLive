<template>
  <div class="page-content-padded page-profile-pro">
    <!-- MAIN CONTENT -->
    <div class="page-main">
      <div
        class="profile-pro-hero"
        :style="{
          background: !backgroundImageUrl
            ? '#e6e6e6'
            : `url(${backgroundImageUrl})`,
        }"
      >
        <div class="change-button" @click="showChangeBannerModal">
          Change Banner
        </div>

        <div
          v-if="backgroundImageUrl"
          class="remove-button"
          @click="deleteBanner"
        >
          <i class="fa fa-trash"></i><span></span>
        </div>

        <profile-avatar :user="mutableUser" :size="200" />
        <div class="pro-hero-info">
          <div class="pro-hero-info-name">
            {{ mutableUser.name }}
            <ph-label color="blue">Pro</ph-label>
          </div>
          <div class="pro-hero-info-bio">
            {{ mutableUser.bio }}
          </div>
          <div class="pro-hero-info-actions">
            <follow-action
              v-if="!isMe"
              :user="mutableUser"
              @update="followStatusUpdated"
            />
          </div>
        </div>
      </div>
      <div class="pro-main">
        <aside class="sidebar-left">
          <user-left-sidebar :user="user" />
        </aside>
        <!-- MAIN CONTENT -->
        <div class="pro-content-area">
          <profile-navigation />
          <router-view :user="user" />
        </div>
      </div>
    </div>
    <aside class="sidebar-right">
      <user-right-sidebar :user="user" :news="news" />
    </aside>
  </div>
</template>

<script>
import ProfileMixin from "./profile-mixin";

import FollowAction from "./partials/follow-action";
import ProfileNavigation from "./partials/profile-navigation";

import ProfileAvatar from "./partials/avatar";
import SidebarGroup from "global/sidebar-group";
import AddText from "global/add-text/add-text";
import PhLabel from "global/ph-label";
import UserLeftSidebar from "../../../global/sidebars/user-left-sidebar";
import UserRightSidebar from "../../../global/sidebars/user-right-sidebar";

export default {
  components: {
    UserRightSidebar,
    UserLeftSidebar,
    ProfileAvatar,
    SidebarGroup,
    "status-update": AddText,
    PhLabel,
    FollowAction,
    ProfileNavigation,
  },
  mixins: [ProfileMixin],
  computed: {
    isMe: function() {
      return this.user.id === this.$store.state.app.user.id;
    },
    backgroundImageUrl: function() {
      return this.user.banner.files && this.user.banner.files.large
        ? this.user.banner.files.large.url
        : null;
    },
  },
  methods: {
    showChangeBannerModal() {
      this.$modal.show("modal-change-banner");
    },
    deleteBanner() {
      axios.delete("/api/user/banner").then((data) => {
        this.user.banner = data;
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.profile-pro-hero {
  min-height: 300px;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  flex-wrap: wrap;
  padding: 30px;
  box-sizing: border-box;
  background-size: cover !important;
  background-position: center center !important;
  margin-bottom: 2em;
  color: white;
  position: relative;

  &:hover {
    .change-button,
    .remove-button {
      opacity: 1;
      visibility: visible;
    }
  }

  .change-button {
    position: absolute;
    bottom: 1em;
    right: 1em;
    cursor: pointer;
    opacity: 0;
    visibility: hidden;
    border-radius: 999px;
    outline: none;
    padding: 12px;
    letter-spacing: 1px;
    border: 1px solid #3300ff;
    color: #fff;
    text-align: center;
    background: #3300ff;
  }

  .remove-button {
    position: absolute;
    top: 1em;
    right: 1em;
    cursor: pointer;
    opacity: 0;
    visibility: hidden;
    border-radius: 999px;
    outline: none;
    padding: 12px;
    letter-spacing: 1px;
    border: 1px solid red;
    color: #fff;
    text-align: center;
    background: red;
  }
}
.pro-hero-info {
  flex: 1;
  height: 100%;
  margin-left: 2em;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
}
.pro-hero-info-actions {
  display: flex;
}
.pro-hero-info-name {
  font-size: 30px;
}
.pro-hero-info-bio {
  margin: 1em 0;
  font-size: 16px;
}
.pro-main {
  display: flex;
}
.pro-content-area {
  flex: 1;
}
</style>
