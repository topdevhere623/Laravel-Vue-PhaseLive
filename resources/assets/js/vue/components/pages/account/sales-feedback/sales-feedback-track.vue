<template>
    <div>
        <h1>My Sales & Feedback for Track</h1>
        <account-menu active="stats"></account-menu>
        <chart name="Total Sales for Track Name" value="total-sales-track-name"></chart>
        <chart name="Activity for Track Name" value="activity-track-name"></chart>
        <h2>Feedback for Track Name</h2>
        <!--<comment v-for="comment in comments" :key="comment.id" :data="comment"></comment>-->
        <comment :data="{user: user.user, created_at: '2018-04-30', body: 'Cool song!'}"></comment>
        <comment :data="{user: user.user, created_at: '2018-04-29', body: 'Awesome!'}"></comment>
        <comment :data="{user: user.user, created_at: '2018-04-25', body: 'Nice track bro'}"></comment>
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    import Menu from '../account-menu';
    import Comment from 'global/comment';
    import Chart from './chart';

    export default {
        data () {
            return {
                comments: []
            }
        },
        computed: mapState([
            'user'
        ]),
        components: {
            'account-menu': Menu,
            Comment,
            Chart,
        }
    }
</script>

<style lang="scss" scoped>

</style>