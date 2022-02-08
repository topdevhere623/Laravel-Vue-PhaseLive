<template>
  <div class="message-dropdown" v-if="show">
    <ul>
      <li v-for="(thread, index) in threads" :key="thread.id">
        <!-- Extract this to a message-preview component -->
        <div class="message">
          <!-- <router-link :to="{ path: `/user/thread/${thread.id}` }" class="message" @click.native="$parent.messages.show = false"> -->
          <avatar
            :src="getReceiver(thread, 'avatar')"
            :size="50"
            :center="false"
          />

          <div class="message-detail">
            <router-link
              :to="{ path: `/user/thread/${thread.id}` }"
              @click.native="$parent.messages.show = false"
              class="underline_none"
            >
              <div class="message-name">
                <span>{{ getReceiver(thread, "name") }}</span>
              </div>
              <div class="message-excerpt">
                {{ thread.last_message.body.trunc(90) }}
              </div>
            </router-link>

            <div class="message-actions">
              <!-- <i class="fa fa-pen"></i> -->
              <router-link
                :to="{ path: `/user/thread/${thread.id}` }"
                @click.native="$parent.messages.show = false"
              >
                <span class="action_link">Reply</span>
              </router-link>
              <a class="action_link" @click="markRead(thread.id, index)"
                >Mark as read</a
              >
              <!-- Expand
                            <i class="fa fa-image"></i>
                            <i class="fa fa-exclamation-circle"></i> -->
            </div>
          </div>
          <!-- </router-link> -->
        </div>
      </li>
    </ul>
    <div @click.prevent="toggleMessages">
      <router-link to="/user/messages">
        View all messages
      </router-link>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import { MessageEvents } from "../../../../event-bus";

export default {
  props: ["threads", "show"],

  computed: mapState(["app"]),

  mounted() {
    MessageEvents.$on("newMessage", (data) => {
      this.$store.dispatch("messenger/fetchThreads");
    });
  },

  methods: {
    getReceiver(thread, property = null) {
      const result = thread.users.filter((user) => {
          const userID = this.app.user.id;
          return user.id != userID;
        }),
        user = result.shift();

      if (property) return user[property];

      return user;
    },

    listenForNewMessages() {
      console.log(this.threads);
    },

    toggleMessages: function() {
      // TODO - use event bus to open messages
    },
    markRead(id, index) {
      this.$store.dispatch("messenger/markread", { id: id, index: index });
    },
  },
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";

.message-dropdown {
  width: 250px;
  background: darken($color-grey, 3);
  position: absolute;
  right: 0;
  top: 45px;
  padding: 0 1em;
  z-index: 999;

  & > div:last-child {
    margin: 0.7em 0;
    text-align: center;

    a {
      text-decoration: none;
    }
  }

  .message {
    border-bottom: 1px solid white;
    display: flex;
    padding: 0.7em 0;
    text-decoration: none;

    .message-avatar {
      width: 50px;
      height: 50px;
      border-radius: 25px;
      margin-right: 15px;
      background-size: cover;
    }
    .message-detail {
      margin-left: 10px;
      display: flex;
      flex-direction: column;
      //justify-content: space-between;
      .underline_none {
        text-decoration: none;
      }
    }
    .message-name {
      color: $color-grey2;
      font-size: 10px;

      span {
        color: $color-blue;
        font-weight: bold;
        font-size: 12px;
      }
    }
    .message-excerpt {
      margin-top: 5px;
      font-size: 10px;
    }
    .message-actions {
      font-size: 10px;
      display: flex;
      justify-content: space-between;
      margin-top: auto;

      .action_link {
        text-decoration: underline;
        margin-right: 10px;
        font-weight: bold;
      }
      .action_link:hover {
        cursor: pointer;
      }
    }
  }
}
</style>
