<template>
  <div class="comment">
    <div class="comment-avatar">
      <avatar :src="data.user.avatar.files.thumb.url"></avatar>
    </div>
    <div class="comment-main">
      <div class="comment-upper">
        <div class="comment-name">
          {{ data.user.name }}
        </div>
        <div class="comment-time">
          {{ moment(data.created_at).fromNow() }}
        </div>
      </div>
      <div class="comment-acitons">
        <div class="comment-message" v-html="bodyHtml"></div>
        <div class="comment-actions">
          <report-button :reportable="data" hidden />
          <delete-button :deleteable="data" hidden v-if="this.app.user.id == data.user_id"/>
          <edit-comment-button :comment="data" hidden v-if="this.app.user.id == data.user_id" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";

import moment from "moment";
import Avatar from "./avatar";
import ReportButton from "./actions/report-button";
import DeleteButton from "./actions/delete-button";
import EditCommentButton from "./actions/edit-comment-button";

export default {
  props: ["data"],
  data() {
    return {};
  },
  computed: {
    ...mapState(["app"]),

    bodyHtml() {
      return new showdown.Converter().makeHtml(
        this.filter.clean(this.data.body)
      );
    },
  },
  created: function () {},
  methods: {
    moment: function (dateString) {
      return moment(dateString);
    },
  },
  components: {
    Avatar,
    ReportButton,
    DeleteButton,
    EditCommentButton
  },
};
</script>

<style lang="scss">
@import "~styles/helpers/_variables.scss";
.comment {
  width: 100%;
  height: 150px;
  display: flex;
  align-items: center;
  padding: 25px 0;
  box-sizing: border-box;

  &:hover {
    .report-button {
      display: block;
    }
  }
}
.comment-avatar {
  margin-right: 1em;
}
.comment-main {
  height: 100%;
  display: flex;
  flex: 1;
  flex-direction: column;
}
.comment-upper {
  display: flex;
  justify-content: flex-start;
  align-items: center;
}
.comment-name {
  margin-right: 1em;
}
.comment-time {
  color: $color-grey2;
  font-size: 75%;
}
.comment-message {
  flex: 1;
  padding: 10px 0;
  font-size: 80%;
}

.comment-actions {
  display: flex;

  span {
    margin: 0 5px 0 0;
  }
}
</style>
