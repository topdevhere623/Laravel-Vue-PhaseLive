<template>
    <div class="page-content-padded">
        <div class="page-main page-track-release">
            <div class="main-info">
                <router-link :to="{ name: 'release', params: { releaseid: track.release.slug }}" v-if="track">
                    <div class="release-image">
                        <div class="release-label">
                            Release
                        </div>
                        <avatar
                            :src="image.files.medium.url"
                            :size="300"
                            :tile="true"
                            :center="false"
                        />
                    </div>
                </router-link>
                <div class="release-image" v-else>
                    <avatar
                        :src="image.files.medium.url"
                        :size="300"
                        :tile="true"
                        :center="false"
                    />
                </div>
                <div class="item-info">
                    <div class="item-info-upper">
                        <div class="item-info-upper-left">
                            <h1>
                                <play-pause-button
                                    v-if="track"
                                    :track="track"
                                    :size="3"
                                />
                                {{ item.name }}
                            </h1>
                            <div class="artists-genres">
                                <span v-if="release"
                                    >{{
                                        $store.getters["app/getClassByKey"](
                                            release.class
                                        ).name
                                    }}
                                </span>
                                <span v-if="track">Track </span>
                                by
                                <span v-if="release" class="item">{{
                                    release.uploader.name
                                }}</span>
                                <!--                                by <span class="item">Artist 1,</span> <span class="item">Artist 2,</span> <span class="item">Artist 3</span>-->
                                <span v-if="release"
                                    >in
                                    <span
                                        v-for="(genre, index) in item.genres"
                                        class="item"
                                        >{{ genre.name
                                        }}<span v-if="item.genres[index + 1]"
                                            >,
                                        </span></span
                                    ></span
                                ><br />
                                <span v-if="release">
                                    Uploaded by
                                    <router-link
                                        :to="getRouterObject(release.uploader)"
                                        >{{
                                            release.uploader.name
                                        }}</router-link
                                    >
                                </span>
                                <span v-if="track">
                                    Uploaded by
                                    <router-link
                                        :to="
                                            getRouterObject(
                                                track.release.uploader
                                            )
                                        "
                                        >{{
                                            track.release.uploader.name
                                        }}</router-link
                                    >
                                </span>
                            </div>
                            <p class="release-date" v-if="release">
                                Release Date
                                <span class="date">{{
                                    moment(release.release_date).format(
                                        "YYYY-MM-DD"
                                    )
                                }}</span>
                            </p>
                            <p class="release-description" v-if="release">
                                {{ release.description }}
                            </p>
                            <add-to-cart-button :product="item" v-if="release && !!(release.tracks.length || 0)" />
                        </div>
                        <div class="item-info-upper-right">
                            <social-sharing inline-template>
                                <span>
                                    <network network="twitter">
                                        <i
                                            class="fab fa-twitter-square"
                                            style="cursor: pointer;"
                                        ></i>
                                    </network>
                                    <network network="facebook">
                                        <i
                                            class="fab fa-facebook"
                                            style="cursor: pointer;"
                                        ></i>
                                    </network>
                                </span>
                            </social-sharing>
                            <like-button
                                :likeable="item"
                                @like="liked"
                                @unlike="unliked"
                            />
                            <share-button :shareable="item" />
                            <report-button :reportable="item" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="metadata" v-if="release">
                <h2>Tracks</h2>
                <track-list :tracks="release.tracks" />
            </div>
            <div class="metadata" v-if="track">
                <h2>Track Info</h2>
                <table class="meta-table">
                    <tr>
                        <th>Duration</th>
                        <th>BPM</th>
                        <th>Key</th>
                        <th>Genres</th>
                        <th>Release Date</th>
                    </tr>
                    <tr>
                        <td>
                            {{
                                moment()
                                    .startOf("day")
                                    .seconds(track.length)
                                    .format("mm:ss")
                            }}
                        </td>
                        <td>{{ track.bpm }}</td>
                        <td
                            v-html="
                                $store.getters['app/getKeyByKey'](track.key)
                                    .name
                            "
                        ></td>
                        <td>
                            <span v-for="(genre, index) in item.genres"
                                >{{ genre.name
                                }}<span v-if="item.genres[index + 1]"
                                    >,
                                </span></span
                            >
                        </td>
                        <td>
                            {{
                                moment(track.release.release_date).format(
                                    "YYYY-MM-DD"
                                )
                            }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="comments">
                <comments-container :commentable="item" />
            </div>
        </div>
        <!-- <aside class="sidebar-right">
            <sidebar-group title="Related" :items="[]"></sidebar-group>
        </aside> -->
    </div>
</template>

<script>
import SidebarGroup from "global/sidebar-group";

import PlayPauseButton from "global/play-pause-button";
import TrackList from "global/track-list";
import AddToCartButton from "global/add-to-cart-button";
import CommentsContainer from "global/comments-container";
import ShareButton from "global/actions/share-button";
import ReportButton from "global/actions/report-button";
import LikeButton from "global/actions/like-button";

export default {
    props: {
        item: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            moment: window.moment,
            release: null,
            track: null
        };
    },
    computed: {
        image() {
            if (this.release) {
                return this.release.image;
            } else if (this.track) {
                return this.track.release.image;
            }
        },
        url() {
            return location.href;
        }
    },
    created() {
        this.setItem();
    },
    methods: {
        setItem() {
            switch (this.item.type) {
                case "track":
                    this.track = this.item;
                    break;
                case "release":
                    this.release = this.item;
                    break;
            }
        },
        liked() {
            if (this.release) {
                this.release.is_liked = true;
            } else {
                this.track.is_liked = true;
            }
        },
        unliked() {
            if (this.release) {
                this.release.is_liked = false;
            } else {
                this.track.is_liked = false;
            }
        }
    },
    components: {
        LikeButton,
        ReportButton,
        CommentsContainer,
        PlayPauseButton,
        TrackList,
        AddToCartButton,
        ShareButton,
        SidebarGroup
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";

h1 {
    font-size: 35px;
}
svg {
    cursor: pointer;
}


.main-info {
    display: flex;
    //flex-direction: column;

    @media (max-width: 600px) {
        flex-direction: column;
    }

    @media (max-width: 600px) {
        .release-image {
            .avatar {
                width: 100% !important;
            }
        }
    }
}

a {
    text-decoration: none;
}
.release-label {
    font-weight: bold;
    margin: 0 0 10px;
}
.item-info {
    margin-left: 1em;
    flex: 1;

    @media (max-width: 600px) {
        margin-left: 0;
        margin-top: 2em;
    }
}
.item-info-upper {
    display: flex;

    // @media(max-width: 414px){
    //     padding-right: 2.5em;
    // }
}
.item-info-upper-left {
    flex: 1;
}
h1 {
    margin: 0;

    @media (max-width: 450px) {
        font-size: 30px;
    }

    @media (max-width: 375px) {
        font-size: 28px;
    }

    @media (max-width: 350px) {
        font-size: 26px;
    }
}
.artists-genres {
    font-size: 20px;
    margin: 1em 0;
    color: $color-grey2;
    line-height: 30px;
}
.item {
    color: black;
}
.release-date {
    color: $color-grey2;
}
.date {
    color: black;
}
.release-description {
    margin: 1em 0;
}
.item-info-upper-right {
    font-size: 25px;

    @media (max-width: 1024px) {
        font-size: 21px;
    }

    @media (max-width: 768px) {
        font-size: 18px;
    }

    @media (max-width: 450px) {
        font-size: 16px;
    }

    @media (max-width: 390px) {
        font-size: 14px;
    }
}
table.meta-table {
    width: 100%;
}
td {
    padding: 15px 0;
    text-align: center;
}
.comments {
    margin: 3em 0;
}
</style>
