<template>
    <div>
        <release-tile
            :release="result"
            :size="150"
            v-if="result.type === 'release'"
        ></release-tile>
        <track-tile
            :track="result"
            :size="150"
            v-if="result.type === 'track'"
        ></track-tile>
        <artist-tile :user="result" :size="150" v-if="result.type === 'user'" />
    </div>
</template>

<script>
import ReleaseTile from "global/releases/release-tile";
import TrackTile from "global/releases/track-tile";
import ArtistTile from "global/artists/artist-tile";
    export default {
        props: ["result"],
        components: {
             ReleaseTile,
        TrackTile,
        ArtistTile,
        }
    };
</script>

<style></style>
