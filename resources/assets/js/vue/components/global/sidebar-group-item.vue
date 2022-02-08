<template>
    <router-link :to="url" class="sidebar-group-item">
        <div class="sgi-upper">
            <avatar
                class="sgi-image"
                :tile="true"
                :size="70"
                :src="imageSrc"
                alt=""
                :center="false"
                :recent="item.is_recent"
            />
            <div class="sgi-info">
                <div class="sgi-title">{{ title }}</div>
                <div class="sgi-date" v-if="item.type !== 'event'">
                    {{ moment(item.created_at).format("MMMM D, YYYY") }}
                </div>
            </div>
        </div>
    </router-link>
</template>

<script>
import Actions from "global/actions/actions";
import Avatar from "global/avatar";

export default {
    props: {
        item: {
            type: Object,
            default: function() {
                return {
                    title: "",
                    comments_count: 0,
                    likes_count: 0,
                    shares_count: 0,
                    published_at: null,
                    image: {
                        files: {
                            original: {
                                url: null
                            }
                        },
                        alt: null
                    }
                };
            }
        }
    },
    data() {
        return {
            moment: window.moment
        };
    },
    computed: {
        url() {
            let url;

            switch (this.item.type) {
                case "news":
                    return "/article/" + this.item.path;
                    break;

                case "merch":
                    return "/user/" + this.item.user.path + "/merch";
                    break;

                case "user":
                    return "/user/" + this.item.path;
                    break;

                case "post":
                    return "#";
                    break;

                case "release":
                    return `/release/${this.item.slug}`
                    break;

                case "track":
                    return `/track/${this.item.slug}`
                    break;

                case "event":
                    return `/user/${this.item.user.path}/events`
                    break;

                default:
                    return "/";
            }
        },
        imageSrc() {
            switch (this.item.type) {
                case "user":
                    return this.item.avatar.files.thumb.url;
                    break;

                case "track":
                    return this.item.release.image.files.medium.url;
                    break;

                case "news":
                    return this.item.image.files.original.url;
                    break;

                case "post":
                    return this.item.user.avatar.files.thumb.url;
                    break;
                
                case "event":
                    return this.item.image.files.thumb.url

                default:
                    return this.item.image.files.original.url;
            }
        },
        title() {
            switch (this.item.type) {
                case "user":
                case "release":
                case "track":
                case "event":
                    return this.item.name.trunc(40);
                    break;

                case "post":
                    return this.item.title;
                    break;

                default:
                    return this.item.title.trunc(40);
            }
        }
    },
    created: function() {},
    components: {
        Avatar
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/helpers/_variables.scss";
// GROUP ITEM
.sidebar-group-item {
    display: block;
    margin: 2em 0;
    font-weight: bold;
    letter-spacing: 1px;
}
.sgi-upper {
    display: flex;
    margin-bottom: 0.5em;
}
.sgi-image {
    margin-right: 10px;
}
.sgi-info {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}
.sgi-title {
    font-size: 12px;
    color: $color-blue;
    line-height: 120%;
}
.sgi-date,
.sgi-lower {
    font-size: 7px;
}
</style>
