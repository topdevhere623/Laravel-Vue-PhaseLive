<template>
    <div class="news-index-article">
        <router-link :to="'/article/' + data.path">
            <div class="news-index-article-image" :style="'background-image: url(' + data.image.files.original.url + ')'"></div>
        </router-link>
        <div class="news-index-article-info">
            <router-link :to="'/article/' + data.path">
                <h2>{{ data.title }}</h2>
            </router-link>
            <div class="index-article-info-meta">
                Article by <router-link :to="'/user/' + data.user.path" class="blue">{{ data.user.name }}</router-link> in

                <span v-for="(category, index) in data.categories">
                    <router-link :to="'/news' + category.path" class="blue">{{ category.title }}</router-link><span v-if="data.categories[index + 1]">, </span>
                </span>
                <br />

                {{ moment(data.published_at).format("MMMM D, YYYY") }}
            </div>
            <actions
                    :actionable="data"
                    @like="commitlike"
                    @unlike="commitunlike"
                    @share="commitShare"
            ></actions>
        </div>
    </div>
</template>

<script>
    import Actions from 'global/actions/actions';

    import moment from 'moment';

    export default {
        props: ['data'],
        data () {
            return {
            }
        },
        created: function() {

        },
        methods: {
            moment(dateString) {
                return moment(dateString);
            },
            commitlike() {
                this.$store.commit('news/likeArticle', this.data.id);
            },
            commitunlike() {
                this.$store.commit('news/unlikeArticle', this.data.id);
            },
            commitShare() {
                this.$store.commit('news/shareArticle', this.data.id);
            }
        },
        components: {
            'actions': Actions
        }
    }
</script>

<style lang="scss" scoped>
    @import "~styles/helpers/_variables.scss";
    .news-index-article {
        width: 310px;
        height: 500px;
        background: $color-grey;
        margin: 0 auto 10px;

        display: flex;
        flex-direction: column;

        @media(max-width: 414px){
            height: auto;
        }

        a {
            text-decoration: none;
        }
    }
    .news-index-article-image {
        height: 250px;
        background-position: center center;
        background-size: cover;
    }
    .news-index-article-info {
        flex: 1;
        padding: 1em;

        display: flex;
        flex-direction: column;
        justify-content: space-between;

        @media(max-width: 340px){
            padding: 1.5em;
        }
        
        h2 {
            font-size: 21px;
            margin: 0;
            flex: 1;
        }
    }



    .index-article-info-meta {
        line-height: 150%;
        color: $color-grey2;
        font-size: 13px;
        margin: 10px 0;
    }
</style>