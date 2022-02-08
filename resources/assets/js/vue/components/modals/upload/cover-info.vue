<template>
  <div class="edit-cover">
    <div class="upload-heading">
      <div>
        {{ isSingle ? 'Release Info' : 'Cover Info' }}
      </div>
    </div>
    <div class="upload-detail">
      <table style="width:300px; table-layout: fixed;">
        <tbody>
          <tr>
            <td class="test-image-dimension">
              <image-select
                v-model="cover.image"
                v-validate="'required|min-dimensions:300,300'"
                name="image"
                :currentSelected="selectedImage"
              />
            </td>
          </tr>
          <tr>
            <td>
              <span class="error-message">{{ errors.first("image") }}</span>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="upload-meta">
        <form>
          <table style="table-layout: fixed;">
            <tr>
              <td>Title*</td>
              <td>
                <input
                  type="text"
                  name="title"
                  placeholder="Album Name"
                  v-model="cover.title"
                  v-validate="'required|max:50'"
                />
                <span class="error-message">{{ errors.first("title") }}</span>
              </td>
            </tr>
            <tr>
              <td>Genres*</td>
              <td>
                <genre-select @change="coverGenresChanged" :populated="cover.genres" />
                <input
                  type="hidden"
                  name="genre"
                  placeholder="Genre"
                  v-validate="'required'"
                  :value="genreString"
                />
                <span class="error-message">{{ errors.first("genre") }}</span>
              </td>
            </tr>
            <tr>
              <td style="vertical-align: top;">Description*</td>
              <td>
                <textarea
                  name="description"
                  placeholder="Maximum 255 characters"
                  v-model="cover.description"
                  v-validate="'required|max:255'"
                ></textarea>
                <span class="error-message">{{ errors.first("description") }}</span>
              </td>
            </tr>
            <tr>
              <td>Class*</td>
              <td>
                <div class="select-wrapper">
                  <select name="class" v-model="cover.class" v-validate="'required'">
                    <option disabled value="">Select</option>
                    <option
                      :disabled="isDisabled(k)"
                      v-for="(v, k) in classes"
                      :value="k"
                      :selected="k === cover.class"
                      :key="k"
                    >
                      {{ v }}
                    </option>
                  </select>
                  <div class="select-controls">
                    <span>|</span>
                    <i class="fa fa-caret-down"></i>
                  </div>
                </div>
                <span class="error-message">{{ errors.first("class") }}</span>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <label>
                  <input
                    type="checkbox"
                    name="home_feature"
                    v-model="cover.home_feature"
                  />
                  Request homepage feature (sponsored)
                </label>
                <featured-spot-picker
                  v-if="cover.home_feature"
                  :featuredDates="cover.featuredDates"
                />
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <label>
                  <input
                    type="checkbox"
                    name="exclusivity"
                    v-model="cover.exclusivity"
                  />
                  Request exclusivity with phase
                </label>
                <span
                  class="exclusivity_trigger"
                  @click="showExclusivity = !showExclusivity"
                  v-if="!showExclusivity"
                >
                  [ read more ]
                </span>
                <p v-if="showExclusivity" class="exclusivity_info">
                  By ticking this box you are agreeing to offer your release
                  exclusively to phase, you will be contacted by a member of our
                  team prior to this release going live and in return you will
                  be offered an exclusive commission rate which is lower than
                  normal, if this release is listed for sale on any other
                  platform the exclusive benefit will be removed, <a href="/help" target="_blank">please read the FAQ</a>
                </p>
              </td>
            </tr>
            <tr class="responsive-class">
              <td>Release Date*</td>
              <td class="date-selects">
                <v-date-picker
                  v-model="cover.date"
                  :input-props="inputProps"
                  :min-date="new Date()"
                  class="form-control"
                  name="date"
                  v-validate="'required'"
                  :masks="{ input: 'DD/MM/YYYY' }"
                  :popover="{ placement: 'top-start' }"
                />
                <span class="error-message">{{ errors.first("date") }}</span>
              </td>
            </tr>

            <template v-if="isSingle">
              <tr>
                <td>Format*</td>
                <td class="form-td">
                  <ph-select
                    :key="1"
                    name="format"
                    title="Format"
                    v-validate="'required'"
                    v-model="currentTrack.format"
                    :options="{mp3: 'MP3', wav: 'WAV'}"
                  />
                  <span class="error-message">{{ errors.first('format') }}</span>
                </td>
              </tr>

              <tr v-show="currentTrack.format" :key="1">
                <td>Audio File* {{ `.${currentTrack.format}` }}</td>
                <td class="form-td">
                  <input
                    type="file"
                    @change="setTrackFile($event, currentTrack)"
                    name="file"
                    :accept="`.${currentTrack.format}`"
                    v-validate="'required'"
                    ref="fileInput"
                    :key="1"
                    v-if="!currentTrack.file"
                  />

                  <div class="selected-file" v-else>
                    <div class="selected-file__left">
                      <span><i class="fas fa-file"></i></span>
                      <p class="selected-file__name">{{ currentTrack.file.name }}</p>
                    </div>

                    <span @click="removeFile"><i class="fas fa-times"></i></span>
                  </div>

                  <span class="error-message">{{ errors.first('file') }}</span>
                </td>
              </tr>

              <tr>
                <td>Key*</td>
                <td class="form-td">
                  <ph-select
                    :key="1"
                    name="key"
                    title="Key"
                    v-validate="'required'"
                    v-model="currentTrack.key"
                    :options="{
                      a: 'A',
                      'a+': 'A#',
                      b: 'B',
                      c: 'C',
                      'c+': 'C#',
                      d: 'D',
                      'd+': 'D#',
                      e: 'E',
                      f: 'F',
                      'f+': 'F#',
                      g: 'G',
                      'g+': 'G#'
                    }"
                  />
                  <span class="error-message">{{ errors.first('key') }}</span>
                </td>
              </tr>

              <tr>
                <td>BPM*</td>
                <td class="form-td">
                  <input
                    type="number"
                    name="bpm"
                    v-model="currentTrack.bpm"
                    :value.sync="currentTrack.bpm"
                    :key="1"
                    v-validate="'required'"
                  />
                  <span class="error-message">{{ errors.first('bpm') }}</span>
                </td>
              </tr>
            </template>

            <tr>
              <td style="vertical-align: middle;">Price*</td>
              <td>
                <price-range
                  :min="isSingle ? 50 : 300"
                  :max="isSingle ? 300 : 3000"
                  :step="isSingle ? 1 : 100"
                  :value.sync="cover.price"
                  v-validate="'required'"
                  name="price"
                />
                <span class="error-message">{{ errors.first("price") }}</span>
              </td>
            </tr>
          </table>

          <div class="terms">
            <label>
              <table>
                <tr>
                  <td>
                    <input
                      type="checkbox"
                      name="agree_terms"
                      v-model="cover.terms"
                      v-validate="'required'"
                    />
                  </td>
                  <td>
                    By sharing, you confirm that your release complies with our
                    <router-link to="/terms" class="blue">Terms of use</router-link>
                    and you don’t infringe anyone else’s rights. If in doubt,
                    check our
                    <router-link to="/copyright" class="blue">Copyright</router-link>
                    information pages and
                    <router-link to="/faqs" class="blue">FAQs</router-link>
                    before uploading.
                    <span class="error-message">{{ errors.first("agree_terms") }}</span>
                  </td>
                </tr>
              </table>
            </label>
          </div>

          <ph-button
            size="medium"
            class="centered-inline submit-button"
            @click.native.prevent="attemptSubmit"
          >
            {{ isSingle ? 'Upload Release' : 'Add Tracks' }}
          </ph-button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import GenreSelect from "./genre-select";
import ImageSelect from "global/image-select";
import PriceRange from "global/price-range";
import FeaturedSpotPicker from "./featured-spot-picker";

export default {
  name: "cover-info",

  data() {
    return {
      inputProps: {
        placeholder: "Select Date",
      },
      showExclusivity: false,
      selectedImage: null,
    };
  },

  props: {
    cover: {
      type: Object,
      required: true,
    },
    trackCount: {
      type: Number,
    },
    currentTrack: {
      required: true,
    },
  },

  computed: {
    classes: function() {
      const storeClasses = this.$store.state.app.classes;
      let obj = {};
      for (let i = 0; i < storeClasses.length; i++) {
        obj[storeClasses[i].val] = storeClasses[i].name;
      }

      return obj;
    },
    isSingle() {
      return this.cover.class === 'single';
    },
    genreString() {
      return this.cover.genres.map(({ name }) => name).join();
    }
  },

  watch: {
    cover: {
      immediate: true,
      handler: function (v) {
        if (v.image) {
          const reader = new FileReader();
          reader.readAsDataURL(v.image[0]);
          reader.onload = () => {
            this.selectedImage = reader.result;
          };
        }
      }
    }
  },

  methods: {
    /**
     * When the user adds or removes a genre from the cover, update the array
     */
    coverGenresChanged: function(genres) {
      this.cover.genres = [];
      this.cover.genres = genres;

      // Manually validate the genre string to update validation state
      this.$validator.validate('genre', this.genreString);
    },

    setTrackFile: function(event, track) {
			const { files } = event.target;
			if (files && files[0]) {
				track.file = files[0];
			}
		},

		removeFile: function () {
			this.currentTrack.file = null;
		},

    /**
     * Update parent component with valid state
     */
    attemptSubmit: async function() {

      const valid = await this.$validator.validateAll();
      this.$emit("onSubmit", { valid, isSingle: this.isSingle });
    },
    isDisabled(item) {
      return item === "single" && this.trackCount > 1;
    },
  },

  components: {
    FeaturedSpotPicker,
    ImageSelect,
    PriceRange,
    GenreSelect,
  },
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";

.exclusivity_trigger {
  cursor: pointer;
  margin-left: 3px 0;
  font-weight: bold;
}

.exclusivity_info {
  margin: 10px 0;
  padding-left: 5px;
  line-height: 1.2;
}

.upload-heading {
  margin-bottom: 2em;

  div:first-child {
    font-size: 25px;
    font-weight: bold;
  }
  div:last-child {
    color: black;
    padding-top: 1em;
    font-size: 15px;
  }
}
.upload-detail {
  display: flex;

  @media (max-width: 990px) {
    flex-direction: column;
  }
}
.upload-meta {
  font-size: 12px;
  flex: 1;

  form {
    padding: 0;

    input,
    textarea {
      box-sizing: border-box;
      font-size: inherit;
    }
  }
  td.date-selects > div {
    display: inline-block;
    width: 32%;
  }
}
table {
  width: 100%;
}
td {
  font-size: 16px;
  padding: 0.5em 10px;

  @media (max-width: 505px) {
    padding: 0.5em 0;
  }
}

tr {
  margin-bottom: 22px;

  @media (max-width: 414px) {
    display: flex;
    flex-direction: column;
  }
}

input,
textarea {
  border: 1px solid $color-grey2;
  padding: 5px;
  border-radius: 2px;
}

.responsive-class {
  @media (max-width: 505px) {
    display: flex;
    flex-direction: column;
  }
}

.select-wrapper {
  position: relative;

  select {
    width: 100%;
    appearance: none;
    background: $color-2;
    border: none;
    padding: 3px 30px 4px 10px;
  }

  .select-controls {
    pointer-events: none;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: black;

    span {
      color: white;
    }
  }
}

.form-control {
  display: flex;
}

.submit-button {
  margin-top: 20px;
  display: inline-block !important;
}

.selected-file {
	align-items: center;
	display: flex;

	&__left {
		align-items: center;
		display: flex;
		margin-right: 12px;
	}

	&__name {
		margin-left: 12px;
	}
}
</style>
