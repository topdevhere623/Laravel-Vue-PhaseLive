<template>
  <div class="my-account-responsive">
    <ph-panel v-if="!app.user.approved_at" id="approved" class="">
      <p>This account is waiting for approval</p>
    </ph-panel>
    <ph-panel v-if="app.user.status === 'frozen'">
      <p>Your account is currently frozen</p>
    </ph-panel>
    <ph-panel id="email">
      <h2>Email Address</h2>
      <hr />
      <table>
        <tr>
          <td>Your Email</td>
          <td>{{ app.user.email }}</td>
        </tr>
        <tr>
          <td>New Email</td>
          <td>
            <input
              type="email"
              name="email-address"
              data-vv-scope="form-email"
              v-validate.disable="'required|email'"
              v-model="email.address"
              placeholder="New Email"
            />
            <span class="error-msg">{{
              errors.first("form-email.email-address")
            }}</span>
          </td>
        </tr>
      </table>

      <ph-button
        size="medium"
        @click.native="saveEmail"
        :loading="email.submitting"
        >Save</ph-button
      >
    </ph-panel>
    <notifications />
    <ph-panel id="password">
      <h2>Password</h2>
      <hr />
      <table>
        <tr>
          <td>Current Password</td>
          <td>
            <input
              type="password"
              name="password-current"
              data-vv-scope="form-password"
              v-validate.disable="'required'"
              v-model="password.current"
              placeholder="Current Password"
            />
            <span class="error-msg">{{
              errors.first("form-password.password-current")
            }}</span>
          </td>
        </tr>
        <tr>
          <td>New Password</td>
          <td>
            <input
              type="password"
              name="password-new"
              data-vv-scope="form-password"
              v-validate.disable="{ required: true }"
              v-model="password.new"
              placeholder="New Password"
            />
            <span class="error-msg">{{
              errors.first("form-password.password-new")
            }}</span>
          </td>
        </tr>
        <tr v-if="password.new">
          <td>Confirm Password</td>
          <td>
            <input
              type="password"
              name="password-confirm"
              data-vv-scope="form-password"
              v-validate.disable="{
                is: password.new,
                required: true,
                max: 255,
              }"
              v-model="password.confirm"
              placeholder="Confirm Password"
            />
            <span class="error-msg">{{
              errors.first("form-password.password-confirm")
            }}</span>
          </td>
        </tr>
      </table>

      <ph-button size="medium" @click.native="savePassword" :loading="password.submitting">Save</ph-button>
    </ph-panel>
    <ph-panel id="audio">
      <h2>Audio Preferences</h2>
      <hr />
      <h3>Default Download Format</h3>
      <div class="checkbox-container">
        <label>
          <input
            type="radio"
            name="audio-format"
            value="mp3"
            v-model="audio.format"
          />
          MP3
        </label>
      </div>
      <div class="checkbox-container">
        <label>
          <input
            type="radio"
            name="audio-format"
            value="wav"
            v-model="audio.format"
          />
          WAV
        </label>
      </div>
      <ph-button size="medium" @click.native="saveAudio">Save</ph-button>
    </ph-panel>
    <billing />
    <subscriptions />
    <manage />
  </div>
</template>

<script>
import { mapState } from "vuex";
import { UserEvents } from "events";

import ErrorMessages from "./error-messages";

import PhButton from "global/ph-button";
import AccountMenu from "../account-menu";

import Notifications from "./notifications";
import Billing from "./billing";
import Subscriptions from "./subscriptions/subscriptions";
import Manage from "./manage";

export default {
  data() {
    return {
      email: {
        submitting: false,
        address: "",
      },
      password: {
        submitting: false,
        current: "",
        new: "",
        confirm: "",
      },
      audio: {
        submitting: false,
        format: "mp3",
      },
    };
  },
  computed: {
    ...mapState(["app"]),
  },
  created: function() {
    this.$validator.localize("en", {
      custom: ErrorMessages,
    });
    UserEvents.$emit("updateTitle", "My Account");
  },
  methods: {
    saveEmail() {
      this.$validator.validateAll("form-email").then((passes) => {
        if (passes) {
          this.email.submitting = true;
          axios.post("/api/account/email", this.email).then((response) => {
            this.email.submitting = false;
            this.$store.commit("app/setUser", response.data);
            this.email.address = "";
            this.$notify({
              group: "main",
              type: "success",
              title: "Successfully saved email preferences",
            });
          });
        }
      });
    },
    savePassword() {
      this.$validator.validateAll("form-password").then((passes) => {
        if (passes) {
          this.password.submitting = true;
          axios
            .post("/api/account/password", this.password)
            .then((response) => {
              this.$store.commit("app/setUser", response.data);
              this.$notify({
                group: "main",
                type: "success",
                title: "Successfully updated password",
              });
              this.resetForms();
              this.password.submitting = false;
            });
        }
      });
    },
    saveAudio() {
      this.$validator.validateAll("form-audio");
    },
    resetForms() {
      this.email = {
        submitting: false,
        address: "",
      };
      this.password = {
        submitting: false,
        current: "",
        new: "",
        confirm: "",
      };
      this.audio = {
        submitting: false,
        format: "mp3",
      };
    },
  },
  components: {
    AccountMenu,
    PhButton,
    Notifications,
    Billing,
    Subscriptions,
    Manage,
  },
};
</script>

<style lang="scss" scoped>
.my-account-responsive {
  @media (max-width: 450px) {
    width: 90%;
  }

  @media (max-width: 400px) {
    width: 85%;
  }

  @media (max-width: 380px) {
    width: 80%;
  }

  @media (max-width: 360px) {
    width: 75%;
  }

  @media (max-width: 340px) {
    width: 70%;
  }
}

h3 {
  text-decoration: underline;
}
table {
  width: 100%;
}
td {
  padding: 15px 10px;
  vertical-align: middle;

  @media (max-width: 415px) {
    padding: 15px 5px;
    font-size: 12px;
  }
}
input:not([type="radio"]):not([type="checkbox"]) {
  width: 70%;
  box-sizing: border-box;
  padding: 5px;

  @media (max-width: 1024px) {
    width: 80%;
  }
}
.error-msg {
  color: #ff6e6e;
  position: absolute;
  font-size: 12px;
  margin-top: 5px;
}
.checkbox-container {
  margin: 1em 0;
}
.approved {
  background: red !important;
  p {
    text-decoration: none;
    text-transform: uppercase;
  }
}
</style>
