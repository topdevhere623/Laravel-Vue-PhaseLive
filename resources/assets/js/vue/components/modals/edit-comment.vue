<template>
  <modal
    name="modal-edit-comment"
    width="700px"
    height="auto"
    scrollable
    @before-open="beforeOpen"
  >
    <div class="modal modal-comment">
      <div class="modal-header">
        <close-icon class="float-right" @click.native="onHide" />
      </div>
      <div class="modal-content">
        <div class="release-header">
          <div v-if="comment" class="release-content">
            <h2>{{ comment.name }}</h2>
            <p>{{ comment.description }}</p>
          </div>
        </div>
        <add-text
          type="editComment"
          :addTextAble="comment"
          @success="onCommentAdded"
        />
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "global/close-icon";
import Avatar from "global/avatar";
import AddText from "global/add-text/add-text";
import { UserEvents } from "events";


export default {
  components: {
    CloseIcon,
    AddText,
    Avatar,
  },

  data() {
    return {
      comment: ''
    };
  },

  methods: {
    beforeOpen(event) {
      this.comment = event.params.comment;
    },

    onHide() {
      this.$modal.hide("modal-edit-comment");
    },

    onCommentAdded(d) {
      this.$notify({
        group: "main",
        type: "success",
        title: "Comment updated",
      });

      UserEvents.$emit('comment-updated');

      this.onHide();
    },
  },
};
</script>

<style lang="scss" scoped>
.release-header {
  margin-bottom: 30px;
  display: flex;
  flex-direction: row;
  padding-right: 50px; // Prevents content flowing under close icon
}

.release-content {
  margin-left: 20px;
}
</style>