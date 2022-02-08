<template>
    <modal name="modal-video-player" width="500px" height="auto" @beforeOpen="beforeOpen" @opened="opened" scrollable>
        <div class="modal modal-video-player">
            <div class="modal-header">
                <close-icon class="float-right" @click.native="$modal.hide('modal-video-player')"></close-icon>
            </div>
            <div class="modal-content">
                <h2>{{ video.title }}</h2>
                <video controls width="450" height="350" id="video" ref="video">
                    <source :src="video.asset.files.hls_playlist" type="application/x-mpegURL" />
                </video>
            </div>
        </div>
    </modal>
</template>

<script>
    import CloseIcon from 'global/close-icon';

    import 'mediaelement/full';

    export default {
        data () {
            return {
                video: {
                    title: null,
                    asset: {
                        files: {
                            hls_playlist: []
                        }
                    }
                }
            }
        },
        mounted: function() {

        },
        methods: {
            beforeOpen(event) {
                this.video = event.params.video;
            },

            opened() {
                new MediaElementPlayer(this.$refs.video, {
                    success: function () {

                    }
                });
            }
        },
        components: {
            CloseIcon,
        }
    }
</script>

<style lang="scss" scoped>
    //@import "~styles/helpers/_variables.scss";
    @import "~mediaelement/build/mediaelementplayer.min.css";
    h2 {
        margin-bottom: 0;
    }
    p {
        margin: 1em 0;
    }
</style>