<template>
	<div class="edit-track">
		<div class="upload-heading">
			<div>{{ currentTrackNumber }}. {{ currentTrack.title }}</div>
			<p class="subheading">Click and drag tracks to reorder them</p>
		</div>
		<div class="upload-detail">
			<div class="upload-meta">
				<form>
					<table class="track-info__table">
						<tr>
							<td>Title*</td>
							<td class="form-td">
								<input
									type="text"
									name="track_title"
									placeholder="Track Name"
									v-model="currentTrack.title"
									v-validate="'required|max:50'"
									data-vv-as="track title"
									:key="currentTrackNumber"
								/>
								<span class="error-message">{{ errors.first('track_title') }}</span>
							</td>
						</tr>

						<tr>
							<td>Format*</td>
							<td class="form-td">
								<ph-select
									:key="currentTrackNumber"
									name="format"
									title="Format"
									v-validate="'required'"
									v-model="currentTrack.format"
									:options="{ mp3: 'MP3', wav: 'WAV' }"
								/>
								<span class="error-message">{{ errors.first('format') }}</span>
							</td>
						</tr>

						<tr v-show="currentTrack.format" :key="currentTrackNumber">
							<td>Audio File* {{ `.${currentTrack.format}` }}</td>
							<td class="form-td">
								<input
									type="file"
									@change="setTrackFile($event, track)"
									name="file"
									:accept="`.${currentTrack.format}`"
									v-validate="'required'"
									ref="fileInput"
									:key="currentTrackNumber"
									v-if="!track.file"
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
									:key="currentTrackNumber"
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
									:key="currentTrackNumber"
									v-validate="'required'"
								/>
								<span class="error-message">{{ errors.first('bpm') }}</span>
							</td>
						</tr>

						<tr>
							<td>Release Date*</td>
							<td class="form-td">
								<v-date-picker
									v-model="currentTrack.date"
									:input-props="inputProps"
									:min-date="new Date()"
									class="form-control form-td release-input"
									name="track_date"
									v-validate="'required'"
									:masks="{input: 'DD/MM/YYYY'}"
									data-vv-as="track date"
									:key="currentTrackNumber"
									:popover="{ placement: 'top-start' }"
								/>
								<span class="error-message">{{ errors.first('track_date') }}</span>
							</td>
						</tr>

						<tr>
							<td style="vertical-align: middle;">Price*</td>
							<td class="form-td">
								<price-range
									:min="50"
									:max="300"
									:value.sync="currentTrack.price"
									v-validate="'required'"
									name="price"
									:key="currentTrackNumber"
									:step="1"
								/>
								<span class="error-message">{{ errors.first('price') }}</span>
							</td>
						</tr>
					</table>

					<ph-button
						size="medium"
						class="centered-inline submit-button"
						@click.native.prevent="attemptSubmit"
					>
						Upload release
					</ph-button>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
import PriceRange from "global/price-range";

export default {
	name: "track-info",

	data() {
		return {
			inputProps: {
				placeholder: "Select Date"
			}
		};
	},

	props: {
		currentTrack: {
			required: true
		},
		tracks: {
			type: Array,
			required: true
		},
		currentTrackNumber: {
			required: true
		},
    trackError :
        {
          required: true
        }
	},

	components: {
		PriceRange
	},

  watch: {
    // When the format changes we need to remove the file as it will no longer be valid
    'currentTrack.format': function (v) {
      if (v) {
        this.removeFile();
      }
    },

    // when the trackError value changes, run the check funtion to valiate the form
    'trackError': function(v)
    {
      if(v)
      {
        this.checkTrackError();
      }
    }
  },

	computed: {
		track: function () {
			return this.tracks.find(t => t.id === this.currentTrack.id);
		},
	},

  mounted: function(){
    this.checkTrackError();
  },

	methods: {
		setTrackFile: function(event, track) {
			const { files } = event.target;
			if (files && files[0]) {
				track.file = files[0];
			}
		},

    checkTrackError: function()
    {
      if(this.trackError)
      {
        this.$validator.validateAll();
        this.trackError= false;
      }
    },

		removeFile: function () {
			this.track.file = null;
		},

		/**
		 * Check the form is valid. If it is then allow it to be submitted
		 */
		attemptSubmit: async function() {
			const valid = await this.$validator.validateAll();

			if (valid) {
				this.$emit('onSubmit');
			}
		}
	}
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";
.track-info__table {
  table-layout: fixed;
}

.form-td {
	display: flex;
  flex-wrap: wrap;

	.select-wrapper {
		width: 100%;
	}
}

.release-input,
.price-range {
	width: 100%;
}

form {
	padding-left: 0;
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

.edit-track,
.upload-meta {
	flex: 1;
}

.upload-detail {
	display: flex;
	flex: 1;
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

.submit-button {
  margin-top: 20px;
  display: inline-block !important;
}

.subheading {
	margin-top: 20px;
}
</style>
