<template>
    <div>
        <track-release v-if="track && track.status === 'approved'" :item="track" />
        <div v-if="track && track.status !== 'approved'" class="center-content">
            This track has not been approved yet.
        </div>
        <spinner style="margin: 3em auto;" v-if="!track"
                 :animation-duration="1000"
                 :size="80"
                 color="black"
        />
    </div>
</template>

<script>
    import TrackRelease from './track-release';
    import { HalfCircleSpinner as Spinner } from 'epic-spinners'

    export default {
        data () {
            return {
                track: null,
            }
        },
        created: function() {
            this.fetchTrack();
        },
        methods: {
            fetchTrack() {
                axios.get('/api/track/' + this.$route.params.trackid).then(response => {
                    this.track = response.data;
                });
            }
        },
        components: {
            TrackRelease,
            Spinner,
        }
    }
</script>

<style lang="scss" scoped>
.center-content {
    display: flex;
    width: 100vw;
    height: 50vh;
    justify-content: center;
    align-items: center;
}
</style>
