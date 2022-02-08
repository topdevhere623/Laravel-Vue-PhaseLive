<template>
  <div class="profile-avatar" :class="{ isme: isMe }" @click="showModal">
    <avatar class="pro-hero-avatar" :size="size" :src="user.avatar.files.medium.url" :alt="user.avatar.alt"
            :verified="verified"/>
    <div class="change-button">
      Change Avatar
    </div>
  </div>
</template>

<script>
//import Component from '../';
export default {
  props: {
    user: {
      type: Object,
      required: true,
    },
    size: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {}
  },
  computed: {
    isMe: function () {
      return this.user.id === this.$store.state.app.user.id;
    },
    verified() {
      return this.user.account_type === 'pro' && this.user.approved_at
    }
  },
  methods: {
    showModal() {
      this.$modal.show('modal-change-avatar');
    },
  },
  components: {}
}
</script>

<style lang="scss" scoped>
.change-button {
  opacity: 0;
  bottom: -6px;
  position: absolute;
  color: #fff;
  text-align: center;
  background: #3300ff;
  padding: 12px;
  border-radius: 999px;
  box-sizing: border-box;
  transition: 0.3s ease;
  transform: translateY(10px);
  font-size: 12px;
  font-weight: bold;
}

.profile-avatar {
  margin: 0 0 20px 0;
}

.profile-avatar.isme {
  position: relative;
  cursor: pointer;
  display: flex;
  justify-content: center;

  &:hover .change-button {
    opacity: 1;
    transition: 0.3s ease;
    transform: translateY(0);
  }
}
</style>
