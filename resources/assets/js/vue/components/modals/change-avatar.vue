<template>
    <modal name="modal-change-avatar" width="600px" height="auto" scrollable>
        <div class="modal modal-change-avatar">
            <div class="modal-header">
                <close-icon class="float-right" @click.native="$modal.hide('modal-change-avatar')"></close-icon>
            </div>
            <div class="modal-content">
                <h2>Change Avatar</h2>
                <image-select name="image"
                              v-model="avatar"
                              v-validate="'required|min-dimensions:350,350'"
                              :min-width="350"
                              :min-height="350"
                />
                <div class="error-msg">
                    {{ errors.first('image') }}
                </div>
                <div class="save-button">
                    <ph-button size="large" @click.native="submit" :loading="uploading">Save</ph-button>
                </div>
            </div>
        </div>
    </modal>
</template>

<script>
    import { mapState } from 'vuex';
    import { UserEvents } from "events";

    import CloseIcon from 'global/close-icon';

    import ImageSelect from 'global/image-select';

    export default {
        data () {
            return {
                uploading: false,
                avatar: null,
            }
        },
        computed: mapState([
             'app',
        ]),
        created: function() {

        },
        mounted: function() {

        },
        methods: {
            submit() {
                this.$validator.validateAll().then(passes => {
                    if(passes) {
                        this.uploadAvatar();
                    }
                });
            },
            uploadAvatar() {
                let data = new FormData();
                data.append('avatar', this.avatar[0]);

                this.uploading = true;
                axios.post('/api/user/upload/avatar', data).then(response => {
                    this.uploading = false;
                    this.$store.commit('app/setUserAvatar', response.data);
                    UserEvents.$emit('avatar-updated', response.data);
                    this.$modal.hide('modal-change-avatar');
                }).catch(response => {
                    this.uploading = false;
                });
            }
        },
        components: {
            CloseIcon,
            ImageSelect
        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    .upload-image {
        margin: 0 auto;
    }
    .error-msg {
        text-align: center;
        font-size: 12px;
        color: red;
        padding-top: 4px;
    }
    .save-button {
        margin-top: 1em;
        text-align: center;
    }
</style>