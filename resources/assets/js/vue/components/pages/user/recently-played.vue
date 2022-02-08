<template>
    <div class="page-content-padded">
        <!-- <aside class="sidebar-left">
            <sidebar-group
                title="Notifications"
                :view-all="true"
                :items="[]"
            ></sidebar-group>
        </aside> -->

        <div class="page-main">
            <h1 class="no-top">Recently Played</h1>
            <div v-for="track in tracks">
                <router-link
                    class="release-tile"
                    :to="{ name: 'track', params: { trackid: track.slug } }"
                >
                    <div class="recent-wrap">
                        <div>
                            <avatar-track
                                :size="100"
                                :tile="true"
                                :src="track.release.image.files.medium.url"
                            />
                        </div>
                        <div class="track-meta">
                            {{ track.name }}
                        </div>
                    </div>
                </router-link>
            </div>
        </div>

        <!-- <aside class="sidebar-right">
           
        </aside> -->
    </div>
</template>

<script>
    import store from "store";
    import { mapState } from "vuex";
    import SidebarGroup from "global/sidebar-group";

    import AvatarTrack from "../../global/avatar-track";

    export default {
        name: "followed",

        computed: {
            ...mapState(["app", "news"]),
        },

        data() {
            return {
                tracks: [],
            };
        },

        mounted() {
            this.tracks = this.app.user.plays;
        },

        components: {
            SidebarGroup,
            AvatarTrack,
        },
    };
</script>

<style lang="scss" scoped>
    .recent-wrap {
        display: flex;
        margin: 20px 0;
        align-items: center;

        .track-meta {
            padding: 0 30px;
        }
    }
</style>
