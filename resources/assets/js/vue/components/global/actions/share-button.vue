<template>
    <span class="share-button" v-if="app.user.loggedin" :title="'Share ' + mutableShareable.type" @click="showShareModal" :class="{ shared : mutableShareable.is_shared }">
        <span>
            <i class="fa fa-share"></i>
            <span v-if="showTitle">Share</span>
        </span>
    </span>
</template>

<script>
    import { SocialEvents } from "events";
    import { mapState } from 'vuex';

    export default {
        props: {
            shareable: { // This is the object e.g. 'track', 'release', 'article'
                type: Object,
                required: true,
            },
            showTitle: {
                type:Boolean,
                default:false,
            },
        },
        data () {
            return {
                mutableShareable: this.shareable,
            }
        },
        computed: mapState([
            'app',
        ]),
        mounted() {
            SocialEvents.$on('shared', shareable => {
                if(shareable.id === this.mutableShareable.id) {
                    this.share();
                }
            });
        },
        methods: {
            showShareModal() {
                this.$modal.show('modal-share', { shareable: this.shareable });
            },
            share() {
                this.$emit('share');
            }
        },
        components: {

        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    .share-button {
        cursor: pointer;
    }
    .shared {
        color: $color-blue2;
    }
</style>