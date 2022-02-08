<template>
    <post v-if="itemIs('post')" :post="item" :id="id" />
    <release v-else-if="itemIs('release')" :release="item" />
    <p-track v-else-if="itemIs('track')" :track="item" />
    <asset v-else-if="itemIs('asset')" :asset="item" />
    <user v-else-if="itemIs('user')" :user="item" />
    <news v-else-if="itemIs('news')" :news="item" />
    <event v-else-if="itemIs('event')" :event="item" />
    <share v-else-if="itemIs('share')" :share="item" />
    <p-video v-else-if="itemIs('video')" :video="item" />
    <merch v-else-if="itemIs('merch')" :merch="item" />
</template>

<script>
    import Post from './post';
    import Release from './release';
    import PTrack from './track';
    import Asset from './asset';
    import User from './user';
    import News from './news';
    import Event from './event';
    import Share from './share';
    import PVideo from './video';
    import Merch from './merch';

    export default {
        props: {
            item: {
                type: Object,
                required: true,
            },
            share: {
                type: Object,
                default: null,
            },
          id: {
              type: Number,
              default: null
          }
        },
        methods: {
            itemIs(type) {
                return this.item.type === type;
            }
        },
        components: {
            Post,
            Release,
            PTrack,
            Asset,
            User,
            News,
            Event,
            Share,
            PVideo,
            Merch,
        }
    }
</script>

<style lang="scss">

</style>
