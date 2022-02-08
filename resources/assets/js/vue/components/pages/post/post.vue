<template>
    <div class="page-content-padded" v-if="post">
        <div class="page-main page-post">
            <div class="main-info">
                <router-link :to="'/user/' + app.user.path" v-if="post">
                    <div class="post-image">
                        <div class="post-label">
                            Go back to profile
                        </div>
                        <avatar :src="post.user.avatar.files.medium.url" :size="300" :tile="true" :center="false" />
                    </div>
                </router-link>
                <div class="item-info">
                    <div class="item-info-upper">
                        <div class="item-info-upper-left">
                            <h1>
                                {{ post.user.name }}
                            </h1>
                            <div class="post-body">
                                {{ post.body }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="comments">
                <comments-container :commentable="post" />
            </div>
        </div>
        <aside class="sidebar-right">
            
        </aside>
    </div>
    <spinner style="margin: 3em auto;" v-else
             :animation-duration="1000"
             :size="80"
             color="black"
    />
</template>

<script>
    import { mapState } from 'vuex';
    import store from 'store';
    import { HalfCircleSpinner as Spinner } from 'epic-spinners'
    import CommentsContainer from "global/comments-container";
    export default {
        data () {
            return {
                post: null,
            }
        },
        created: function() {
            this.fetchPost();
        },
        methods: {
            fetchPost() {
                axios.get('/api/post/' + this.$route.params.postid).then(response => {
                    this.post = response.data;
                    console.log(this.post);
                });
            }
        },
        components: {
            Spinner,
            CommentsContainer,
        },
        computed: mapState([
            'app',
        ]),
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";

    h1 {
        font-size: 35px;
    }

    .page-post {
        padding: 3em;
    }
    .main-info {
        display: flex;
        //flex-direction: column;
    }
        a {
            text-decoration: none;
        }
        .post-label {
            font-weight: bold;
            margin: 0 0 10px;
        }
        .item-info {
            margin-left: 1em;
            flex: 1;
        }
            .item-info-upper {
                display: flex;
            }
                .item-info-upper-left {
                    flex: 1;
                }
                    h1 {
                        margin: 0;
                    }
                    .post-body {
                        font-size: 20px;
                        margin: 1em 0;
                        color: $color-grey2;
                        line-height: 30px;
                    }
        td {
            padding: 15px 0;
            text-align: center;
        }
    .comments {
        margin: 3em 0;
    }
</style>