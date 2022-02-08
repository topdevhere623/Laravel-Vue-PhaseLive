<template>
    <div class="grid">
        <div class="grid_item" :key="item.id" v-for="item in data">
            <router-link :to="getRouterObject(item)">
                {{ item.type }}
                {{ item.name || item.title }}
            </router-link>
        </div>
    </div>
</template>

<script>
    import Overlay from "../global/overlay";

    export default {
        components: { Overlay },
        name: "split-grid",
        props: ["data", "type"],
        methods: {
            getParentRoute(type) {
                switch (type) {
                    case "Genres":
                        return { name: "genres" };
                    case "Latest News":
                        return { name: "news" };
                }
            }
        }
    };
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";

    .grid {
        display: grid;
        grid-template-areas:
            "img1 img2 img3"
            "img1 img4 img5";
    }
    .grid_item {
        position: relative;
        height: 100%;
        padding: 10px;
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
    }
</style>
