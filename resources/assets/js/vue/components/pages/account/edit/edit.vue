<template>
  <div>
    <ph-panel>
      <h2>Edit Info</h2>
      <hr />
      <table>
        <tr>
          <td>Bio</td>
          <td>
            <textarea
              name="bio"
              id="bio"
              cols="30"
              rows="10"
              v-model="form.bio"
              v-validate.disable="'max:500'"
              @keyup="bioChange"
            ></textarea>
            <span
              >{{ bioLength }} of {{ bioTotalLength }} characters used.</span
            >
            <span class="error-msg">{{ errors.first("bio") }}</span>
          </td>
        </tr>
        <!--                <tr>-->
        <!--                    <td>Phone</td>-->
        <!--                    <td>-->
        <!--                        <input-->
        <!--                            type="text"-->
        <!--                            name="phone"-->
        <!--                            data-vv-scope="phone"-->
        <!--                            v-validate.disable="'numeric'"-->
        <!--                            v-model="form.phone"-->
        <!--                        />-->
        <!--                        <span class="error-msg">{{-->
        <!--                            errors.first("form.phone")-->
        <!--                        }}</span>-->
        <!--                    </td>-->
        <!--                </tr>-->
        <tr>
          <td>Website</td>
          <td>
            <input type="text" name="website" id="website" v-model="form.web" />
          </td>
        </tr>
        <tr>
          <td>Youtube</td>
          <td>
            <input
              type="text"
              name="youtube"
              id="youtube"
              v-model="form.youtube"
            />
          </td>
        </tr>
        <tr>
          <td>Twitter</td>
          <td>
            <input
              type="text"
              name="twitter"
              id="twitter"
              v-model="form.twitter"
            />
          </td>
        </tr>
        <tr>
          <td>Facebook</td>
          <td>
            <input
              type="text"
              name="facebook"
              id="facebook"
              v-model="form.facebook"
            />
          </td>
        </tr>
        <tr>
          <td>Interests</td>
          <input
            type="hidden"
            name="interest genre"
            placeholder="Genre"
            ref="interest_genre_input"
          />
          <td>
            <genre-select
              @change="interestGenresChanged"
              :min="2"
              :max="4"
              tabindex="16"
              :disabled="submitting"
              :populated="app.user.interests"
              style="width:100%;"
            />
            <span class="error-msg">{{ errors.first("interest genre") }}</span>
          </td>
        </tr>
      </table>

      <div style="margin: 30px 0;">
        <ph-button size="medium" @click.native="save" :loading="submitting"
          >Save</ph-button
        >
      </div>
    </ph-panel>
  </div>
</template>

<script>
import { mapState } from "vuex";
import GenreSelect from "../../../modals/upload/genre-select";

export default {
  name: "edit",

  data() {
    return {
      form: {
        bio: "",
        phone: "",
        web: "",
        youtube: "",
        twitter: "",
        facebook: "",
        interests: [],
      },
      submitting: false,
      bioLength: 0,
      bioTotalLength: 500,
    };
  },

  computed: {
    ...mapState(["app"]),
    charactersLeft() {
      return this.bioLength - this.bioTotalLength;
    },
  },

  components: { GenreSelect },

  created() {
    this.form.bio = this.app.user.bio;
    this.form.phone = this.app.user.phone;
    this.form.web = this.app.user.social_web;
    this.form.youtube = this.app.user.social_youtube;
    this.form.twitter = this.app.user.social_twitter;
    this.form.facebook = this.app.user.social_facebook;

    if (this.form.bio) {
      this.bioLength = this.form.bio.length;
    }

    if (this.app.user.interests.length) {
      this.app.user.interests.forEach((genre) => {
        this.form.interests.push(genre.id);
      });
    }
  },
  methods: {
    interestGenresChanged(genres) {
      this.form.interests = [];
      genres.forEach((genre) => {
        this.form.interests.push(genre.id);
      });
    },
    bioChange(evt) {
      this.bioLength = this.form.bio.length;
      if (this.form.bio.length >= this.bioTotalLength) {
        if (evt.keyCode >= 48 && evt.keyCode <= 90) {
          evt.preventDefault();
          return;
        }
      }
    },
    save() {
      this.$validator.validate().then((passes) => {
        if (passes) {
          this.submitting = true;
          axios
            .post("/api/account/info", this.form)
            .then((response) => {
              this.submitting = false;
              this.$store.commit("app/setUser", response.data);
              this.$notify({
                group: "main",
                type: "success",
                title: "Successfully updated info",
              });
            })
            .catch((err) => {
              this.submitting = false;
              this.$notify({
                group: "main",
                type: "error",
                title: "Error: " + err,
              });
            });
        }
      });
    },
  },
};
</script>

<style lang="scss" scoped>
table {
  width: 100%;
}
td {
  padding: 15px 10px;
  vertical-align: middle;

  @media (max-width: 350px) {
    padding: 15px 2px;
    font-size: 14px;
  }
}
input:not([type="radio"]):not([type="checkbox"]),
textarea {
  width: 100%;
  box-sizing: border-box;
  padding: 5px;
}
.error-msg {
  color: #ff6e6e;
  position: absolute;
  font-size: 12px;
  margin-top: 5px;
}

input,
textarea {
  font-size: 16px;
  width: 100%;
}
</style>
