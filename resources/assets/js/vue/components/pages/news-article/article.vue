<template>
    <div>
        <div v-if="!articleLoaded">
            <spinner style="margin: 3em auto;"
                     :animation-duration="1000"
                     :size="100"
                     color="black"
            />
        </div>
        <div class="page-content-padded page-news-article" v-else>
            <div class="page-main" v-if="articleLoaded">
                <h1 class="centered-text">{{ article.title }}</h1>
                <div class="byline centered-text">

                    Article by <router-link :to="'/user/' + article.user.path" class="blue">{{ article.user.name }}</router-link> in

                    <span v-for="(category, index) in article.categories">
                        <router-link :to="'/news' + category.path" class="blue">{{ category.title }}</router-link><span v-if="article.categories[index + 1]">, </span>
                    </span>

                    - {{ moment(article.published_at).format("MMMM D, YYYY") }}

                    
                </div>
                <div class="actions-wrapper">
                        <actions
                            :actionable="article"
                            @like="commitLike"
                            @unlike="commitUnlike"
                            @share="commitShare"
                    ></actions>
                    </div>
                <div class="cover-img" :style="'background-image: url(' + article.image.files.original.url + ')'"></div>
                <div class="article-body" v-html="article.content">
                </div>
                <div class="article-social">
                    
                    <comments-container :commentable="article" @newComment="newComment" />
                </div>
                <h2 class="related-articles-heading">Related Articles</h2>
                <div class="related-articles">
                    <div class="related-article" v-for="(article, index) in news.articles.slice(0, 2)" :key="index">
                        <related-article :data="article"></related-article>
                    </div>
                </div>
            </div>
            <!-- <aside class="sidebar-right">
                <sidebar-group title="News" :items="news.articles.slice(0, 5)"></sidebar-group>
            </aside> -->
        </div>
    </div>
</template>

<script>
    import store from 'store';
    import { mapState } from 'vuex';
    import { HalfCircleSpinner as Spinner } from 'epic-spinners';

    import SidebarGroup from 'global/sidebar-group';
    import RelatedArticle from '../news-index/article';
    import Actions from 'global/actions/actions';
    import CommentsContainer from "global/comments-container";

    export default {
        data () {
            return {
                moment: window.moment,
                articleLoaded: false,
                article: {},
                commentsLoaded: false,
                comments: [],
            }
        },
        computed: mapState([
            'news',
        ]),
        watch: {
            $route: function() {
                this.fetchArticle()
            }
        },
        beforeRouteEnter (to, from, next) {
            store.dispatch('news/requireArticles').then(() => {
                next();
            });
        },
        // beforeRouteUpdate: function(to, from, next) {
        //     this.fetchArticle().then(() => {
        //         next();
        //     });
        // },
        mounted: function() {
            this.fetchArticle();
        },
        methods: {
            fetchArticle() {
                this.articleLoaded = false;

                axios.get('/api/news/article/' + this.$route.params.article).then((response) => {
                    this.article = response.data;
                    this.articleLoaded = true;
                });
            },
            commitLike() {
                this.article.likes_count += 1;
                this.article.is_liked = true;
                this.$store.commit('news/likeArticle', this.article.id);
            },
            commitUnlike() {
                this.article.likes_count -= 1;
                this.article.is_liked = false;
                this.$store.commit('news/unlikeArticle', this.article.id);
            },
            commitShare() {
                this.article.shares_count += 1;
                this.article.is_shared = true;
                this.$store.commit('news/shareArticle', this.article.id);
            },
            newComment() {
                this.article.comments_count += 1;
            }
        },
        components: {
            CommentsContainer,
            SidebarGroup,
            RelatedArticle,
            Spinner,
            Actions,
        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";

    @media(max-width: 350px){
        .page-content-padded{
            display: block;
        }
    }

    .page-news-article {

        h1 {
            font-size: 53px;

            @media(max-width: 420px){
                font-size: 40px;
            }
        }

        .byline {
            color: $color-grey2
        }
        .cover-img {
            width: 100%;
            height: 350px;
            background-position: center center;
            background-size: cover;
        }
        .actions-wrapper {
            display:flex;
            align-items: center;
            justify-content: center;
        }
        .article-body {
            width: 70%;
            margin: 50px auto;

            p {
                margin: 1em 0;
                line-height: 150%;
                font-size: 15px;
            }
        }
        h2.related-articles-heading {
            text-align: center;
            margin: 2em 0;
        }

        .related-articles {
            width: 60%;
            // min-width: 700px;
            margin: 0 auto;
            overflow: auto;

            @media(max-width: 1140px){
                width: 100%!important;
            }

            @media(max-width: 664px){
                display: grid;
                justify-content: center;

                .related-article{
                    margin-right: 0px!important;
                }
            }

            @media(max-width: 350px){
                overflow: hidden;
            }

            
        }





        .related-article {
            lost-column: 1/2;

            // margin-right: 0px!important;
        }
        .article-social .sharing {
            margin: 10em 0 4em;
        }
        .actions {
            margin: 1em 0 3em;
        }
    }
</style>