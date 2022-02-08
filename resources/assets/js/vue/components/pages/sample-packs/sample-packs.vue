<template>
    <div class="page-content-padded page-news-index">
        <div class="page-main">
            <div v-if="genre">
                <h2>{{ genre.name }} Samples</h2>

                <div v-for="item in items" :key="item.id">
                    <div class="p-item">
                        <div class="p-item-image">
                            <router-link
                                :to="{name: 'sample_single', params: { releaseid: item.id }}"
                            >
                                <avatar :size="130"
                                    :src="item.image.files.thumb.url"
                                    :tile="true"
                                />
                            </router-link>
                        </div>
                        <div class="p-item-main">
                            <div class="p-item-detail">
                                <div class="p-item-title">
                                    <router-link
                                        :to="{name: 'sample_single', params: { releaseid: item.id }}"
                                        style="text-decoration: none;"
                                    >
                                        <span>{{ item.name }}</span>
                                    </router-link>
                                </div>
                            </div>
                            <div class="release-description">
                                {{ item.description }}
                            </div>
                            <div class="p-item-meta">
                                <actions :actionable="item"></actions>
                                <div class="p-item-time">
                                    {{ moment(item.release_date).fromNow() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <release :v-if="item.type === 'release'" :release="item"></release> -->
                </div>
            </div>
            <spinner style="margin: 3em auto;" v-else
             :animation-duration="1000"
             :size="80"
             color="black"
            />
            <div style="margin: 4em 0" class="centered-text" v-if="hasAnotherPage && items.length">
                <ph-button size="large" @click.native="loadNextPage" :loading="loadingNextPage">
                    Show Me More
                </ph-button>
            </div>
        </div>

        <aside class="sidebar-right">
            <sidebar-group title="News" :items="news.articles.slice(0, 5)"></sidebar-group>
        </aside>
    </div>
</template>

<script>
  import { mapState } from 'vuex';
  import SidebarGroup from 'global/sidebar-group';
  import { HalfCircleSpinner as Spinner } from 'epic-spinners'
  import store from 'store';
  import Actions from 'global/actions/actions'
  import Release from '../../global/items/release.vue'

  export default {
    data () {
        return {
            genre: null,
            loadingNextPage: false,
            currentPage: 1,
            totalPages: 0,
            items: [],
            moment: window.moment,
        }
    },
    mounted: function() {
        this.fetchSamples();
    },
    components: {
        SidebarGroup,
        Spinner,
        Release,
        Actions,
    },

    computed: {
        hasAnotherPage() {
            if (this.totalPages === 0) return true;
            return (this.currentPage < this.totalPages);
        },
        ...mapState([
            'app',
            'news'
        ]),
    },

    methods: {
        fetchSamples() {
            axios.get('/api/samples/genre/' + this.$route.params.genreid).then(response => {
                this.genre = response.data.genre;
                this.currentPage = response.data.items.current_page;
                this.totalPages = response.data.items.last_page;
                this.items = response.data.items.data;
            });
        },
        loadNextPage: function() {
            // if(!this.hasAnotherPage) return;
            this.loadingNextPage = true;
            axios.get(`/api/samples/genre/${this.$route.params.genreid}?page=${this.currentPage + 1}`).then(response => {
                this.currentPage = response.data.items.current_page;
                this.totalPages = response.data.items.last_page;
                this.items.push(...response.data.items.data);
                this.loadingNextPage = false;
            });
        }
    }
  }
</script>

<style>

</style>
