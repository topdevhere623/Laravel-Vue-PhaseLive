<template>
    <div :class="'masonry-item ' + item.component">
        <router-link
            :to="getRouterObject(item)"
            
        >
            <img
                :src="imgUrl"
                :alt="this.item.name"
                class="masonry-image masonry-image-release"
            />
            <div class="masonry-inner masonry-inner-fixed">
                <h4>Event</h4>
                <h2>{{ item.name }}</h2>
                <h3>
                    <span>{{ item.location }}</span>
                </h3>
                <div class="date-xxl">
                    {{ moment(item.date).format("MMM Do") }}
                </div>
            </div>
        </router-link>
    </div>
</template>

<script>
    export default {
        name: "DiscoveryEvent",
        props: { item: Object },
        data() {
            return {
                moment: window.moment,
                imgUrl:
                    "https://phase-website.s3.eu-west-2.amazonaws.com/covers/aWXVxy8BSzc-MRreMdS67FP9TeGHWqYayfu3BvNWYkij.jpg",
            };
        },
    };
</script>

<style lang="scss" scoped>
    .feed-event {
        min-height: 140px;
        transition: background-color 0.5s ease-in-out;
        background: grey;
        img.masonry-image {
            transition: opacity 0.5s ease-in-out;
            opacity: 0.8;
            overflow: hidden;
            // max-height: 140px;
        }

        .date-xxl {
            color: #fff;
            font-size: 2.4rem;
            margin-top: 0px;
            margin-left: 15px;
            font-weight: 300;
            letter-spacing: -1px;
        }
    }

    .discovery-event:hover img.masonry-image {
        opacity: 0.6;
    }

    .masonry-item h4 {
        color: #fff;
    }

    .masonry-item h2 {
        color: #fff;
    }
</style>
