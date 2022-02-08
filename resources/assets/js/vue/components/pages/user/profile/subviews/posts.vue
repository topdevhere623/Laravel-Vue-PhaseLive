<template>
    <div>
        <spinner style="margin: 3em auto;"
                 :animation-duration="1000"
                 :size="60"
                 color="black"
                 v-show="loadingPosts"
        />
        <feed-action v-for="post in posts"
                     :action="post"
                     :this-user="mutableUser"
                     :key="post.id" />
    </div>
</template>

<script>
    import ProfileMixin from '../profile-mixin';
    import { HalfCircleSpinner as Spinner } from 'epic-spinners';
    import FeedAction from '../partials/feed-action';


    export default {
        data () {
            return {
                loadingPosts: false,
                posts: [],
            }
        },
        created: function() {
            this.fetchPosts();
        },
        methods: {
            fetchPosts() {
                this.loadingPosts = true;
                axios.get('/api/user/' + this.user.id + '/posts').then(response => {
                    this.posts = response.data;
                }).finally(() => {
                    this.loadingPosts = false;
                });
            }
        },
        mixins: [
            ProfileMixin
        ],
        components: {
            FeedAction,
            Spinner
        }
    }
</script>

<style lang="scss" scoped>

</style>
