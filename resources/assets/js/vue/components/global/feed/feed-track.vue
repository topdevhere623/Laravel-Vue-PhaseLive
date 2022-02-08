<template>
    <!-- :to="getRouterObject(item)"  -->
    <div :class="'masonry-item ' + item.component" 
        :style="`background-image:linear-gradient(to top, rgba(255,0,0,0), rgb(0, 0, 0)), url('${mutableTrack.release.image.files.medium.url}')`">
        <div class="masonry-inner">
            <div class="">
                <h4>Track</h4>
                <h2 style="color:#fff">{{ item.name }}</h2>
            </div>

            <div  style="display:flex;justify-content:space-between;">
                <ul class="list-unstyled simple-list">
                    <li>
                        Release:
                        <span>{{ item.release.name }}</span>
                    </li>
                    <li>
                        Artist:
                        <span>{{ item.release.uploader.name }}</span>
                    </li>
                    <li>
                        BPM:
                        <span>{{ item.bpm }}</span>
                    </li>
                </ul>
                <div class="">
                   
                    <!-- <span
                        class="p-player-control fa-layers fa-fw"
                        @click="togglePlayback"
                    >
                        <span>
                            <i
                                class="fa fa-fw fa-circle"
                                data-fa-transform="grow-14"
                                style="color:#33cc99"
                            ></i>
                        </span>
                        <span v-show="!playing">
                            <i
                                class="fa fw-fw fa-play"
                                data-fa-transform="shrink-6"
                                style="color:white"
                            ></i>
                        </span>
                        <span v-show="playing">
                            <i
                                class="fa fw-fw fa-pause"
                                data-fa-transform="shrink-6"
                                style="color:white"
                            ></i>
                        </span>
                    </span> -->
                </div>
            </div>
             <avatar-track
                        :show-image="false"
                        :size="70"
                        :tile="true"
                        :src="mutableTrack.release.image.files.medium.url"
                        :track="mutableTrack"
                    />
            <div
                class="p-item-track-progress clearfix"
                ref="trackProgress"
                @click="doClick"
                @mousedown="startDrag"
                @mousemove="doDrag"
                @mouseup="endDrag"
            >
                <div
                    class="p-item-track-progress-bar"
                    :style="'width: ' + track.progress + '%'"
                >
                    <div class="p-item-track-playhead"></div>
                </div>
            </div>

            <router-link
                :to="getRouterObject(item)"
                class="button foot_button mint small"
                >
                Track Details
                </router-link
            >
        </div>
    </div>
</template>

<script>
import { PlayerEvents } from "events";
import Actions from "global/actions/actions";
import ActionMenu from "global/actions/action-menu";
import AvatarTrack from "../avatar-track";

export default {
    components: {AvatarTrack},
    name: "DiscoveryTrack",
    props: { item: Object },
    data() {
        return {
            moment: window.moment,
            mutableTrack: this.item,
            track: {
                rect: null,
                progress: 0,
                dragging: false
            }
        };
    },
    mounted: function() {
        this.track.rect = this.$refs.trackProgress.getBoundingClientRect();
        PlayerEvents.$on("broadcastTimeUpdated", this.broadcastedTimeUpdated);
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
        }
    },
    methods: {
        thisTrackisLoaded() {
            return this.$store.state.player.track.id === this.mutableTrack.id;
        },
        togglePlayback() {
            if (!this.thisTrackisLoaded()) {
                PlayerEvents.$emit("setTrack", this.mutableTrack);
            }
            PlayerEvents.$emit("setTogglePlayback");
        },
        broadcastedTimeUpdated(trackPercentage) {
            if (this.thisTrackisLoaded())
                this.track.progress = trackPercentage * 100;
        },
        startDrag() {
            this.track.dragging = true;
        },
        endDrag() {
            this.track.dragging = false;
        },
        doDrag(event) {
            if (this.track.dragging) {
                this.doClick(event);
            }
        },
        doClick(event) {
            let playerwidth = this.track.rect.right - this.track.rect.left;
            let clickLoc = event.pageX - this.track.rect.left;
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
    }
};
</script>

<style lang="scss" scoped>
.feed-track {
    min-height: 204px;
    overflow: hidden;
    background: grey;

    .p-player-control {
        margin: 0px 23px 0px 0px;
        padding: 0px 0px 12px 0px;
    }

    .p-item-track-progress {
        margin: 8px 15px 0px 25px;
        padding-bottom: 1em;
    }

    .p-item-track-progress-bar {
        background: #444444;
    }

    .foot_button {
        margin-top: 12px;
        margin-left: 15px;
    }

    .p-item-track-playhead {
        background: #666666;
    }
}

.masonry-item h2 {
    color: #366efc;
}

ul.simple-list {
    color: #fff;
    font-size: 0.7rem;
    line-height: 1.6;
    margin-left: 15px;
    span {
        color: #9eefe1;
    }
}

.p-player-control {
    padding-right: 2em;
}
</style>
