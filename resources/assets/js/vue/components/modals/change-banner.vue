<template>
    <modal name="modal-change-banner" width="600px" height="auto" scrollable>
        <div class="modal modal-change-banner">
            <div class="modal-header">
                <close-icon class="float-right" @click.native="$modal.hide('modal-change-banner')"></close-icon>
            </div>
            <div class="modal-content">
                <h2>Change Banner</h2>
                <image-select
                    name="banner"
                    v-model="banner"
                    v-validate="'required|min-dimensions:800,500'"
                    :min-width="800"
                    :min-height="500"
                />
                <div class="error-msg">
                    {{ errors.first('banner') }}
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
                banner: null,
            }
        },
        computed: mapState([
            'app',
        ]),
        methods: {
            submit() {
                this.$validator.validateAll().then(passes => {
                    if(passes) {
                        this.uploadBanner();
                    }
                });
            },
            uploadBanner() {
                let data = new FormData();
                data.append('banner', this.banner[0]);

                this.uploading = true;
                axios.post('/api/user/upload/banner', data).then(response => {
                    this.uploading = false;
                    this.$store.commit('app/setUserBanner', response.data);
                    UserEvents.$emit('banner-updated', response.data);
                    this.$modal.hide('modal-change-banner');
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