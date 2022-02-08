<template>
  <modal name="modal-upload" width="85%" height="auto" scrollable adaptive>
    <div class="modal modal-upload">
      <div class="modal-header">
        <logo class="modal-logo centered-block" />
        <close-icon class="float-right" @click.native="closeModal"></close-icon>
      </div>

      <div class="modal-content">
        <div v-if="mode !== 'upload'" class="modal-content__header">
          <h1 class="centered-text modal-content__heading">Upload a new release</h1>
          <p class="centered-text upload-info">You can upload in either WAV or Mp3</p>
        </div>

        <upload-progress
          :upload="upload"
          v-else
        />

        <div class="upload-main" v-if="mode !== 'upload'">
          <p
            class="upload-info"
            v-if="
              app.user.tracks_count_this_month >= 3 &&
              !$can('create unlimited releases')
            "
          >
            You have already uploaded your track limit this month
          </p>
          <div class="upload-main" v-else>
            <div class="upload-nav" v-if="cover.class !== 'single'">
              <div class="draggable-container">
                <div
                  class="draggable-item cover"
                  :class="{ active: mode === 'cover' }"
                  @click="editCover"
                >
                  Cover
                </div>
                <template v-if="coverValid || cover.class === 'single'">
                  <draggable v-model="tracks" @update="updateTrackNumber">
                    <div
                      v-for="(track, index) in tracks"
                      :key="track.id"
                      class="draggable-item track"
                      :class="{
                        active:
                          mode === 'track' && currentTrack.id === track.id,
                      }"
                      @mousedown="editTrack(track.id)"
                    >
                      {{ index + 1 }}. {{ track.title || "New Track" }}
                      <div
                        class="track-delete"
                        @click="deleteTrack(track.id, index)"
                        v-if="tracks.length > 1"
                      >
                        <i class="fa fa-trash"></i>
                      </div>
                    </div>
                  </draggable>
                </template>
              </div>
              <div
                class="add-track"
                @click="addTrack"
                v-show="userCanUpload && coverValid && !maxTracks"
              >
                <i class="fa fa-plus-circle"></i>
              </div>
            </div>
            <div class="upload-input" :style="cover.class === 'single' ? { paddingLeft: '5em'} : null">
              <cover-info
                v-show="mode === 'cover'"
                :cover="cover"
                :trackCount="tracks.length"
                :currentTrack="currentTrack"
                @featuredDates="cover.featuredDates = data"
                @onSubmit="handleCoverSubmit"
              />

              <track-info
                v-if="mode === 'track' && coverValid"
                :currentTrack="currentTrack"
                :tracks="tracks"
                :currentTrackNumber="currentTrackNumber"
                :key="currentTrackNumber"
                :trackError="trackError"
                @onSubmit="validateFormData(true)"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import { BreedingRhombusSpinner } from "epic-spinners";
import { ModalEvents } from "../../event-bus";
import GenreSelect from "./upload/genre-select";
import CoverInfo from "./upload/cover-info";
import TrackInfo from "./upload/track-info";
import ImageSelect from "global/image-select";
import draggable from "vuedraggable";
import PriceRange from "global/price-range";
import PhButton from "global/ph-button";
import PhSelect from "global/ph-select";
import CloseIcon from "global/close-icon";
import Logo from "global/logo";
import { mapState } from "vuex";
import UploadProgress from './upload/upload-progress';

export default {
  data() {
    return {
      variables: window.variables,
      tracks: [],
      coverValid: false,
      trackError: false,
      genresString: "",
      mode: "cover",
      cover: {
        date: "",
        image: null,
        price: 0,
        title: "",
        class: "",
        genres: [],
        description: "",
        home_feature: false,
        featuredDates: [],
        exclusivity: false,
        terms: false,
      },
      currentTrack: null,
      currentTrackNumber: 0,
      idCounter: 0,
      releaseID: null,
      upload: {
        message: "",
        progress: 0,
      },
      datePicker: {
        altFormat: "Y-m-d h:i:s",
        altInput: true,
        dateFormat: "Z",
        enableTime: true,
      },
      maxTracks: false,
    };
  },
  computed: {
    ...mapState(["app"]),
    classes: function () {
      let storeClasses = this.$store.state.app.classes;
      let obj = {};
      for (let i = 0; i < storeClasses.length; i++) {
        obj[storeClasses[i].val] = storeClasses[i].name;
      }
      return obj;
    },
    userCanUpload() {
      return (
        this.$can("create unlimited releases") ||
        (!(this.app.user.tracks_count_this_month + this.tracks.length >= 3) &&
          !this.$can("create unlimited releases"))
      );
    },
  },
  watch: {
    'cover.class': function (v) {
      if (v === 'single') {
        if (!this.tracks.length) {
          this.addTrack();
        }

        this.currentTrack = this.tracks[0];
      }
    }
  },
  created: function () {
    this.editCover();
  },
  mounted: function () {
    ModalEvents.$on("resetUploadData", this.resetUploadState);
    ModalEvents.$on(
      "featuredDates",
      (dates) => (this.cover.featuredDates = dates)
    );
    //this.$modal.show('modal-upload')
  },
  updated() {
    if (this.cover.class === "single") {
      this.maxTracks = true;
    } else {
      this.maxTracks = false;
    }
  },
  methods: {
    /**
     * Show the cover editing view)
     */
    editCover: function () {
      this.mode = "cover";
    },

    /**
     * Setter for coverValid attribute
     */
    setCoverValid: function (valid) {
      this.coverValid = valid;
    },

    handleCoverSubmit({ valid, isSingle }) {
      this.setCoverValid(valid);
      if (valid) {
        // Show the track if this is vald
        if (this.userCanUpload) {
          // If its a single then just upload what we have
          if (isSingle) {
             this.initUpload();
          } else {
            // Check the user has permission to create tracks)
            if (this.tracks.length === 0) {
              // Only add a track if there isnt one already
              this.addTrack();
            }
            this.editTrack(1);
          }

        } else {
          this.$notify({
            group: "main",
            type: "error",
            title: "Unable to upload tracks",
          });
        }
      }
    },

    /**
     * Show the track editing view)
     * Load the track from the tracks array, based on the track ID, into the currentTrack
     * variable to populate the fields.
     *
     * @param trackid
     */
    editTrack: function (trackid) {
      if (this.coverValid) {
        this.mode = "track";
        this.currentTrack = _.find(this.tracks, function (track) {
          return track.id === trackid;
        });
        this.updateTrackNumber();
      }
    },
    /**
     * Set the current track number based on the position of the current track in the tracks array
     */
    updateTrackNumber: function () {
      this.currentTrackNumber = _.indexOf(this.tracks, this.currentTrack) + 1;
    },
    /**
     * Delete a track from the array.
     *
     * @param trackid
     * @param trackIndex
     */
    deleteTrack: function (trackid, trackIndex) {
      if (this.tracks[trackIndex - 1] !== undefined) {
        this.currentTrack = this.tracks[trackIndex - 1]; // Set the current track to the previous track
      } else if (this.tracks[trackIndex + 1] !== undefined) {
        this.currentTrack = this.tracks[trackIndex + 1]; // Set the current track to the next track
      }

      _.remove(this.tracks, function (track) {
        return track.id === trackid;
      });

      this.updateTrackNumber();
    },
    /**
     * Add a new empty track to the array
     */
    addTrack: function () {
      if (!this.maxTracks) {

          // if there is tracks, then run the validateFormData
          this.validateFormData(false);

          if(!this.trackError)
          {
            this.idCounter += 1;
            this.tracks.push({
              id: this.idCounter,
              title: null,
              description: null,
              format: null,
              key: null,
              bpm: null,
              price: null,
              file: null,
              home_feature: false,
              exclusivity: false,
            });
          }
        }
    },
    /**
     * When the user selects an audio file to use for a track, save it to the currentTrack
     *
     * @param event
     */
    setTrackFile: function (event, track) {
      var files = event.target.files;
      if (files && files[0]) {
        track.file = files[0];
      }
    },
    /**
     * When the user adds or removes a genre from a track, do something
     */
    trackGenresChanged: function (genres) {},

    /**
     * Validate tracks before submitting to form
     */
    validateFormData : function (uploadInit)
    {
      this.trackError = false;
      let trackFormValidate =  true;
      let errorTrackNumber;

      for (let i = 0; i < this.tracks.length; i++) {
        if(
            (this.tracks[i].title === '' || this.tracks[i].title === null )
            || (this.tracks[i].bpm === '' || this.tracks[i].bpm === null)
            || (this.tracks[i].key === '' || this.tracks[i].key === null || this.tracks[i].key === 0)
            || ( this.tracks[i].price === 0 || this.tracks[i].price === null)
            || (this.tracks[i].file === null)
        ){
          trackFormValidate = false;
          errorTrackNumber = this.tracks[i].id;
          break;
        }
      }

      if(!trackFormValidate)
      {
        this.trackError = true;
        this.editTrack(errorTrackNumber);
        this.$validator.validateAll();
        //this.$emit(false);
      }else{
        if(uploadInit)
        {
          this.initUpload();
        }
      }
    },

    /**
     * Set edit mode to 'cover' (show the uploading view), and initiate the upload process.
     */
    initUpload: function () {

        this.$validator.validateAll().then((passes) => {
          if (!passes) return;
          this.mode = "upload";

          this.createRelease()
              .then(() => {
                this.upload.progress = 100;
                this.upload.message = "Upload Complete!";
                this.$store.commit("app/incrementTrackCount");
                if (this.cover.home_feature && this.cover.featuredDates.length) {
                  this.$modal.show("featured-dates-payment", {
                    release: this.releaseID,
                    featuredDates: this.cover.featuredDates,
                  });
                  this.$modal.hide("modal-upload");
                }
              })
              .catch((err) => {
                this.mode = "cover";
                this.$notify({
                  group: "main",
                  type: "error",
                  title: "Error: Unable to upload release",
                });
              });
        });

    },

    /**
     * POST the server to create a release and upload the cover. Retrieve the release
     * ID and save it locally to use when uploading tracks
     */
    createRelease: function () {
      try {
        let data = new FormData();
        data.append("name", this.cover.title);
        for (let i = 0; i < this.cover.genres.length; i++) {
          data.append("genres[]", this.cover.genres[i].id);
        }
        data.append("description", this.cover.description);
        data.append("price", this.cover.price);
        data.append("class", this.cover.class);
        data.append("release_date", Date.parse(this.cover.date));
        data.append("image", this.cover.image[0]);

        for (let i = 0; i < this.tracks.length; i++) {
          data.append(`tracks[${i}][name]`, this.tracks[i].title ? this.tracks[i].title : this.cover.title);
          data.append(`tracks[${i}][bpm]`, this.tracks[i].bpm);
          data.append(`tracks[${i}][key]`, this.tracks[i].key);
          data.append(`tracks[${i}][price]`, this.tracks[i].price ? this.tracks[i].price : this.cover.price);
          data.append(`tracks[${i}][file]`, this.tracks[i].file);
        }

        this.upload.message = "Uploading cover";
        return new Promise((resolve, reject) => {
          axios
            .post("/api/release/create", data,
                {
                  headers: {
                    'Content-Type': 'multipart/form-data'
                  },
                  onUploadProgress: function( progressEvent ) {
                    this.upload.progress = parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ));
                  }.bind(this)
                }
            )
            .then((response) => {
              this.releaseID = response.data.id;
              resolve();
            })
            .catch((error) => {
              if (error && error.response) {
                if (typeof error.response.data === 'string') {
                  this.$notify({
                    group: "main",
                    type: "error",
                    title: error.response.data,
                  });
                } else {
                  this.$notify({
                    group: "main",
                    type: "error",
                    title: "Error: Something is wrong with your tracks",
                  });
                }
              }
              reject(error);
            });
        });
      } catch (e) {
        this.mode = "cover";
        this.$notify({
          group: "main",
          type: "error",
          title: "Error: Unable to upload release",
        });
      }
    },
    resetUploadState: function () {
      this.cover = {
        date: "",
        image: null,
        price: 0,
        title: "",
        class: "",
        genres: [],
        description: "",
        home_feature: false,
        featuredDates: [],
        exclusivity: false,
        terms: false,
      };
      this.releaseID = null;
      this.upload = {
        message: "",
        progress: 0,
      };
      this.tracks = [];
      this.mode = "cover";
      this.currentTrack = null;
      this.currentTrackNumber = 0;
      this.idCounter = 0;
    },
    closeModal: function () {
      this.resetUploadState();
      this.$modal.hide("modal-upload");
    },
  },
  components: {
    ImageSelect,
    draggable,
    PriceRange,
    GenreSelect,
    PhButton,
    PhSelect,
    CloseIcon,
    Logo,
    CoverInfo,
    TrackInfo,
    spinner: BreedingRhombusSpinner,
    UploadProgress,
  },
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";

.modal-logo {
  width: 185px;
}

.modal-content {
  padding: 0;
}

.modal-content__header {
  padding-bottom: 28px;
}

.modal-content__heading {
  margin-bottom: 12px;
}

.upload-buttons {
  display: flex;
  justify-content: center;
  text-align: center;

  button {
    width: 200px;
  }
}

upload-multi {
  align-items: center;
  display: flex;
  justify-content: center;
  margin-left: 3em;

  span {
    font-size: 70%;
  }
}

/*
  * Main Upload Area
 */
.upload-main {
  background: $color-grey;
  color: #000;
  display: flex;
  flex-wrap: wrap;
  padding: 2em 0;
  flex: 1;

  @media (max-width: 841px) {
    flex-direction: column;
    padding: 2em 2em;
  }

  @media (max-width: 547px) {
    padding: 0.5em 1em;
  }

  @media (max-width: 505px) {
    padding: 0.5em 0.5em;
  }

  @media (max-width: 335px) {
    padding: 0.5em 0.4em;
  }
}

.upload-nav {
  min-width: 200px;
  max-width: 250px;
}

.draggable-container {
  padding: 0 1em;

  @media (max-width: 841px) {
    padding: 1em 0em;
  }
}

.draggable-item {
  border-bottom: 1px solid $color-grey2;
  cursor: pointer;
  padding: 1em;

  &.cover {
    border-bottom-width: 2px;
    text-align: center;
  }
  &.track {
    padding-right: 40px;
    position: relative;
  }

  &.active {
    background: $color-blue2;
    color: white;
  }
}

.track-delete {
  align-items: center;
  bottom: 0;
  display: flex;
  padding-right: 15px;
  position: absolute;
  right: 0;
  top: 0;
}

.add-track {
  cursor: pointer;
  font-size: 200%;
  padding: 20px 0;
  text-align: center;
}

.upload-input {
  padding-right: 1em;
  flex: 1;

  &--spacing {
    padding-left: 5em;
  }

  button {
    display: block;
    margin: 0 auto;
  }
}

table {
  width: 100%;
}

td {
  padding: 0.5em 10px;
}

input,
textarea {
  border: 1px solid $color-grey2;
  padding: 5px;
  border-radius: 2px;
}

.terms {
  color: black;
  font-size: 16px;
  margin: 2em 0;
}

.error-msg {
  font-size: 12px;
  color: red;
  margin-top: 5px;
  display: block;
}

h1 {
  @media (max-width: 414px) {
    font-size: 34px !important;
  }
}
</style>
