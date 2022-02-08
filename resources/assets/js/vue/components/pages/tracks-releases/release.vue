<template>
    <div>
        <track-release v-if="(release && release.status === 'live') || (release && app.user.all_permissions.includes('view admin dashboard'))" :item="release" />
        <div v-if="release && release.status !== 'live' && !app.user.all_permissions.includes('view admin dashboard')" class="center-content">
            This release has not been approved yet.
        </div>
        <spinner style="margin: 3em auto;" v-if="!release"
                 :animation-duration="1000"
                 :size="80"
                 color="black"
        />
    </div>
</template>

<script>
    import TrackRelease from './track-release';
    import { HalfCircleSpinner as Spinner } from 'epic-spinners'
    import {mapState} from "vuex";

    export default {
        data () {
            return {
                release: null,
            }
        },
        computed: {
            ...mapState(["app"]),
        },
        created: function() {
            this.fetchRelease();
        },
        methods: {
            fetchRelease() {
                axios.get('/api/release/' + this.$route.params.releaseid).then(response => {
                    this.release = response.data;
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
