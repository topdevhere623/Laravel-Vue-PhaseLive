<template>
    <div class="p-item">
        <div class="p-item-image">
            <router-link :to="getRouterObject(mutableTrack)"> </router-link>
            <avatar-track
                :size="130"
                :tile="true"
                :labels="labels"
                :src="mutableTrack.release.image.files.medium.url"
                :track="mutableTrack"
                :recent="mutableTrack.is_recent"
            />
        </div>
        <div class="p-item-main">
            <div class="p-item-detail">
                <div class="p-item-title">
                    <router-link
                        :to="getRouterObject(mutableTrack)"
                        style="text-decoration: none;"
                    >
                        <span>{{ mutableTrack.name }}</span>
                    </router-link>
                    <!-- <play-pause-button :track="mutableTrack" /> -->
                </div>
                <div class="release-description">
                    {{ mutableTrack.release.uploader.name }}
                </div>
            </div>
            <div
                class="p-item-track-progress"
                ref="trackProgress"
                @click="doClick"
                @mousedown="startDrag"
                @mousemove="doDrag"
                @mouseup="endDrag"
            >
                <div
                    class="p-item-track-progress-bar-background"
                ></div>
                <div
                    class="p-item-track-progress-bar"
                    :style="'width: ' + defaultTrack.progress + '%'"
                >
                    <div class="p-item-track-playhead"></div>
                </div>
            </div>
            <div class="p-item-meta">
                <actions
                    :actionable="mutableTrack"
                    @like="liked"
                    @unlike="unliked"
                />
                <div class="p-item-time">
                    {{ moment(mutableTrack.created_at).fromNow() }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { PlayerEvents } from "events";

import Actions from "global/actions/actions";
import ActionMenu from "global/actions/action-menu";
import AvatarTrack from "../../global/avatar-track";

export default {
    props: {
        track: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            moment: window.moment,
            mutableTrack: this.track,
            defaultTrack: {
                rect: null,
                progress: 0,
                dragging: false
            }
        };
    },
    computed: {
        playing: function() {
            return (
                this.$store.state.player.status.playing &&
                this.thisTrackisLoaded()
            );
        },
        progress: function() {
            if (this.thisTrackisLoaded()) {
                return this.$store.state.player.status.position * 100;
            }
        },
        labels: function() {
            // tl: {
            //     text: 'pending',
            //         color: 'orange'
            // },
            let labels = {};
            if (this.isNew(this.defaultTrack)) {
                labels["tr"] = {
                    text: "new",
                    color: "blue"
                };
            }
            return labels;
        }
    },
    mounted: function() {
        this.defaultTrack.rect = this.$refs.trackProgress.getBoundingClientRect();

        PlayerEvents.$on("broadcastTimeUpdated", this.broadcastedTimeUpdated);
    },
    methods: {
        thisTrackisLoaded() {
            if (this.$store.state.player.track) {
                return (
                    this.$store.state.player.track.id === this.mutableTrack.id
                );
            }

            return false;
        },
        togglePlayback() {
            if (!this.thisTrackisLoaded()) {
                PlayerEvents.$emit("setTrack", this.mutableTrack);
            }
            PlayerEvents.$emit("setTogglePlayback");
        },
        broadcastedTimeUpdated(trackPercentage) {
            if (this.thisTrackisLoaded())
                this.defaultTrack.progress = trackPercentage * 100;
        },
        startDrag() {
            this.defaultTrack.dragging = true;
        },
        endDrag() {
            this.defaultTrack.dragging = false;
        },
        doDrag(event) {
            if (this.defaultTrack.dragging) {
                this.doClick(event);
            }
        },
        doClick(event) {
            let playerwidth =
                this.defaultTrack.rect.right - this.defaultTrack.rect.left;
            let clickLoc = event.pageX - this.defaultTrack.rect.left;
            let percentage = clickLoc / playerwidth;
            PlayerEvents.$emit("setProgress", percentage);
        },
        liked() {
            this.mutableTrack.is_liked = true;
            this.mutableTrack.likes_count += 1;
        },
        unliked() {
            this.mutableTrack.is_liked = false;
            this.mutableTrack.likes_count -= 1;
        }
    },
    components: {
        Actions,
        ActionMenu,
        AvatarTrack
    }
};
</script>

<style lang="scss" scoped>
</style>
