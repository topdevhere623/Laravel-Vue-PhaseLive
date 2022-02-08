<template>
    <router-link class="artist-tile" :to="getRouterObject(user)">
        <div class="artist-tile-image">
            <avatar :tile="true" :size="size" :src="user.avatar.files.medium.url" :recent="user.is_recent" ></avatar>
        </div>
        <div class="artist-tile-text">
            <p class="artist-name">{{ user.name }}</p>
        </div>
    </router-link>
</template>

<script>
    import Avatar from 'global/avatar';
    export default {
        props: {
            size: Number,
            user: Object,
        },
        components: {
            Avatar
        },
    }
</script>

<style lang="scss" scoped>
    .artist-tile {
        text-decoration: none;
    }
    .artist-tile-text {
        text-align: left;
        margin: 1em 0;
    }
    .artist-name {
        text-align: left;
        font-size: 12px;
        margin-bottom:5px;
        font-weight: bold;
    }

    .uploaded-by {
        font-size: 11px;
        text-align: left;
    }
</style>

<style lang="css">
.artist-tile-image > div {
    width: 100% !important;
}
</style>