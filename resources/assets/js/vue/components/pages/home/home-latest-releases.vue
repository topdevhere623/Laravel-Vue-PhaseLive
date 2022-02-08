<template>
    <div>
        <div class="home-latest-releases" v-if="latestReleases">
            <router-link
                class="release"
                :class="{ primary: index === 0 }"
                v-for="(release, index) in latestReleases"
                :key="index"
                :to="getRouterObject(release)"
                :style="
                    'background-image: url(' +
                        release.image.files.original.url +
                        ')'
                "
            />
        </div>

        <spinner
            style="margin: 3em auto;"
            v-else
            :animation-duration="1000"
            :size="80"
            color="black"
        />
    </div>
</template>

<script>
    import { HalfCircleSpinner as Spinner } from "epic-spinners";

    export default {
        name: "home-latest-releases",
        props: ["latest-releases"],
        components: {
            Spinner
        }
    };
</script>

<style lang="scss" scoped>
    .home-latest-releases {
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 80px;

        .release {
            display: block;
            width: 470px;
            @media (max-width: 1000px) {
                width: 40%;
            }
            height: 360px;
            border: 1px solid black;
            background-size: cover;
            background-position: center center;

            &.primary {
                width: 570px;

                @media (max-width: 1000px) {
                    width: 40%;
                }
                height: 400px;
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
            }
        }
    }
</style>
