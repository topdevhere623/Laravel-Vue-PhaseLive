<template>
  <modal
    name="modal-delete-confirm"
    width="500px"
    height="auto"
    scrollable
    adaptive
    @before-open="beforeOpen"
  >
    <div class="modal modal-delete">
      <div class="modal-header">
        <close-icon
          class="float-right"
          @click.native="$modal.hide('modal-delete-confirm')"
        ></close-icon>
      </div>
      <div class="modal-content">
        <h2>{{ title }}</h2>
        <p>{{ message }}</p>

        <div class="save-button">
          <ph-button size="large" @click.native="onDelete" :loading="submitting"
            >Delete</ph-button
          >
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import { mapState } from "vuex";
import CloseIcon from "global/close-icon";
import { UserEvents, ModalEvents } from "events";

export default {
  data() {
    return {
      submitting: false,
      response: null,
      deleteable: {},
    };
  },
  created: function () {},
  mounted: function () {},
  computed: {
    ...mapState(["app"]),
    title() {
      switch (this.deleteable.type) {
        case "comment":
          return "Delete Comment";
          break;
        default:
          "Delete Confirm";
      }
    },
    message() {
      switch (this.deleteable.type) {
        case "comment":
          return "Are you sure you want to delete this comment?";
          break;
        case "event":
          return "Are you sure you want to delete this event?";
          break;
        default:
          "Are you sure ?";
          break;
      }
    },
  },
  methods: {
    beforeOpen(event) {
      this.deleteable = event.params.deleteable;
    },
    onDelete() {
      this.submitting = true;

      switch (this.deleteable.type) {
        case "comment":
          axios
            .post(`/api/social/comment/delete`, this.deleteable)
            .then((response) => {
              UserEvents.$emit("comment-deleted");
              this.$modal.hide("modal-delete-confirm");
              this.submitting = false;
            });
          break;
        case "event":
          axios
            .post(`/api/event/${this.deleteable.id}/delete`)
            .then((response) => {
              ModalEvents.$emit("event-created");
              this.$modal.hide("modal-delete-confirm");
              this.submitting = false;
            });
          break;
        default:
        // code block
      }
    },
  },
  components: {
    CloseIcon,
  },
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";
h2 {
  margin-bottom: 0;
}
p {
  margin: 1em 0;
}
textarea {
  box-sizing: border-box;
  border: 1px solid $color-grey2;
  padding: 5px;
  width: 100%;
  height: 50px;
}
.save-button {
  margin-top: 1em;
  text-align: center;
}
.error-msg {
  font-size: 70%;
  color: red;
}
</style>