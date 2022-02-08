<template>
    <div>
        <add-text type="post" :addTextAble="user" @success="addStatusUpdate" />
        <spinner
            style="margin: 3em auto;"
            :animation-duration="1000"
            :size="60"
            color="black"
            v-show="loadingActivity"
        />
        <feed-action
            v-for="(action, index) in activity"
            :index="index"
            :action="action"
            :this-user="mutableUser"
            :key="index"
            v-on:delete-action="fetchActivity"
        />
    </div>
</template>

<script>
    import ProfileMixin from '../profile-mixin';
    import AddText from 'global/add-text/add-text';
    import FeedAction from '../partials/feed-action';

    import { HalfCircleSpinner as Spinner } from 'epic-spinners';
    import {SocialEvents} from "../../../../../event-bus";

    export default {
        data () {
            return {

            }
        },
        created: function() {
            this.fetchActivity();
            SocialEvents.$on('delete-action', this.fetchActivity)
        },
        methods: {
            addStatusUpdate(action) {
                this.activity.unshift(action)
            }
        },
        mixins: [
            ProfileMixin
        ],
        components: {
            FeedAction,
            AddText,
            Spinner
        }
    }
</script>

<style lang="scss" scoped>

</style>
