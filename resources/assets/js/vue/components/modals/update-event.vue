<template>
  <modal
    name="modal-update-event"
    width="800px"
    height="auto"
    scrollable
    adaptive
    @before-open="beforeOpen"
  >
    <div class="modal modal-create-event">
      <div class="modal-header">
        <close-icon
          class="float-right"
          @click.native="$modal.hide('modal-create-event')"
        ></close-icon>
      </div>
      <div class="modal-content">
        <h2>Update event</h2>
        <p></p>
        <div class="event-options">
          <div class="event-image">
            <avatar
              v-if="event && !editImage"
              :size="247"
              :src="event.image.files.medium.url"
              :tile="true"
            />
            <image-select
              v-model="data.image"
              v-validate="'min-dimensions:300,300'"
              name="image"
              v-if="editImage"
            />
            <div class="edit-image-button">
              <ph-button size="medium"  @click.native.prevent="editImage = !editImage" v-if="!editImage"
                >Change Image</ph-button
              >
            </div>
            <span class="error-msg">{{ errors.first("image") }}</span>
          </div>
          <div class="event-info">
            <form>
              <table>
                <tr>
                  <td>Title</td>
                  <td>
                    <input
                      type="text"
                      name="name"
                      placeholder="Name"
                      v-model="data.name"
                      v-validate="'required|max:255'"
                    />
                    <span class="error-msg">{{ errors.first("name") }}</span>
                  </td>
                </tr>
                <tr>
                  <td>Location</td>
                  <td>
                    <input
                      type="text"
                      name="location"
                      placeholder="Location"
                      v-model="data.location"
                      v-validate="'required|max:255'"
                    />
                    <span class="error-msg">{{
                      errors.first("location")
                    }}</span>
                  </td>
                </tr>
                <tr>
                  <td>URL</td>
                  <td>
                    <input
                      type="url"
                      name="url"
                      placeholder="URL (http://example.com)"
                      v-model="data.url"
                      v-validate="'required|url|max:255'"
                    />
                    <span class="error-msg">{{ errors.first("url") }}</span>
                  </td>
                </tr>
                <tr>
                  <td>Date</td>
                  <td>
                    <flat-pickr
                      v-model="data.date"
                      :config="datePicker"
                      class="form-control"
                      placeholder="Select date"
                      name="date"
                      v-validate="'required'"
                    />
                    <span class="error-msg">{{ errors.first("date") }}</span>
                  </td>
                </tr>
              </table>
            </form>
            <ph-button
              @click.native="submit"
              size="medium"
              :loading="submitting"
              >Submit</ph-button
            >
          </div>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import CloseIcon from "global/close-icon";
import ImageSelect from "global/image-select";
import { ModalEvents } from "../../event-bus";
import Avatar from "global/avatar";

export default {
  data() {
    return {
      event: "",
      data: {
        image: null,
        name: "",
        location: "",
        url: "",
        date: "",
      },
      submitting: false,
      datePicker: {
        altFormat: "F j, Y h:i K",
        altInput: true,
        dateFormat: "Z",
        enableTime: true,
      },
      editImage: false,
    };
  },
  created: function () {},
  mounted: function () {},
  methods: {
    beforeOpen({ params }) {
      this.initForm(params.event);
      this.event = params.event;
    },

    initForm(event) {
      this.data.name = event.name;
      this.data.location = event.location;
      this.data.url = event.url;
      this.data.date = event.date;
    },

    submit() {
      this.$validator.validateAll().then((passes) => {
        if (!passes) return;
        let data = new FormData();
        if(this.data.image) {
            data.append("image", this.data.image[0]);
        }
        data.append("name", this.data.name);
        data.append("location", this.data.location);
        data.append("url", this.data.url);
        data.append("date", this.data.date);

        // this.submitting = true;
        axios
          .post(`/api/event/${this.event.id}/update`, data)
          .then((response) => {
            this.$modal.hide("modal-update-event");
            this.$notify({
              group: "main",
              type: "success",
              title: "Event updated successfully",
            });
          })
          .finally(() => {
            this.submitting = false;
            ModalEvents.$emit("event-created");
          });
      });
    },
  },
  components: {
    CloseIcon,
    ImageSelect,
    Avatar,
  },
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";
.edit-image-button {
  display: flex;
  justify-content: center;
  margin: 20px 0;
}
h2 {
  margin-bottom: 0;

  @media (max-width: 414px) {
    margin-top: 1.5em;
  }
}
p {
  margin: 1em 0;
}
.event-options {
  display: flex;

  @media (max-width: 655px) {
    flex-direction: column;
  }
}
.event-info {
  margin-left: 20px;
  flex: 1;

  @media (max-width: 655px) {
    margin-left: 0px;
  }
}
form {
  padding-left: 0;
  width: 100%;
  margin-bottom: 1em;
}
table {
  width: 100%;
}

tr {
  @media (max-width: 414px) {
    display: flex;
    flex-direction: column;
  }
}

td {
  padding: 0.8em 10px;

  @media (max-width: 414px) {
    padding: 0.8em 3px;
  }
}
input,
textarea {
  border: 1px solid $color-grey2;
  padding: 5px;
  border-radius: 2px;

  @media (max-width: 414px) {
    width: 85%;
  }
}
.error-msg {
  position: absolute;
  font-size: 12px;
  color: red;
  padding-top: 4px;
}
</style>
