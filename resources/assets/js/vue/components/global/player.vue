<template>
    <div class="player" ref="player" v-show="$store.state.player.status.set">
        <audio ref="audio"
               @loadedmetadata="loaded"
               @timeupdate="timeUpdate"
               @ended="ended"
        >
            <source :src="trackUrl" type="audio/mp3" v-if="$store.state.player.status.set">
        </audio>
        <div class="player" v-if="!expanded">
            <div class="controls">
                <div class="left">
                    <span class="control" @click="expandPlayer">
                        <i class="fa fa-expand-arrows-alt fa-fw" data-fa-transform="shrink-3"></i>
                    </span>
                    <span class="control volume-wrap">
                        <span class="control" v-show="!$store.state.player.status.muted" @click="toggleMute">
                            <i class="fa fa-volume-up fa-fw" data-fa-transform="shrink-3"></i>
                        </span>
                        <span class="control" v-show="$store.state.player.status.muted" @click="toggleMute">
                            <i class="fa fa-volume-off fa-fw" data-fa-transform="shrink-3"></i>
                        </span>
                        <div class="volume-bar-wrap" @mousedown="onBarMouseDown">
                            <div class="volume-bar" ref="bar">
                                <div class="volume"
                                     :style="{width: $store.state.player.status.muted ? 0 : `${Math.trunc(volume * 100)}%`,}"
                                ></div>
                            </div>
                        </div>
                    </span>
                    <span class="control" @click="toggleCart" :class="{ active : isInCart($store.state.player.track) }">
                        <i class="fa fa-shopping-cart" data-fa-transform="shrink-3"></i>
                    </span>

                </div>
                <div class="center">
                    <span class="control" @click="skipBack">
                        <i class="fa fa-step-backward"></i>
                    </span>
                    &nbsp;
                    <span class="fa-layers fa-fw" @click="togglePlayback">
                        <span class="control">
                            <i class="fa fa-fw fa-circle" data-fa-transform="grow-13" style="color:blue"></i>
                        </span>
                        <span v-show="!$store.state.player.status.playing">
                            <i class="fa fw-fw fa-play" data-fa-transform="shrink-3" style="color:white"></i>
                        </span>
                        <span v-show="$store.state.player.status.playing">
                            <i class="fa fw-fw fa-pause" data-fa-transform="shrink-3" style="color:white"></i>
                        </span>
                    </span>
                    &nbsp;
<!--                    <span class="control" @click="skipForward">-->
<!--                        <i class="fa fa-step-forward"></i>-->
<!--                    </span>-->
                </div>
                <div class="right">
                    <span @click="toggleRepeat" class="controls-repeat" :class="{ active : $store.state.player.repeat }">
                        <i class="fa fa-redo" data-fa-transform="shrink-3"></i>
                    </span>
                    <span @click="shuffle = !shuffle" class="controls-shuffle" :class="{ active : $store.state.player.shuffle }">
                        <i class="fa fa-random" data-fa-transform="shrink-3"></i>
                    </span>
                </div>
            </div>
            <div class="details" v-if="track.release">
                {{ track.release.uploader.name }} - {{ track.name }}
            </div>
            <div class="progress"
                 @click="progressClick"
                 @mousedown="startProgressDrag"
                 @mousemove="doProgressDrag"
                 @mouseup="endProgressDrag"
            >
                <div class="bar" :style="'width:' + ($store.state.player.status.position * 100) + '%;'"></div>
            </div>
        </div>
        <div v-else class="expanded">
            <div class="controls">
                <div class="left">
                    <span class="control" @click="expandPlayer">
                        <i class="fa fa-expand-arrows-alt fa-fw" data-fa-transform="shrink-3"></i>
                    </span>
                </div>
                <div class="right">
                    <span class="control" @click="toggleCart" :class="{ active : isInCart($store.state.player.track) }">
                        <i class="fa fa-shopping-cart" data-fa-transform="shrink-3"></i>
                    </span>
                    <like-button :likeable="track" @like="liked" @unlike="unliked" />
                    <share-button :shareable="track" />
                    <report-button :reportable="track" />
                </div>
            </div>
            <div class="details">
                {{ track.release.uploader.name }} - {{ track.name }}
            </div>
            <div>
                <avatar :src="track.release.image.files.medium.url" :size="250" :tile="true" :center="false" />
            </div>
            <div class="controls-bottom">
                <div class="controls">
                    <div class="left volume-wrap">
                        <span class="control" v-show="!$store.state.player.status.muted" @click="toggleMute">
                            <i class="fa fa-volume-up fa-fw" data-fa-transform="shrink-3"></i>
                        </span>
                        <span class="control" v-show="$store.state.player.status.muted" @click="toggleMute">
                            <i class="fa fa-volume-off fa-fw" data-fa-transform="shrink-3"></i>
                        </span>
                        <div class="volume-bar-wrap" @mousedown="onBarMouseDown">
                            <div class="volume-bar" ref="bar">
                                <div class="volume"
                                     :style="{ width: $store.state.player.status.muted ? 0 : `${Math.trunc(volume * 100)}%`}"
                                ></div>
                            </div>
                        </div>
                    </div>
                    <div class="center">
                        <span class="control" @click="skipBack">
                            <i class="fa fa-step-backward"></i>
                        </span>
                        &nbsp;
                        <span class="fa-layers fa-fw" @click="togglePlayback">
                            <span class="control">
                                <i class="fa fa-fw fa-circle" data-fa-transform="grow-13" style="color:blue"></i>
                            </span>
                            <span v-show="!$store.state.player.status.playing">
                                <i class="fa fw-fw fa-play" data-fa-transform="shrink-3" style="color:white"></i>
                            </span>
                            <span v-show="$store.state.player.status.playing">
                                <i class="fa fw-fw fa-pause" data-fa-transform="shrink-3" style="color:white"></i>
                            </span>
                        </span>
                        &nbsp;
<!--                        <span class="control" @click="skipForward">-->
<!--                            <i class="fa fa-step-forward"></i>-->
<!--                        </span>-->
                    </div>
                    <div class="right">
                        <span @click="toggleRepeat" class="controls-repeat" :class="{ active : $store.state.player.repeat }">
                            <i class="fa fa-redo" data-fa-transform="shrink-3"></i>
                        </span>
                        <span @click="shuffle = !shuffle" class="controls-shuffle" :class="{ active : $store.state.player.shuffle }">
                            <i class="fa fa-random" data-fa-transform="shrink-3"></i>
                        </span>
                    </div>
                </div>
                <div class="progress"
                     @click="progressClick"
                     @mousedown="startProgressDrag"
                     @mousemove="doProgressDrag"
                     @mouseup="endProgressDrag"
                >
                    <div class="bar" :style="'width:' + ($store.state.player.status.position * 100) + '%;'"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import { PlayerEvents } from "events";
    import ShareButton from "global/actions/share-button";
    import ReportButton from "global/actions/report-button";
    import LikeButton from "global/actions/like-button";

    const barHeight = 40

    export default {
        components: {
          ShareButton,
          ReportButton,
          LikeButton
        },
        data () {
            return {
                // DOM Elements
                audio: null,
                player: null,
                rect: null,
                expanded: false,
                type: '',
                volume: 0.5,
            }
        },
        computed: {
            ...mapGetters('cart', [
                'isInCart',
            ]),
          ...mapGetters({
            track: 'player/getTrack',
            trackType: 'player/getTrackByType'
          }),
          trackUrl() {
              const track = this.trackType(this.type)

              return track.files[this.type].url
          }
        },
        mounted() {
            this.audio = this.$refs.audio;
            this.player = this.$refs.player;

            this.audio.volume = this.volume
            /*
             * Event Listeners
             */
            // progress should be a number between 0 and 1 representing a percentage
            PlayerEvents.$on('setProgress', progress => {
                this.setProgress(progress);
            });
            PlayerEvents.$on('setTrack', data => {
                this.setTrack(data.track);
                this.type = data.type
            });
            PlayerEvents.$on('setTogglePlayback', () => {
                this.togglePlayback();
            });
          PlayerEvents.$on('pause', () => {
            this.pause();
          });
        },
        methods: {
            loaded() {
                this.$store.commit('player/setMaxTime', this.audio.duration);
            },
            expandPlayer() {
                this.expanded = !this.expanded
            },
            timeUpdate() {
                this.$store.commit('player/setCurrentTime', this.audio.currentTime);
                this.$store.commit('player/setPosition', this.$store.state.player.status.time.current / this.$store.state.player.status.time.max);
                PlayerEvents.$emit('broadcastTimeUpdated', this.$store.state.player.status.position);
                if(this.audio.paused)
                    PlayerEvents.$emit('broadcastPaused');
                else
                    PlayerEvents.$emit('broadcastPlayed');
            },
            ended() {
                this.audio.currentTime = 0;
                this.$store.commit('player/setPlaying', false);
                PlayerEvents.$emit('broadcastPaused');
            },
            togglePlayback() {
                if(this.audio.paused) {
                    this.play();
                } else {
                    this.pause();
                }
            },
            play() {
                this.$store.commit('player/setPlaying', true);
                this.audio.play();
                PlayerEvents.$emit('broadcastPlayed');
            },
            pause() {
                this.$store.commit('player/setPlaying', false);
                this.audio.pause();
                PlayerEvents.$emit('broadcastPaused');
            },
            toggleMute() {
                if(this.audio.muted) {
                    this.$store.commit('player/setMuted', false);
                    this.audio.muted = false;
                    PlayerEvents.$emit('broadcastUnmuted');
                } else {
                    this.$store.commit('player/setMuted', true);
                    this.audio.muted = true;
                    PlayerEvents.$emit('broadcastMuted');
                }
            },
            toggleRepeat() {
                //if(this.repeat) {
                if(this.$store.state.player.repeat) {
                    this.audio.loop = false;
                    this.$store.commit('player/setRepeat', false);
                } else {
                    this.audio.loop = true;
                    this.$store.commit('player/setRepeat', true);
                }
            },
            toggleCart() {
                if(this.isInCart(this.$store.state.player.track)) {
                    this.removeFromCart()
                } else {
                    this.addToCart()
                }
            },
            addToCart() {
                this.$store.dispatch('cart/addItem', this.$store.state.player.track);
            },
            removeFromCart() {
                this.$store.dispatch('cart/removeItem', this.$store.state.player.track);
            },
            progressClick(event) {
                let playerwidth = this.rect.right - this.rect.left;
                let clickLoc = event.pageX - this.rect.left;
                this.$store.commit('player/setPosition', clickLoc / playerwidth);
                this.setProgress(this.$store.state.player.status.position)
            },
            startProgressDrag() {
                this.$store.commit('player/setDragging', true);
            },
            doProgressDrag(event) {
                if(this.$store.state.player.status.dragging) {
                    this.progressClick(event);
                }
            },
            endProgressDrag() {
                this.$store.commit('player/setDragging', false);
            },
            // Requires artist, name. We will know more about the track object when the track API is done
            setTrack(track) {
                this.$store.commit('player/setTrack', track);
                this.audio.load();
                setTimeout(() => {
                    this.rect = this.player.getBoundingClientRect();
                }, 0);
            },
            setProgress(percent) {
                this.audio.currentTime = this.audio.duration * percent;
            },
            skipBack() {
                this.audio.currentTime = 0;
            },
            skipForward() {

            },
            setVolume (volume) {
                this.volume = volume
                this.audio.volume = volume
                if (volume > 0) {
                    this.audio.muted = false
                }
            },
            adjustVolume (e) {
                let percentage = ((barHeight + e.clientX - this.getElementViewLeft(this.$refs.bar)) / barHeight) - 1
                percentage = percentage > 0 ? percentage : 0
                percentage = percentage < 1 ? percentage : 1
                this.setVolume(percentage)
            },
            onBarMouseDown () {
                document.addEventListener('mousemove', this.onDocumentMouseMove)
                document.addEventListener('mouseup', this.onDocumentMouseUp)
            },
            onDocumentMouseMove (e) {
                let percentage = ((barHeight + e.clientX - this.getElementViewLeft(this.$refs.bar)) / barHeight) - 1
                percentage = percentage > 0 ? percentage : 0
                percentage = percentage < 1 ? percentage : 1
                this.setVolume(percentage)
            },
            onDocumentMouseUp (e) {
                document.removeEventListener('mouseup', this.onDocumentMouseUp)
                document.removeEventListener('mousemove', this.onDocumentMouseMove)
                let percentage = ((barHeight + e.clientX - this.getElementViewLeft(this.$refs.bar)) / barHeight) - 1
                percentage = percentage > 0 ? percentage : 0
                percentage = percentage < 1 ? percentage : 1
                this.setVolume(percentage)
            },
            getElementViewLeft (element) {
                let actualLeft = element.offsetLeft
                let current = element.offsetParent
                let elementScrollLeft
                while (current !== null) {
                    actualLeft += current.offsetLeft
                    current = current.offsetParent
                }
                elementScrollLeft = document.body.scrollLeft + document.documentElement.scrollLeft
                return actualLeft - elementScrollLeft
            },
            liked() {
                if (this.track.release) {
                    this.track.release.is_liked = true;
                } else {
                    this.track.is_liked = true;
                }
            },
            unliked() {
                if (this.track.release) {
                    this.track.release.is_liked = false;
                } else {
                    this.track.is_liked = false;
                }
            }
        },
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    .player {
        height: 50px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;

        .controls {
            display: flex;
            justify-content: space-between;
            padding: 10px 1em 0;
            text-align: center;
            background: #e6e6e6;

            .control {
                cursor: pointer;
            }

            .active {
                color: $color-blue;
            }

            .volume-wrap {
                position: relative;
                cursor: pointer;
                z-index: 0;
                &:hover .volume-bar-wrap {
                    display: block;
                }
                .volume-bar-wrap {
                    display: none;
                    position: absolute;
                    bottom: 15px;
                    left: -4px;
                    right: -4px;
                    height: 40px;
                    z-index: -1;
                    transition: all .2s ease;
                    &::after {
                        content: '';
                        position: absolute;
                        bottom: -16px;
                        left: 0;
                        right: 0;
                        height: 20px;
                        width: 75px;
                        background-color: #fff;
                        box-shadow: 0 0 2px 0 rgba(0, 0, 0, 0.07), 0 0 5px 0 rgba(0, 0, 0, 0.1);
                    }
                    .volume-bar {
                        position: absolute;
                        bottom: -8px;
                        left: 25px;
                        width: 40px;
                        height: 5px;
                        background: #aaa;
                        border-radius: 2.5px;
                        overflow: hidden;
                        z-index: 1;
                        .volume {
                            background: $color-blue;
                            position: absolute;
                            bottom: 0;
                            top: 0;
                            transition: width 0.1s ease, background-color .3s;
                            will-change: width;
                        }
                    }
                }
            }
        }
        .details {
            font-size: 10px;
            text-align: center;
        }
        .progress {
            cursor: pointer;
            .bar {
                height: 3px;
                background: $color-blue
            }
        }
        .expanded {
            z-index: 30;
            .controls-bottom {
                height: 40px;
                background: #e6e6e6;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }
            .details {
                height: 18px;
                padding-top: 7px;
            }
        }

      .avatar
      {
        width: 100% !important;
        background: #e6e6e6 !important;
      }
    }
</style>
