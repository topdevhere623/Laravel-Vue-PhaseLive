<template>
    <router-link class="track-tile" :to="getRouterObject(track)">
        <div class="track-tile-image">
            <avatar :tile="true" :size="size" :src="track.release.image.files.medium.url" :recent="track.is_recent"></avatar>
        </div>
        <div class="track-tile-text">
            {{ track.name }}
        </div>
    </router-link>
</template>

<script>
    import Avatar from 'global/avatar';
    export default {
        props: {
            size: Number,
            track: Object,
        },
        data () {
            return {

            }
        },
        created: function() {

        },
        components: {
            Avatar
        }
    }
</script>

<style lang="scss" scoped>
    .track-tile {
        text-decoration: none;
    }
    .track-tile-text {
        text-align: center;
        margin: 1em 0;
    }
</style>