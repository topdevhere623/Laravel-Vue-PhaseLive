<template>
    <modal name="modal-upload-video" :maxWidth="600" height="auto" @before-close="maybeReset" scrollable adaptive>
        <div class="modal modal-upload-video">
            <div class="modal-header">
                <close-icon class="float-right" @click.native="close"></close-icon>
            </div>
            <div class="modal-content">
                <h2>Upload Video</h2>
                <div v-show="!resumable || (resumable && !resumable.isUploading() && !uploadComplete)">
                    <h3>First, browse for your video or drag it into the zone below:</h3>
                    <uploader
                            @upload-start="uploadStart"
                            @upload-success="uploadSuccess"
                    />
                </div>
                <div class="upload-details" v-if="resumable">
                    <h3 v-show="resumable.isUploading()">
                        <i class="fa fa-spinner fa-spin"></i> Uploading <em>{{ resumable.files[0].fileName }}</em>
                    </h3>
                    <h3 v-show="uploadComplete">
                        <i class="fa fa-check-circle"></i> Upload Complete
                    </h3>
                    <div class="upload-progress">
                        <div class="progress-outer">
                            <div class="progress-inner" :style="'width: ' + resumable.progress() * 100 + '%'">
                                <span v-show="uploadComplete">{{ resumable.files[0].fileName }}</span>
                            </div>
                        </div>
                        <div class="progress-digits" v-show="!uploadComplete">
                            {{ uploadedSize }}MB / {{ fileSize }}MB ({{ Math.floor(resumable.progress() * 100) }}%)
                        </div>
                    </div>
                </div>
                <form v-if="resumable && !saved">
                    <h3>Now, provide some information about your video:</h3>
                    <table>
                        <tr>
                            <td>Title</td>
                            <td>
                                <input type="text" name="name" placeholder="Name"
                                       v-model="details.title"
                                       v-validate="'required|max:255'"
                                />
                                <span class="error-msg">{{ errors.first('name') }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>
                                <textarea name="description" rows="4" placeholder="Description"
                                          v-model="details.description"
                                ></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <ph-button @click.prevent.native="save" :loading="saving" :disabled="videoModel === null">Save</ph-button>
                            </td>
                        </tr>
                    </table>
                </form>
                <div v-if="resumable && saved">
                    <ph-panel type="success">
                        <div class="header">
                            Video Saved Successfully.
                        </div>
                        <p>
                            After your video is finished uploading and processing it will be available to view!
                        </p>
                    </ph-panel>
                    <ph-button size="large" @click.native="close">
                        Done
                    </ph-button>
                </div>
            </div>
        </div>
    </modal>
</template>

<script>
    import CloseIcon from 'global/close-icon';
    import Uploader from './uploader';

    export default {
        data () {
            return {
                resumable: null,
                uploadComplete: false,
                videoModel: null,
                saving: false,
                saved: false,
                details: {
                    title: '',
                    description: '',
                }
            }
        },
        computed: {
            uploadedSize: function() {
                return Math.floor(this.fileSize * this.resumable.progress());
            },
            fileSize: function() {
                return Math.floor(this.resumable.getSize() / 1000 / 1000)
            }
        },
        created: function() {

        },
        mounted: function() {

        },
        methods: {
            createVideo() {
                axios.post('/api/video/create').then(response => {
                    this.videoModel = response.data;
                });
            },
            uploadStart(resumable) {
                this.resumable = resumable;
                this.createVideo();
            },
            uploadSuccess() {
                this.uploadComplete = true;
            },
            save() {
                this.saving = true;
                axios.post('/api/video/save/' + this.videoModel.id, this.details).then(response => {
                    this.saved = true;
                }).finally(() => {
                    this.saving = false;
                });
            },
            maybeReset() {
              if (this.saved && this.details.title !== '') {
                this.reset()
              }
            },
            reset() {
                this.resumable = null;
                this.uploadComplete = false;
                this.videoModel = null;
                this.saving = false;
                this.saved = false;
                this.details = {
                    title: '',
                    description: '',
                };
            },
            close() {
                this.maybeReset()
                this.$modal.hide('modal-upload-video');
            }
        },
        components: {
            CloseIcon,
            Uploader,
        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";

    .close-icon{
        width: 50px!important;
        height: 50px!important;
    }
    
    .upload-progress {
        margin: 10px 0;
    }
    .progress-outer {
        border: 1px solid $color-blue;
        border-radius: 5px;
    }
    .progress-inner {
        background: $color-blue2;
        height: 25px;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .progress-digits {
        margin-top: 10px;
        text-align: center;
    }
    form {
        padding-left: 0;
        width: 100%;
        margin-bottom: 1em;
    }
    table {
        width: 100%;
    }
    td {
        padding: 0.8em 10px;
        vertical-align: top;
    }
    input, textarea {
        border: 1px solid $color-grey2;
        padding: 5px;
        border-radius: 2px;
    }
    .error-msg {
        position: absolute;
        font-size: 12px;
        color: red;
        margin-top: 3px;
    }
</style>
