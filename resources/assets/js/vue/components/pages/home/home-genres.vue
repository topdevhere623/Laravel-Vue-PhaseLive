<template>
    <div class="grid">
        <div class="grid_item" :key="item.id" v-for="item in genres">
            <router-link :to="getRouterObject(item)">
                <img
                    src="https://images.unsplash.com/photo-1468164016595-6108e4c60c8b?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                    alt=""
                />
                <div class="content">
                    <p class="type">{{ item.type }}</p>
                    <p class="name">{{ item.name || item.title }}</p>
                </div>
                <div class="overlay"></div>
            </router-link>
        </div>
    </div>
</template>

<script>
    import { HalfCircleSpinner as Spinner } from "epic-spinners";
    import SplitGridHome from "../../global/split-grid-home";
    import Overlay from "../../global/overlay";

    export default {
        name: "home-genres",
        props: ["genres"],
        components: {
            Spinner,
            SplitGridHome,
            Overlay
        },
        methods: {
            genreItems(genre) {
                if (genre.tracks) {
                    return genre.tracks.slice(0, 10);
                }
                if (genre.releases) {
                    return genre.releases.slice(0, 10);
                }
            }
        }
    };
</script>

<style lang="scss" scoped>
    .grid {
        display: grid;
        grid-gap: 3.8px;
        grid-template-areas:
            "img1 img2 img3 img3"
            "img1 img4 img5 img5";
        height:450px;

        @media (max-width: 768px) {
            grid-template-areas:
                "img1 img1 img2 "
                "img3 img3 img4 "
                "img5 img5 img4 ";
        }

        @media (max-width: 650px) {
            grid-template-areas:
                "img1 img2"
                "img1 img3"
                "img4 img5";
        }
    }
    .grid_item {
        position: relative;
        height: 100%;
        width: 100%;
        overflow: hidden;

        &:first-child {
            grid-area: img1;
        }

        &:nth-child(2) {
            grid-area: img2;
        }

        &:nth-child(3) {
            grid-area: img3;
        }

        &:nth-child(4) {
            grid-area: img4;
        }

        &:nth-child(5) {
            grid-area: img5;
        }

        img {
            object-fit: cover;
            height: 100%;
            width: 100%;
        }

        div.content {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            z-index: 1;
            color: #fff;

            .type {
                color: #9eefe1;
                font-family: Comfortaa;
                font-size: 12.5px;
                font-weight: bold;
                font-stretch: normal;
                font-style: normal;
                letter-spacing: 0.63px;
                margin-bottom: 10px;
                text-transform: capitalize;
            }
        }

        div.overlay {
            background: linear-gradient(
                180deg,
                rgba(0, 0, 0, 1) 0%,
                rgba(255, 255, 255, 0) 100%
            );
            position: absolute;
            top: 0px;
            left: 0px;
            right: 0px;
            bottom: 0px;
            height: 50%;
        }
    }
</style>
