<template>
    <div class="video" v-if="video.asset && video.asset.files.video_thumbnail">
        <video controls width="100%" height="500" :id="'video' + video.id" :poster="video.asset.files.video_thumbnail.url">
            <source :src="video.asset.files.hls_playlist.url" :type="video.asset.files.hls_playlist.mime" />
        </video>
    </div>
</template>

<script>
    import 'mediaelement/full';

    export default {
        props: {
            video: {
                type: Object,
                required: true,
            }
        },
        data () {
            return {

            }
        },
        mounted: function() {
            new MediaElementPlayer(document.getElementById('video' + this.video.id), {
                success: function () {

                }
            });
        },
        methods: {

        },
        components: {

        }
    }
</script>

<style lang="scss" scoped>

</style>
