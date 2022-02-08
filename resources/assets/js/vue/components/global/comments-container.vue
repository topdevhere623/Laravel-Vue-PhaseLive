<template>
  <div class="comments-container">
    <add-text
      type="comment"
      :addTextAble="commentable"
      @success="addComment"
    ></add-text>
    <comment
      v-for="comment in comments"
      :key="comment.id"
      :data="comment"
    ></comment>
    <div class="no-comments" v-if="!comments.length">
      <span v-show="commentsLoaded">
        There are no comments for this {{ commentable.type }} yet.
      </span>
      <span v-show="!commentsLoaded"> Loading... </span>
    </div>
  </div>
</template>

<script>
import AddText from "global/add-text/add-text";
import Comment from "global/comment";
import { UserEvents } from "events";

export default {
  props: {
    commentable: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      commentsLoaded: false,
      comments: [],
    };
  },
  created: function () {
    this.loadComments();

    UserEvents.$on("comment-deleted", () => {
      this.loadComments();

      this.$notify({
        group: "main",
        type: "success",
        title: "Comment deleted",
      });
    });
    UserEvents.$on("comment-updated", () => {
      this.loadComments();
    });
  },
  methods: {
    loadComments() {
      this.commentsLoaded = false;
      axios
        .get(
          "/api/social/comments/" +
            this.commentable.type +
            "/" +
            this.commentable.id
        )
        .then((response) => {
          this.comments = response.data.data;
          this.commentsLoaded = true;
        });
    },
    addComment(data) {
      this.comments.unshift({
        user: this.$store.state.app.user,
        ...data,
      });
      this.$emit("newComment");
      this.commentable.comments_count += 1;
    },
  },
  components: {
    AddText,
    Comment,
  },
};
</script>

<style lang="scss" scoped>
</style>
