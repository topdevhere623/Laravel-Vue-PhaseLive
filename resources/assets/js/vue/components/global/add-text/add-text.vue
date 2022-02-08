<template>
  <div class="add-text" v-if="app.user.loggedin">
    <div class="user-avatar">
      <avatar
        :size="90"
        v-if="app.user.avatar"
        :src="app.user.avatar.files.medium.url"
        :alt="app.user.avatar.alt"
      ></avatar>
    </div>
    <div class="main-actions" v-show="!submitting">
      <div class="upper" v-if="show[type].upper">
        <div class="action-name">
          <recipient-select
            ref="recipientSelector"
            v-if="type === 'newMessage'"
            @selected="setReceiver($event)"
            @unselected="clearReceiver($event)"
          />
          {{ text[type].name }}
        </div>
        <div
          class="action-name action-name--secondary"
          @click="$modal.show('modal-upload-video')"
          v-if="type === 'post'"
        >
          Upload Video
        </div>
        <div
          class="attachment-options"
          @click="imageUpload = !imageUpload"
          v-if="type === 'post'"
        >
          <div class="attachment-option action-name--secondary">
            <input
              class="file-input--hidden"
              type="file"
              accept="image/png,image/jpeg"
              @change="handleAttachmentChange"
            />
            <i class="fa fa-image"></i>
          </div>
        </div>
      </div>
      <div class="lower">
        <img
          :src="previewUrl"
          class="image-preview"
          @click="removeAttachment"
          v-if="previewUrl"
        />

        <div class="lower-text-input">
          <form>
            <textarea
              @keyup.ctrl.enter="submit"
              oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'
              rows="1"
              :placeholder="text[type].placeholder"
              name="message"
              v-model="message"
              v-validate="{max: 255}"
              data-vv-as="message"
            >
            </textarea>
          </form>
          <ph-button
            color="blue"
            size="medium"
            :loading="submitting"
            @click.native="submit"
            :disabled="isDisabled"
          >
            {{ text[type].button }}
            <template v-if="type==='post' && isDisabled" slot="tooltip">
              <p>Upload a photo or write a post message to submit</p>
            </template>
          </ph-button>
        </div>
      </div>
      <p class="error-message">
        {{ errors.first("message") }}
      </p>
    </div>
    <div class="main-actions" v-show="submitting">
      <spinner
        style="margin: 0 auto"
        :animation-duration="1000"
        :size="75"
        color="black"
      />
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import { RadarSpinner as Spinner } from "epic-spinners";

import Avatar from "global/avatar";
import PhButton from "global/ph-button";
import RecipientSelect from "./recipient-select";

export default {
  props: {
    type: {
      // Can be 'comment', 'post', 'message', 'newMessage', 'editComment'
      type: String,
      default: "comment",
    },
    addTextAble: {
      // Only required if text is being added to something e.g. commenting on a release, posting on a profile
      type: Object,
      required: false,
      //default: function() { return {} },
    },
    thread: {
      // Required only if type is 'message'
      required: false,
    },
  },
  mounted() {
    if (this.type === "editComment") {
      this.message = this.addTextAble.body;
    }
  },
  data() {
    return {
      message: "",
      attachment: null,
      submitting: false,
      previewUrl: null,
      newMessageReceiver: null,
      imageUpload: false,
      text: {
        comment: {
          name: "Comment",
          placeholder: "Type your comment here",
          button: "Comment",
        },
        post: {
          name: "Post",
          placeholder: "Type your status update here",
          button: "Post",
        },
        message: {
          name: "Message",
          placeholder: "Type your message here",
          button: "Send",
        },
        newMessage: {
          name: "",
          placeholder: "Type your message here",
          button: "Send",
        },
        editComment: {
          name: "Edit Comment",
          placeholder: "",
          button: "Update",
        },
      },
      show: {
        comment: {
          upper: false,
          options: false,
        },
        editComment: {
          upper: false,
          options: false,
        },
        post: {
          upper: true,
          options: true,
        },
        message: {
          upper: false,
          options: false,
        },
        newMessage: {
          upper: true,
          options: false,
        },
      },
    };
  },
  computed: {
    ...mapState(["app"]),
  isDisabled() {
      if (
        this.type === "newMessage" &&
        (!this.newMessageReceiver || this.message.length === 0)
      ) {
        return true;
      } else if(this.type === "post" &&
        (!this.imageUpload && this.message.length === 0)) {
        return true;
      } else {
        return false;
      }
    },
  },
  methods: {
    removeAttachment() {
      this.attachment = null;
      this.previewUrl = null;
    },
    handleAttachmentChange(e) {
      const file = e.target.files[0];
      if(file.type==='image/jpeg' || file.type==='image/png'){
        this.previewUrl = URL.createObjectURL(file);
        this.attachment = file;
      }else{
        this.$snotify.html(`
          <div class="snotifyToast__body" style='text-align:center;'>
            <div style='padding-top: 25px;'>
            <img src='/img/warning.svg' style='height:16px;width:16px;'/>
            <b style='font-size:18px;'>Only Jpeg and Png are allowed</b>
            </div>
          </div>
           `, {
          timeout: 3000,
          type:'error',
          position:'centerTop',
          showProgressBar: true,
          closeOnClick: false,
          pauseOnHover: true,
        });
      }
      
    },
    submit() {
      switch (this.type) {
        case "editComment":
          this.updateComment();
          break;
        case "comment":
          this.submitComment();
          break;
        case "message":
          this.submitMessage();
          break;
        case "post":
          this.submitPost();
          break;
        case "newMessage":
          this.submitNewMessage();
          break;
      }
    },
    updateComment() {
      //   this.submitting = true;
      axios
        .put(
          "/api/social/comment/" +
            this.addTextAble.type +
            "/" +
            this.addTextAble.id,
          {
            body: this.message,
          }
        )
        .then((response) => {
          this.$emit("success", response.data);
          this.message = "";
          this.submitting = false;
        });
    },
    submitComment() {
      this.submitting = true;
      this.$validator.validate().then((passes) => {
        if (passes) {
          axios
              .post(
                  "/api/social/comment/" +
                  this.addTextAble.type +
                  "/" +
                  this.addTextAble.id,
                  {
                    body: this.message,
                  }
              )
              .then((response) => {
                this.$emit("success", response.data);
                this.message = "";
                this.submitting = false;
              });
        }
        this.submitting = false
      })
    },
    submitMessage() {
      this.submitting = true;
      axios
        .post(`/api/thread/${this.thread.id}/reply`, {
          body: this.message,
        })
        .then((response) => {
          this.$emit("success", response.data);
          this.message = "";
          this.submitting = false;
        });
    },
    //Save new thread in the DB and reload messages
    submitNewMessage() {
      this.submitting = true;
      axios
        .post(`/api/thread`, {
          body: this.message,
          sender: this.app.user.id,
          receiver: this.newMessageReceiver.id,
        })
        .then((response) => {
          this.$emit("success", response.data);
          this.message = "";
          this.submitting = false;
          this.$refs.recipientSelector.selectedUser = null;
        });
    },
    submitPost() {
      this.$validator.validate().then((passes) => {
        if (passes) {
          const data = new FormData();
          data.append("body", this.message);
          if (this.attachment) {
            data.append("attachment", this.attachment);
          }
          data.append("target_id", this.addTextAble.id);

          this.submitting = true;
          axios.post("/api/user/posts/add", data).then((response) => {
            this.$emit("success", response.data.action);
            this.message = "";
            this.imageUpload = false;
            this.removeAttachment();
            this.submitting = false;
          });
        }
      })
    },
    //set receiver
    setReceiver(event) {
      this.newMessageReceiver = event;
    },
    //clear receiver
    clearReceiver() {
      this.newMessageReceiver = null;
    },
  },
  components: {
    Spinner,
    PhButton,
    Avatar,
    RecipientSelect,
  },
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";
.add-text {
  background: $color-grey;
  padding: 20px;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  font-size: 15px;
  font-weight: bold;
  margin-bottom: 1em;

  @media (max-width: 395px) {
    padding: 10px;
  }

  .user-avatar {
    margin-right: 20px;

    @media (max-width: 395px) {
      margin-right: 10px;
    }
  }

  .main-actions {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .lower-text-input {
    display: flex;
    align-items: center;
    width: 100%;
  }

  .image-preview {
    height: 75px;
    width: 75px;
    object-fit: cover;
    cursor: pointer;
  }

  .upper {
    display: flex;
    align-items: center;
    margin: -8px 0 10px;
  }
  .file-input {
    &--hidden {
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      opacity: 0;
      z-index: 9999;
    }
  }
  .action-name {
    padding: 4px 15px 4px 0;

    &--secondary {
      border-left: 1px solid white;
      cursor: pointer;
      padding-left: 15px;
    }
  }
  .attachment-options {
    font-size: 25px;
    display: flex;
    align-items: center;
    position: relative;
  }

  .lower {
    flex: 1;
    display: flex;
    background: white;
    border-radius: 20px;
    box-sizing: border-box;
    flex-direction: column;
    font-size: 13px;
    padding: 1em;
    align-items: flex-start;
    justify-content: center;
    font-weight: normal;
    min-height: 80px;

    @media (max-width: 550px) {
      display: grid;
      padding: 3px 0.5em;
      text-align: center;
    }

    form {
      flex: 1;
      padding-left: 0;
      padding-right: 1em;
      width: 100%;
      height: 98%;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    textarea {
      resize: none;

      @media (max-width: 550px) {
        text-align: center;
      }

      @media (max-width: 370px) {
        font-size: 10px;
      }

      @media (max-width: 330px) {
        font-size: 9px;
      }
    }
  }
}
</style>
